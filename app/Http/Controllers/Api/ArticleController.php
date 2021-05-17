<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VoteRequest;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticlesResource;
use App\Jobs\CreateArticle;
use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ArticlesResource
     */
    public function index(): ArticlesResource
    {
        $articles = Article::withcount(
            'views',
        )->orderBy(
            'created_at',
            'DESC'
        )->take(50)->paginate(10);

        return new ArticlesResource($articles);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return ArticleResource
     */
    public function show(Article $article): ArticleResource
    {
        ArticleResource::withoutWrapping();

        return new ArticleResource(
            $article
        );
    }

    public function store(ArticleRequest $request): JsonResponse
    {
        $article = $this->dispatchNow(CreateArticle::fromRequest($request));

        return new JsonResponse($article->slug);
    }

    /**
     * @param VoteRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function vote(VoteRequest $request): JsonResponse
    {
        $article = Article::findOrFail($request->id);
        ($request->type === 'up')
            ? self::upOrDownVote($request->user(), $article)
            : self::upOrDownVote(
                $request->user(),
                $article,
                'down'
            );

        return response()->json(['result' => 'true']);
    }

    public static function upOrDownVote(User $user, $target, string $type = 'up'): bool
    {
        $hasVoted = $user->{'has' . ucfirst($type) . 'Voted'}($target);
        DB::beginTransaction();

        try {
            $user->{$type . 'Vote'}($target);
            if ($hasVoted) {
                $user->cancelVote($target);
                foreach ($target->hubs as $hub) {
                    $type === 'up' ? $hub->rating-- : $hub->rating++;
                    $hub->save();
                }
                if ($type === 'up') {
                    $target->creator->rating--;
                    $target->creator->karma--;
                } else {
                    $target->creator->rating++;
                    $target->creator->karma++;
                }
                $target->creator->save();
                DB::commit();

                return false;
            }
            foreach ($target->hubs as $hub) {
                $type === 'up' ? $hub->rating++ : $hub->rating--;
                $hub->save();
            }
            if ($type === 'up') {
                $target->creator->rating++;
                $target->creator->karma++;
            } else {
                $target->creator->rating--;
                $target->creator->karma--;
            }
            $target->creator->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            abort(500);
        }

        return true;
    }
}

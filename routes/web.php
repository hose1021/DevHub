<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserSettingsController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatusController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);
Route::get('login/github', [LoginController::class, 'github']);
Route::get('login/github/redirect', [LoginController::class, 'githubRedirect']);
//Route::get('/forgot-password', function () {
//    return view('auth.forgot-password');
//})->middleware('guest')->name('password.request');
Route::get(
    'lang/{locale}',
    function ($locale) {
        if (in_array($locale, config('app.locales'))) {
            cache()->put('lang', $locale);
        }
        Carbon::setLocale(config('app.locale'));

        return redirect()->back();
    }
);

Route::get('/', [HomeController::class, 'articlesApiRoute'])->name('home');
Route::get('top/week', [HomeController::class, 'articlesApiRoute'])->name('top.week');
Route::get('top/month', [HomeController::class, 'articlesApiRoute'])->name('top.month');
Route::get('all', [HomeController::class, 'articlesApiRoute'])->name('all');

//Auth routes
Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::get('favorite', [HomeController::class, 'articlesApiRoute'])->name('favorite');
        Route::get('tracker', [Auth::class, 'index'])->name('tracker');
        Route::get('tracker/remove/all', [Auth::class, 'deleteAll'])->name('delete-all-trackers');

        Route::prefix('saved')->group(
            function () {
                Route::get('/articles', [Auth::class, 'indexPosts'])->name('saved-articles');

                Route::get('/comments', [Auth::class, 'indexComments'])->name('saved-comments');
            }
        );

        Route::prefix('settings')->group(
            function () {
                Route::get('/', [UserSettingsController::class, 'index'])->name('profile-settings');
                Route::get('destroy', [UserSettingsController::class, 'destroy'])->name('destroy-settings');
                Route::post('profile', [UserSettingsController::class, 'update']);
                Route::post('avatar', [UserSettingsController::class, 'update_avatar']);
            }
        );
    }
);

// Articles view
Route::group(
    ['prefix' => 'article'],
    function () {
        Route::get('create', [ArticleController::class, 'create'])->name('article.create');
        Route::get('{article_show}', [ArticleController::class, 'show'])->name('article.show')->middleware('session');
        Route::get('{article_show}/edit', [ArticleController::class, 'edit'])->name('article.edit');
        Route::put('{article_show}', [ArticleController::class, 'update'])->name('article.update');
        Route::delete('{article_show}', [ArticleController::class, 'delete'])->name('article.delete');
        Route::post('/{article_show}/favorite', [ArticleController::class, 'favorite']);
    }
);

// Hubs view
Route::group(
    ['prefix' => 'hubs'],
    function () {
        Route::get('/', [HubController::class, 'index'])->name('hubs-list');
        Route::get('/{slug}', [HubController::class, 'show']);
        Route::get('/{slug}/top/week', [HubController::class, 'show'])->name('hubs.week');
        Route::get('/{slug}/top/month', [HubController::class, 'show'])->name('hubs.month');
        Route::get('/{slug}/all', [HubController::class, 'show'])->name('hubs.all');
    }
);

//Search view
Route::group(
    ['prefix' => 'search', 'as' => 'search.'],
    function () {
        Route::get('articles', [SearchController::class, 'articles'])->name('articles');
        Route::get('authors', [SearchController::class, 'authors'])->name('authors');
    }
);

//Users view
Route::prefix('authors')->group(
    static function () {
        Route::get('/', [AuthorController::class, 'userList'])->name('users-list');
        Route::post('{profileId}/follow', [ProfileController::class, 'follow']);
//        TODO: ADD LINK FAVORITE (ProfileController)
    }
);
Route::group(
    ['prefix' => '@{username}'],
    function () {
        Route::get('articles', [AuthorController::class, 'showArticles'])->name('user_articles');
        Route::get('/', [AuthorController::class, 'showInfo'])->name('user_info');
        Route::get('followers', [AuthorController::class, 'showFollowers'])->name('user_followers');
        Route::get('followings', [AuthorController::class, 'showFollowings'])->name('user_followings');
        Route::get('favorites', [ProfileController::class, 'favorites']);
    }
);

//About view
Route::get('about', [AboutController::class, 'index'])->name('about');

Route::view('release-notes', 'pages.release-notes')->name('release-notes');

// Admin
Route::group(
    ['prefix' => 'admin', 'as' => 'admin'],
    function () {
        Route::get('/', [AdminController::class, 'index']);

        //Logs
        Route::get('logs', [AdminController::class, 'logs'])->name('.logs');
        // Users
        Route::get('users/{username}', [UsersController::class, 'show'])->name('.users.show');
        Route::put('users/{username}/ban', [UsersController::class, 'ban'])->name('.users.ban');
        Route::put('users/{username}/unban', [UsersController::class, 'unban'])->name('.users.unban');
        Route::delete('users/{username}', [UsersController::class, 'delete'])->name('.users.delete');

//    // Articles
//    Route::get('articles', [AdminArticlesController::class, 'index'])->name('.articles');
//    Route::put('articles/{article_show}/approve', [AdminArticlesController::class, 'approve'])->name('.articles.approve');
//    Route::put('articles/{article_show}/disapprove', [AdminArticlesController::class, 'disapprove'])->name('.articles.disapprove');
//    Route::put('articles/{article_show}/pinned', [AdminArticlesController::class, 'togglePinnedStatus'])->name('.articles.pinned');
    }
);

// Popover
Route::group(
    ['prefix' => 'popover'],
    function () {
        Route::get('author/{id}', [AuthorController::class, 'popover']);
    }
);

//Devhub alive status
Route::group(
    ['prefix' => 'status'],
    function () {
        Route::get('ping', [StatusController::class, 'ping']);
    }
);

Route::get('feedback', [ContactController::class, 'show']);
Route::post('feedback', [ContactController::class, 'send'])->name('feedback');

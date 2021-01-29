<?php

//    Route::post('post/image/cache', 'Api\PostController@upload_image');
//Route::middleware('auth')->get('articles_filter/favorite', 'Api\ArticleTopController@favorite');

Route::post('auth/checkEmail', 'Auth\LoginController@checkEmail');

Route::prefix('articles')->group(
    function () {
        Route::get('/', 'Api\ArticleController@index')->middleware('api')->name('articles.index');
        Route::post('/', 'Api\ArticleController@store')->middleware('auth:api');
        Route::post('/vote', 'Api\ArticleController@vote')->middleware('auth:api');
        Route::get('/{article}', 'Api\ArticleController@show')->middleware('api')->name('articles.show');
        Route::prefix('filter')->group(
            function () {
                Route::get('day', 'Api\ArticleTopController@posts');
                Route::get('week', 'Api\ArticleTopController@posts');
                Route::get('month', 'Api\ArticleTopController@posts');
                Route::get('favorite', 'Api\ArticleTopController@favorite')->middleware('auth:api');
            }
        );

        Route::get(
            '{article}/relationships/author',
            ['uses' => 'Api\ArticleRelationshipController' . '@author', 'as' => 'articles.relationships.author']
        );
        Route::get(
            '{article}/author',
            ['uses' => 'Api\ArticleRelationshipController' . '@author', 'as' => 'articles.author']
        );
        Route::get(
            '{article}/relationships/comments',
            ['uses' => 'Api\ArticleRelationshipController' . '@comments', 'as' => 'articles.relationships.comments']
        );
        Route::get(
            '{article}/comments',
            ['uses' => 'Api\ArticleRelationshipController' . '@comments', 'as' => 'articles.comments']
        );
        Route::get(
            '{article}/relationships/hubs',
            ['uses' => 'Api\ArticleRelationshipController' . '@hubs', 'as' => 'articles.relationships.hubs']
        );
        Route::get(
            '{article}/hubs',
            ['uses' => 'Api\ArticleRelationshipController' . '@hubs', 'as' => 'articles.hubs']
        );
    }
);

/**
 * Comments Api.
 */
Route::apiResource('comments', 'Api\CommentController');

/*
 * Favorite Api
 */
Route::prefix('saved')->group(
    function () {
        Route::get('posts', 'Api\SavedController@allPosts');
        Route::get('comments', 'Api\SavedController@allComments');
    }
);

/*
 * Hubs Api
 */
Route::prefix('hubs')->group(
    function () {
        Route::get('/', 'Api\HubController@index')->middleware('api')->name('hubs.api.index');
        Route::get('/{hub}', 'Api\HubController@show')->middleware('api')->name('hubs.api.show');
        Route::get('/filter/all', 'Api\HubController@all')->middleware('api')->name('hubs.api.all');
        Route::get('{hub}/top/day', 'Api\ArticleHubController@articles');
        Route::get('{hub}/top/week', 'Api\ArticleHubController@articles');
        Route::get('{hub}/top/month', 'Api\ArticleHubController@articles');
        Route::get('{hub}/all', 'Api\ArticleHubController@all');
        Route::post('/follow/{id}', 'Api\HubController@follow');
    }
);
Route::get('/search_hub', 'Api\HubController@search_hub_by_key');

/*
 * Author Api
 */

Route::apiResource('/authors', 'Api\AuthorController');
Route::prefix('authors')->group(
    function () {
        Route::get('{id}/follow_check', 'Api\AuthorController@userFollowCheck');
        Route::get('{id}/followings', 'Api\AuthorController@followings');
        Route::get('{id}/followers', 'Api\AuthorController@followers');
    }
);
Route::get('/search_user', 'Api\AuthorController@search_user_by_key');

/*
 * Profile Api
 */
//    Route::get('/users/{id}/posts', 'Api\UserController@posts');
//    Route::post('/users/{id}/profile_update', 'Api\UserController@upload');

/**
 * Search Api.
 */
Route::get('search{search?}', 'Api\SearchController@results');

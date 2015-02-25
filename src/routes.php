<?php
if (!isset($routebase) || !isset($viewController) || !isset($postController)) {
	throw new Exception ('This file can\'t be included outside of ForumServiceProvider@boot!');
}

if (class_exists('\LaravelLocalization')) {
	\Route::group(array('prefix' => \LaravelLocalization::setLocale()),  function() use ($routebase, $viewController, $postController){
		/*
		 *  Defines routes used by Forum controller
		 */
		\Route::get($routebase, array('as' => 'forum', 'uses' => $viewController.'@getIndex'));
		\Route:: get($routebase.'{categoryId}-{categoryUrl}', $viewController.'@getCategory');
		\Route:: get($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}', $viewController.'@getTopic');

		\Route:: get($routebase.'{categoryId}-{categoryUrl}/new', $postController.'@getNewTopic');
		\Route::post($routebase.'{categoryId}-{categoryUrl}/new', $postController.'@postNewTopic');

		\Route:: get($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/new', $postController.'@getNewMessage');
		\Route::post($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/new', $postController.'@postNewMessage');

		\Route:: get($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/edit/{messageId}', $postController.'@getEditMessage');
		\Route::post($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/edit/{messageId}', $postController.'@postEditMessage');
	});
} else {
	\Route::get($routebase, array('as' => 'forum', 'uses' => $viewController.'@getIndex'));
	\Route:: get($routebase.'{categoryId}-{categoryUrl}', $viewController.'@getCategory');
	\Route:: get($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}', $viewController.'@getTopic');

	\Route:: get($routebase.'{categoryId}-{categoryUrl}/new', $postController.'@getNewTopic');
	\Route::post($routebase.'{categoryId}-{categoryUrl}/new', $postController.'@postNewTopic');

	\Route:: get($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/new', $postController.'@getNewMessage');
	\Route::post($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/new', $postController.'@postNewMessage');

	\Route:: get($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/edit/{messageId}', $postController.'@getEditMessage');
	\Route::post($routebase.'{categoryId}-{categoryUrl}/{topicId}-{topicUrl}/edit/{messageId}', $postController.'@postEditMessage');
}
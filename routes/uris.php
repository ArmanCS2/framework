<?php


uri('admin/dashboard', 'App\Http\Controllers\Admin\Dashboard', 'index');
uri('admin', 'App\Http\Controllers\Admin\Dashboard', 'index');

//Category
uri('admin/category', 'App\Http\Controllers\Admin\Category', 'index');
uri('admin/category/create', 'App\Http\Controllers\Admin\Category', 'create');
uri('admin/category/store', 'App\Http\Controllers\Admin\Category', 'store', 'POST');
uri('admin/category/edit/{id}', 'App\Http\Controllers\Admin\Category', 'edit');
uri('admin/category/update/{id}', 'App\Http\Controllers\Admin\Category', 'update', 'POST');
uri('admin/category/delete/{id}', 'App\Http\Controllers\Admin\Category', 'delete');

//Post
uri('admin/post', 'App\Http\Controllers\Admin\Post', 'index');
uri('admin/post/create', 'App\Http\Controllers\Admin\Post', 'create');
uri('admin/post/store', 'App\Http\Controllers\Admin\Post', 'store', 'POST');
uri('admin/post/edit/{id}', 'App\Http\Controllers\Admin\Post', 'edit');
uri('admin/post/update/{id}', 'App\Http\Controllers\Admin\Post', 'update', 'POST');
uri('admin/post/delete/{id}', 'App\Http\Controllers\Admin\Post', 'delete');
uri('admin/post/selected/{id}', 'App\Http\Controllers\Admin\Post', 'selected',);
uri('admin/post/breaking-news/{id}', 'App\Http\Controllers\Admin\Post', 'breakingNews');

//Banner
uri('admin/banner', 'App\Http\Controllers\Admin\Banner', 'index');
uri('admin/banner/create', 'App\Http\Controllers\Admin\Banner', 'create');
uri('admin/banner/store', 'App\Http\Controllers\Admin\Banner', 'store', 'POST');
uri('admin/banner/edit/{id}', 'App\Http\Controllers\Admin\Banner', 'edit');
uri('admin/banner/update/{id}', 'App\Http\Controllers\Admin\Banner', 'update', 'POST');
uri('admin/banner/delete/{id}', 'App\Http\Controllers\Admin\Banner', 'delete');

//User
uri('admin/user', 'App\Http\Controllers\Admin\User', 'index');
uri('admin/user/edit/{id}', 'App\Http\Controllers\Admin\User', 'edit');
uri('admin/user/update/{id}', 'App\Http\Controllers\Admin\User', 'update', 'POST');
uri('admin/user/delete/{id}', 'App\Http\Controllers\Admin\User', 'delete');
uri('admin/user/permission/{id}', 'App\Http\Controllers\Admin\User', 'permission');

//Comment
uri('admin/comment', 'App\Http\Controllers\Admin\Comment', 'index');
uri('admin/comment/check/{id}', 'App\Http\Controllers\Admin\Comment', 'check');

//Menu
uri('admin/menu', 'App\Http\Controllers\Admin\Menu', 'index');
uri('admin/menu/create', 'App\Http\Controllers\Admin\Menu', 'create');
uri('admin/menu/store', 'App\Http\Controllers\Admin\Menu', 'store', 'POST');
uri('admin/menu/edit/{id}', 'App\Http\Controllers\Admin\Menu', 'edit');
uri('admin/menu/update/{id}', 'App\Http\Controllers\Admin\Menu', 'update', 'POST');
uri('admin/menu/delete/{id}', 'App\Http\Controllers\Admin\Menu', 'delete');

//Setting
uri('admin/web-setting', 'App\Http\Controllers\Admin\Setting', 'index');
uri('admin/web-setting/set/{id}', 'App\Http\Controllers\Admin\Setting', 'set');
uri('admin/web-setting/update/{id}', 'App\Http\Controllers\Admin\Setting', 'update', 'POST');

//Auth
uri('register', 'App\Http\Controllers\Auth\Auth', 'registerIndex');
uri('register/store', 'App\Http\Controllers\Auth\Auth', 'register', 'POST');
uri('activation/{verify_token}', 'App\Http\Controllers\Auth\Auth', 'activation');
uri('login', 'App\Http\Controllers\Auth\Auth', 'loginIndex');
uri('login/check', 'App\Http\Controllers\Auth\Auth', 'login', 'POST');
uri('logout', 'App\Http\Controllers\Auth\Auth', 'logout');

uri('forgot-password', 'App\Http\Controllers\Auth\Auth', 'forgotPasswordIndex');
uri('forgot-password/check-mail', 'App\Http\Controllers\Auth\Auth', 'forgotPasswordCheckMail', 'POST');
uri('reset-password-form/{forgot_token}', 'App\Http\Controllers\Auth\Auth', 'resetPasswordIndex');
uri('change-password/{user_id}', 'App\Http\Controllers\Auth\Auth', 'changePassword', 'POST');

//app
uri('/', 'App\Http\Controllers\App\Home', 'index');
uri('home', 'App\Http\Controllers\App\Home', 'index');
uri('show-post/{id}', 'App\Http\Controllers\App\Home', 'showPost');
uri('show-category/{id}', 'App\Http\Controllers\App\Home', 'showCategory');
uri('comment-store/{id}', 'App\Http\Controllers\App\Home', 'commentStore', 'POST');
uri('search', 'App\Http\Controllers\App\Home', 'search');
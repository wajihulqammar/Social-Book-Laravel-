<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\MarketplaceController;

Route::get('/', fn() => redirect()->route('login.form'));

// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard (feed)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Posts
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');

// Post interactions (AJAX) - UPDATED TO USE DASHBOARD CONTROLLER
Route::post('/posts/{post}/like', [DashboardController::class, 'like'])->name('posts.like')->middleware('auth');
Route::post('/posts/{post}/comment', [DashboardController::class, 'comment'])->name('posts.comment')->middleware('auth');

// Profiles
Route::get('/u/{user}', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

// Profile-specific post interactions (for profile pages)
Route::post('/profile/posts/{post}/like', [ProfileController::class, 'like'])->name('profile.posts.like')->middleware('auth');
Route::post('/profile/posts/{post}/comment', [ProfileController::class, 'comment'])->name('profile.posts.comment')->middleware('auth');

// Friendships
Route::post('/friend-request/send/{id}', [FriendshipController::class, 'sendRequest'])->name('friend.send')->middleware('auth');
Route::post('/friend-request/accept/{id}', [FriendshipController::class, 'acceptRequest'])->name('friend.accept')->middleware('auth');
Route::post('/friend-request/decline/{id}', [FriendshipController::class, 'declineRequest'])->name('friend.decline')->middleware('auth');
Route::delete('/friend/remove/{id}', [FriendshipController::class, 'remove'])->name('friend.remove')->middleware('auth');

// Search

Route::get('/search/users', [App\Http\Controllers\DashboardController::class, 'searchUsers'])->middleware('auth');
Route::post('/profile/{id}/update-field', [ProfileController::class, 'updateField'])->name('profile.updateField')->middleware('auth');

// Friends Routes
Route::middleware('auth')->group(function () {
    Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');
    Route::get('/friends/requests', [FriendsController::class, 'requests'])->name('friends.requests');
    Route::get('/friends/suggestions', [FriendsController::class, 'suggestions'])->name('friends.suggestions');
});

// Messages Routes
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{user}/get', [MessageController::class, 'getMessages'])->name('messages.get');
    Route::post('/messages/{user}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::get('/api/conversations', [MessageController::class, 'conversations'])->name('messages.conversations');
});

// Marketplace Routes
Route::middleware('auth')->group(function () {
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('/marketplace/create', [MarketplaceController::class, 'create'])->name('marketplace.create');
    Route::post('/marketplace', [MarketplaceController::class, 'store'])->name('marketplace.store');
    Route::get('/marketplace/{listing}', [MarketplaceController::class, 'show'])->name('marketplace.show');
    Route::get('/marketplace/{listing}/edit', [MarketplaceController::class, 'edit'])->name('marketplace.edit');
    Route::put('/marketplace/{listing}', [MarketplaceController::class, 'update'])->name('marketplace.update');
    Route::delete('/marketplace/{listing}', [MarketplaceController::class, 'destroy'])->name('marketplace.destroy');
    Route::get('/my-listings', [MarketplaceController::class, 'myListings'])->name('marketplace.my-listings');
    Route::post('/marketplace/{listing}/mark-sold', [MarketplaceController::class, 'markAsSold'])->name('marketplace.mark-sold');
});

// Groups Routes
Route::middleware('auth')->group(function () {
    Route::get('/groups', [GroupsController::class, 'index'])->name('groups.index');
    Route::get('/groups/discover', [GroupsController::class, 'discover'])->name('groups.discover');
    Route::get('/groups/create', [GroupsController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupsController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}', [GroupsController::class, 'show'])->name('groups.show');
    Route::get('/groups/{group}/edit', [GroupsController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupsController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [GroupsController::class, 'destroy'])->name('groups.destroy');
    
    Route::post('/groups/{group}/join', [GroupsController::class, 'join'])->name('groups.join');
    Route::post('/groups/{group}/leave', [GroupsController::class, 'leave'])->name('groups.leave');
    
    Route::get('/my-groups', [GroupsController::class, 'myGroups'])->name('groups.my-groups');
    Route::get('/groups/{group}/members', [GroupsController::class, 'members'])->name('groups.members');
    Route::get('/groups/{group}/requests', [GroupsController::class, 'joinRequests'])->name('groups.requests');
    
    Route::post('/groups/{group}/approve-request/{request}', [GroupsController::class, 'approveRequest'])->name('groups.approve-request');
    Route::post('/groups/{group}/reject-request/{request}', [GroupsController::class, 'reject-request'])->name('groups.reject-request');
    Route::post('/groups/{group}/remove-member/{user}', [GroupsController::class, 'removeMember'])->name('groups.remove-member');
    Route::post('/groups/{group}/make-admin/{user}', [GroupsController::class, 'makeAdmin'])->name('groups.make-admin');
    Route::post('/groups/{group}/make-moderator/{user}', [GroupsController::class, 'makeModerator'])->name('groups.make-moderator');
    
    Route::post('/groups/{group}/posts', [GroupsController::class, 'storePost'])->name('groups.store-post');
    Route::delete('/group-posts/{post}', [GroupsController::class, 'destroyPost'])->name('groups.destroy-post');
    Route::post('/groups/{group}/demote-member/{user}', [GroupsController::class, 'demoteMember'])->name('groups.demote-member');

    Route::middleware(['auth'])->group(function () {
    // AI Routes
    Route::get('/ai', [App\Http\Controllers\AIController::class, 'index'])->name('ai.index');
    Route::post('/ai/chat', [App\Http\Controllers\AIController::class, 'chat'])->name('ai.chat');
    Route::post('/ai/generate-post', [App\Http\Controllers\AIController::class, 'generatePost'])->name('ai.generate-post');
    Route::post('/ai/help-writing', [App\Http\Controllers\AIController::class, 'helpWriting'])->name('ai.help-writing');
});


});
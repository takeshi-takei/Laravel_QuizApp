<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PlayController;

// Play画面のルーティング
Route::get('/', [PlayController::class, 'top'])->name('top');
//クイズ開始画面
Route::get('categories/{categoryId}', [PlayController::class, 'categories'])->name('categories');
//クイズ出題画面
Route::get('categories/{categoryId}/quizzes', [PlayController::class, 'quizzes'])->name('categories.quizzes');
//クイズ回答画面
Route::post('categories/{categoryId}/quizzes/answer', [PlayController::class, 'answer'])->name('categories.quizzes.answer');
//リザルト画面
Route::get('categories/{categoryId}/quizzes/result',[PlayController::class, 'result'])->name('categories.quizzes.result');




//管理者の認証機能のルーティング
require __DIR__.'/auth.php';

//管理画面//

//管理画面トップページ(カテゴリ一覧表示)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('top', [CategoryController::class, 'top'])->name('top');

    //カテゴリー管理
    Route::prefix('categories')->name('categories.')->group(function() {
        // カテゴリー新規登録画面
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        //カテゴリ新規登録処理
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        //カテゴリ詳細 兼 クイズ一覧表示
        Route::get('{categoryId}', [CategoryController::class, 'show'])->name('show');
        //カテゴリ編集画面表示
        Route::get('{categoryId}/edit', [CategoryController::class, 'edit'])->name('edit');
        //カテゴリ更新処理
        Route::post('{categoryId}', [CategoryController::class, 'update'])->name('update');
        //カテゴリ削除処理
        Route::delete('{categoryId}', [CategoryController::class, 'destroy'])->name('destroy');

        //クイズ管理
        Route::prefix('{categoryId}/quizzes')->name('quizzes.')->group(function() {
            //クイズ新規登録画面
            Route::get('create', [QuizController::class, 'create'])->name('create');
            //クイズ新規登録処理
            Route::post('store', [QuizController::class, 'store'])->name('store');
            //クイズ編集画面表示
            Route::get('{quizId}/edit', [QuizController::class, 'edit'])->name('edit');
            //クイズ更新処理
            Route::post('{quizId}/update', [QuizController::class, 'update'])->name('update');
            //クイズ削除処理
            Route::delete('{quizId}/destroy', [QuizController::class, 'destroy'])->name('destroy');
        });
    });
});

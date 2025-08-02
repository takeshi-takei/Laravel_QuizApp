<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     *クイズ新規作成画面表示
     */
    public function create(Request $request, int $categoryId)
    {
        // dd($categoryId, $request);
        return view('admin.quizzes.create', data: [
            'categoryId' => $categoryId,
        ]);
    }

    /**
     *クイズ新規登録処理
     */
    public function store(StoreQuizRequest $request, int $categoryId)
    {
        $quiz = new Quiz();
        $quiz->category_id = $categoryId;
        $quiz->question    = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();
        // オプションの登録
        $options = [
        ['quizId' => $quiz->id, 'content' => $request->content1, 'is_correct' => $request->is_Correct1],
        ['quizId' => $quiz->id, 'content' => $request->content2, 'is_correct' => $request->is_Correct2],
        ['quizId' => $quiz->id, 'content' => $request->content3, 'is_correct' => $request->is_Correct3],
        ['quizId' => $quiz->id, 'content' => $request->content4, 'is_correct' => $request->is_Correct4],
        ];

        foreach ($request->input('options') as $optionData) {
            $option = new Option();
            $option->quiz_id = $quiz->id;
            $option->content = $optionData['content'];
            $option->is_correct = $optionData['is_correct'];
            $option->save();
        }
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId])
        ->with('success', 'クイズが登録されました。');
        }


    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * クイズ編集画面表示
     */
    public function edit(Request $request, int $categoryId, int $quizId)
    {
        $quiz = Quiz::with('category', 'options')->findOrFail($quizId);
        return view('admin.quizzes.edit', [
        'quiz'     => $quiz,
        'category' => $quiz->category,
        'options'  => $quiz->options,
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
/**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, int $categoryId,  int $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->question    = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();



        // オプションの更新
        // ループの対象を $request->options に変更する
        foreach ($request->options as $optionData) {
            // hiddenで送信したoptionIdが配列に含まれているため、キー名を'optionId'に合わせる
            $option = Option::findOrFail($optionData['optionId']);
            $option->content = $optionData['content'];
            $option->is_correct = $optionData['is_correct'];
            $option->save();
        }

        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId])
        ->with('success', 'クイズが更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $categoryId, int $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->options()->delete(); // 関連するオプションを削除
        $quiz->delete(); // クイズ自体を削除
        return redirect()->route('admin.categories.show', ['categoryId' => $quiz->category_id])
        ->with('success', 'クイズが削除されました。');
    }
}

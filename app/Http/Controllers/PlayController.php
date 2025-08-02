<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PlayController extends Controller
{
    public function top()
    {
        /**
         * プレイ画面トップページ
         */
        $categories = Category::all();

        return view('play.top',[
            'categories' => $categories
        ]);
    }

    /**クイズスタート画面表示 */
    public function categories(Request $request, int $categoryId)
    {
        $category = Category::withCount('quizzes')->findOrFail(($categoryId));

        return view('play.start', [
            'category' => $category,
            'quizzesCount' => $category->quizzes_count,
        ]);
    }

    /**クイズ出題画面表示 */// app/Http/Controllers/PlayController.php

// app/Http/Controllers/PlayController.php

    public function quizzes(Request $request, int $categoryId)
    {
        //カテゴリ、紐付いている選択肢を全て取得
        $category = Category::with('quizzes.options')->findOrFail($categoryId);
        // $quizzesCollection = $category->quizzes;
        // //CollectionをPHPの配列に変換する
        // $quizzesArray = $quizzesCollection->toArray();
        // shuffle($quizzesArray);
        // $quiz= $quizzesArray[0];


        $resultArray = session('resultArray');
        //初回はセッションに保存されたクイズIDの配列がないため、クイズIDの配列を作成
        if (is_null($resultArray)) {
        //クイズIDを全て抽出
            $quizIds = $category->quizzes->pluck('id')->toArray();
            shuffle($quizIds); //クイズIDをシャッフル
            $resultArray = [];
            foreach ($quizIds as $quizId) {
                $resultArray[] = [
                    'quizId' => $quizId,
                    'result' => null,
                ];
            }
            session(['resultArray' => $resultArray]); //セッションに保存
        }
        // resultArrayの中でresultがnullのもののうち、最初のデータを選ぶ
        $pendingQuiz = collect($resultArray)->filter(function ($item) {
            return is_null($item['result']);
        })->first();

        if($pendingQuiz === null) {
            // すべてのクイズに回答済みの場合、結果画面へリダイレクト
            return redirect()->route('play.top')->with('message', 'すべてのクイズに回答しました。');
        }

        // クイズIDを取得
        $quiz = $category->quizzes->firstWhere('id', $pendingQuiz['quizId']);

        return view('play.quizzes', [
            'categoryId' => $categoryId,
            'quiz' => $quiz,
            'caetgoruId' => $categoryId,
        ]);
    }
    /**クイズ回答処理 */
    public function answer(Request $request, int $categoryId)
    {
        $quizId = $request->quiz_id;
        $selectedOptions = $request->optionId === null ? [] : $request->optionId;
        $category = Category::with('quizzes.options')->findOrFail($categoryId);
        $quiz = $category->quizzes->firstWhere('id', $quizId);
        $quizOptions = $quiz->options->toArray();
        $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions, $quizOptions);

        $resultArray = session('resultArray');
        //回答結果をセッションのresultArrayに保存
        foreach ($resultArray as $index => $result) {
            if ($result['quizId'] === (int)$quizId) {
                $resultArray[$index]['result'] = $isCorrectAnswer ? 'correct' : 'incorrect';
                break;
            }
        }
        return view('play.answer', [
            'quiz' => $quiz->toArray(),
            'quizOptions' => $quizOptions,
            'selectedOptions' => $selectedOptions,
            'categoryId' => $categoryId,
            'isCorrectAnswer' => $isCorrectAnswer,
        ]);
    }

    /**プレイヤーの回答の正誤判定 */
    private function isCorrectAnswer(array $selectedOptions, array $quizOptions)
    {
        //クイズの選択肢から正解のものだけを抽出し、idを取得する
        $correctOptions = array_filter($quizOptions, function ($option) {
            return $option['is_correct'] === 1;
        });

        //idの数字を取得
        $correctOptionIds = array_map(function ($option) {
            return $option['id'];
        }, $correctOptions);

        //プレイヤーが選んだ選択肢の個数と正解の選択肢の個数が一致するか判定する
        if(count($selectedOptions) !== count($correctOptionIds)) {
            return false; //個数が違うので不正解
        }
        //プレイヤーが選んだ選択肢のidと正解のidが全て一致することを確認する
        foreach ($selectedOptions as $selectedOption) {
            if (!in_array((int) $selectedOption, $correctOptionIds)) {
                return false; //選択肢のidが正解のidに含まれていないので不正解
            }
        }
        return true; //全ての選択肢が正解なので正解

    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    /**
     * カテゴリ一覧表示.
     */
    public function top()
    {
        //カテゴリ一覧取得
        $categories = Category::get();
        return view('admin.top', [
            'categories' => $categories,
        ]);
    }

    /**
     * カテゴリー新規登録画面表示
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('admin.top')->with('success', 'カテゴリーが登録されました。');
    }

    /**
     *カテゴリ詳細画面表示
     */
    public function show(Request $request, string $categoryId)
    {
        // dd($categoryId)
        $category = Category::with('quizzes')->findOrFail($categoryId);
        return view('admin.categories.show', [
            'category' => $category,
            'quizzes' => $category->quizzes, // クイズ一覧も取得
        ]);

    }

    /**
     * カテゴリ編集画面表示
     */
    public function edit(Request $request, string $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     *カテゴリ更新処理
     */
    public function update(UpdateCategoryRequest $request, int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId])
            ->with('success', 'カテゴリーが更新されました。');
    }

    /**
     * カテゴリさくじょ処理
     */
    public function destroy(Request $request, string $categoryId)
    {
        // dd($categoryId, $request);
        $category = Category::findOrFail($categoryId);
        $category->delete();
        return redirect()->route('admin.top')->with('success', 'カテゴリーが削除されました。');
    }
}

<x-admin-layout>
    <section class="text-gray-600 body-font">
    <div class="container px-15 py-10 mx-auto">
        <div class="flex flex-col text-center w-full">
        <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">{{ $category->name }}</h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">{{ $category->description }}</p>
        </div>

        <div class="container px-5 py-2 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                    <button
                    onclick="location.href='{{ route('admin.categories.edit', ['categoryId' => $category->id]) }}'"
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        カテゴリー編集
                    </button>
            </div>
        </div>
                <div class="container px-5 py-2 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                    <button
                    onclick="location.href='{{ route('admin.categories.quizzes.create', ['categoryId' => $category->id]) }}'"
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        クイズ新規登録
                    </button>
            </div>
        </div>
    </div>
     <section class="text-gray-600 body-font">
    <div class="container px-5 py-5 mx-auto">
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
            @if ($quizzes->isEmpty())
            <p class="text-center text-gray-500">このカテゴリーにはクイズが登録されていません。</p>
            @else
            <table class="table-auto w-full text-left whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ID</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">クイズ問題文</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">更新日時</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">削除</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                    <tr>
                        <td class="px-4 py-3">{{ $quiz->id }}</td>
                        {{-- 問題文のうち最初の１０文字表示 --}}
                        <td class="px-4 py-3">{{
                        Str::length($quiz->question) > 10 ? mb_substr($quiz->question, 0, 10) . '...' : $quiz->question }}</td>
                        <td class="px-4 py-3">{{ $quiz->updated_at }}</td>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            <button {{--クイズ編集画面遷移--}}
                            onclick="location.href='{{ route('admin.categories.quizzes.edit', ['categoryId' => $category->id, 'quizId' => $quiz->id]) }}'"
                            class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                編集
                            </button>
                        </th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            <form action="{{ route('admin.categories.quizzes.destroy', ['categoryId' => $category->id, 'quizId' => $quiz->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                                @csrf
                                @method('DELETE')
                                <button class="flex ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                    削除
                                </button>
                            </form>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
    </div>
    </section>
    </section>
</x-admin-layout>

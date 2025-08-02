<x-play-layout>
<section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $category->name }}</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">{{ $category->description }}</p>
            <div class="p-2 w-full">
                @if ($quizzesCount > 0)
                <button
                    onclick="location.href='{{ route('categories.quizzes', ['categoryId' => $category->id]) }}'"
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">スタート
                </button>
                @else
                <p class="text-align-center text-red-500">このカテゴリーにはまだクイズがありません。</p>
                @endif
            </div>
        </div>
    </div>
</section>
</x-play-layout>

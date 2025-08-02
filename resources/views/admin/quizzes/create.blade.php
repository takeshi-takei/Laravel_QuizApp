<x-admin-layout>
    <section class="text-gray-600 body-font relative">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-12">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">クイズ新規登録</h1>
    <div class="lg:w-1/2 md:w-2/3 mx-auto">
      {{-- <div class="flex flex-wrap -m-2"> --}}
        <form method="POST" action='{{ route("admin.categories.quizzes.store", ['categoryId' => $categoryId]) }}' class="bg-white p-8 rounded-lg flex flex-wrap -m-2">
            {{-- CSRFトークンを含める --}}
            @csrf
            {{-- 問題文 --}}
            <div class="p-2 w-full">
                <div class="relative">
                <label for="question" class="leading-7 text-sm text-gray-600">問題文</label>
                <textarea id="question" name="question" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old('question') }}</textarea>
                </div>
                {{--エラーメッセージ--}}
                @error('question')
                <div class="alert alert-danger text-red-700">{{ $message }}</div>
                @enderror
            </div>
            {{-- 解説文 --}}
            <div class="p-2 w-full">
                <div class="relative">
                <label for="explanation" class="leading-7 text-sm text-gray-600">解説</label>
                <textarea id="explanation" name="explanation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old('explanation') }}</textarea>
                </div>
                {{--エラーメッセージ--}}
                @error('explanation')
                <div class="alert alert-danger text-red-700">{{ $message }}</div>
                @enderror
            </div>
            @for ($i = 1; $i <= 4; $i++)
            {{-- 選択肢 --}}
            <div class="p-2  w-full">
                <div class="relative">
                    <label for="content{{ $i }}" class="leading-7 text-sm text-gray-600">選択肢{{ $i }}</label>
                    <input type="text" id="content{{ $i }}" name="options[{{ $i }}][content]" value="{{ old('options.'.$i.'.content') }}" class="w-full ...">
                </div>
                @error('options.'.$i.'.content')
                <div class="alert alert-danger text-red-700">{{ $message }}</div>
                @enderror
            </div>
            {{-- 正誤判定 --}}
            <div class="p-2  w-full">
                <div class="relative">
                    <label for="isCorrect{{ $i }}" class="leading-7 text-sm text-gray-600">正誤</label>
                    <select
                        id="isCorrect{{ $i }}"
                        name="options[{{ $i }}][is_correct]"
                        values="{{ old(key: 'options.'.$i.'.is_correct') }}"
                        class="w-full ...">
                        <option value="1" {{ old('options.'.$i.'.is_correct') == '1' ? 'selected' : '' }}>正解</option>
                        <option value="0" {{ old('options.'.$i.'.is_correct') == '0' ? 'selected' : '' }}>不正解</option>
                    </select>
                </div>
                @error('options.'.$i.'.is_correct')
                <div class="alert alert-danger text-red-700">{{ $message }}</div>
                @enderror
            </div>
            @endfor
            <div class="p-2 w-full flex justify-center items-center">
                <button type="submit"
                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                登録
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</section>
</x-admin-layout>

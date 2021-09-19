<x-app-layout>
    <nav class="px-6 py-2 bg-white shadow">
        <div class="container flex flex-col mx-auto md:flex-row md:items-center md:justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('tweets.index') }}" class="text-xl font-bold text-gray-800 md:text-2xl">Brand</a>
                </div>
                <div>
                    <button type="button" class="block text-gray-800 hover:text-gray-600 focus:text-gray-600 focus:outline-none md:hidden">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                            <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex items-center md:flex md:flex-row md:-mx-4">
                <div><a href="{{ url('users/' .$user->id) }}"><img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class=" hidden object-cover w-10 h-10 mr-4 rounded-full sm:block items-center "></a></div>
                <a href="{{route('tweets.create')}}" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ツイートする</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" value="ログアウト" class=" my-1 bg-white cursor-pointer text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">
                </form>
            </div>
        </div>
    </nav>




    <div class="flex items-center justify-between px-2 py-4 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Update</h1>
    </div>

    <div class="my-6">
        <div class="max-w-xl px-10 pt-6 pb-6 mx-auto bg-white rounded-lg shadow-md">
            <form method="POST" action="{{ route('tweets.update', ['tweet' => $tweet]) }}">
                @csrf
                @method('PUT')
                <div class="flex items-center">
                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block  ">
                    <div class="ml-1">
                        <p class="">{{ $user->name }}</p>
                        <a href="{{ url('users/' .$user->id) }}" class="hover:underline">{{ $user->screen_name }}</a>
                    </div>
                </div>
                <div class="">
                    <textarea class="mt-5  w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="text" required autocomplete="text" rows="4" name="text">{{ old('text') ? : $tweet->text }}</textarea>

                    @error('text')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="text-right">
                    <p class="mb-4 font-bold text-red-500">140文字以内</p>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        更新する
                    </button>
                </div>
            </form>
        </div>
</x-app-layout>

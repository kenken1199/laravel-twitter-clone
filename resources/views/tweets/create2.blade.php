<x-app-layout>
    <div class="flex items-center justify-between px-2 py-4 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Create</h1>
    </div>
    <div class="my-6">
        <div class="max-w-xl px-10 pt-6 pb-6 mx-auto bg-white rounded-lg shadow-md">
            <form method="POST" action="{{ route('tweets.store') }}">
                @csrf
                <div class="flex items-center">
                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block  ">
                    <div class="ml-1">
                        <p class="">{{ $user->name }}</p>
                        <a href="{{ url('users/' .$user->id) }}" class="hover:underline">{{ $user->screen_name }}</a>
                    </div>
                </div>
                <div class="">
                    <textarea class="mt-5  w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>
                    @error('text')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="text-right">
                    <p class="mb-4 font-bold text-red-500">140文字以内</p>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ツイートする
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

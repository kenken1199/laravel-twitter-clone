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
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Post</h1>
    </div>
    <!-- 各ポストのカラム -->
    @if (isset($tweet))
    <div class="pt-6">
        <div class="max-w-xl mb-1 px-10 pt-6 pb-2 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mt-4">
                <div><img src="{{ asset('storage/profile_image/' .$tweet->user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block items-center "></div>
                <div class="mr-auto">
                    <a href="{{ url('users/' .$tweet->user->id) }}" class="font-bold items-center ml-4 text-xl text-gray-700 hover:underline">{{ $tweet->user->screen_name }}</a>
                    <span class="text-sm">@</span><span class="text-sm">{{ $tweet->user->name }}</span>
                </div>
                @if ($tweet->user->id === Auth::user()->id)
                <div class=" text-gray-600 font-light ">
                    {{ $tweet->created_at->format('Y-m-d H:i') }}
                </div>
                @else
                <div class=" text-gray-600 mr-9 font-light ">
                    {{ $tweet->created_at->format('Y-m-d H:i') }}
                </div>
                @endif
                <!-- alpine ドロップダウン -->

                @if ($tweet->user->id === Auth::user()->id)
                <div class="flex">
                    <div x-data="{ dropdownOpen: false }" class="">
                        <button @click="dropdownOpen =!dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                            <i class="fas fa-ellipsis-v fa-fw"></i>
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                        <div x-show="dropdownOpen" class="absolute mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                            <a href="{{ url('tweets/' .$tweet->id .'/edit') }}" class="block px-4 py-2 text-sm  text-gray-700 hover:bg-blue-500 hover:text-white">
                                編集
                            </a>
                            <form method="POST" action="{{ url('tweets/' .$tweet->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type=" submit" class="text-left w-48 px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <!-- alpine ここまで-->
            <div class="mt-2 border-b">
                <p class="my-5 text-gray-600">{!! nl2br(e($tweet->text)) !!}</p>
            </div>
            <div class="flex justify-end ml-2">
                <div class="flex justify-end items-center">
                    <a href="{{ url('tweets/' .$tweet->id) }}"><i class="far fa-comment fa-fw"></i></a>
                    <p class="">{{ count($tweet->comments) }}</p>
                </div>

                <div class="flex items-center justify-end ml-3">
                    @if (!in_array($user->id, array_column($tweet->favorites->toArray(), 'user_id'), TRUE))
                    <form method="POST" action="{{ url('favorites/') }}" class="">
                        @csrf

                        <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                        <button type="submit" class=""><i class="far fa-heart fa-fw"></i></button>
                    </form>
                    @else
                    <form method="POST" action="{{ url('favorites/' .array_column($tweet->favorites->toArray(), 'id', 'user_id')[$user->id]) }}" class="mb-0">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class=""><i class="fas fa-heart fa-fw"></i></button>
                    </form>
                    @endif
                    <p class="">{{ count($tweet->favorites) }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- コメント -->


    <div class="max-w-xl px-10 pt-6 pb-2 mx-auto bg-white rounded-lg shadow-md">
        <div class="border-l-4 border-red-400 -ml-6 pl-6 flex items-center justify-between my-4">
            <div class="font-semibold text-gray-800">コメント</div>
        </div>
        <hr class="-mx-6" />


        @forelse ($comments as $comment)
        <div class="flex items-center justify-between my-4 ">
            <div><a href="{{ url('users/' .$comment->user->id) }}"><img src="{{ asset('storage/profile_image/' .$comment->user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block "></a></div>
            <div class="mr-auto">
                <a href="{{ url('users/' .$comment->user->id) }}" class="font-bold items-center ml-4 text-xl text-gray-700 hover:underline">{{ $comment->user->screen_name }}</a><span class="text-sm">@</span><span class="text-sm">{{ $comment->user->name }}</span>
            </div>
            <div class="text-gray-600 mr-9 font-light">{{ $comment->created_at->format('Y-m-d H:i') }}</div>
        </div>
        <div class="py-1">
            {!! nl2br(e($comment->text)) !!}
        </div>
        <hr class="boder-b-0 my-4" />
        @empty
        <div>
            <p class="">コメントはまだありません。</p>
        </div>
    </div>
    @endforelse
    @if(isset($comment))
    </div>
    @endif
    <div class="py-6">
        <div class="max-w-xl px-10 pt-6 pb-6 mx-auto bg-white rounded-lg shadow-md">
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <div class="flex items-center">
                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block ">
                    <div class="ml-1">
                        <p class="">{{ $user->name }}</p>
                        <a href="{{ url('users/' .$user->id) }}" class="hover:underline">{{ $user->screen_name }}</a>
                    </div>
                </div>
                <div class="">
                    <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
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
                        コメントする
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

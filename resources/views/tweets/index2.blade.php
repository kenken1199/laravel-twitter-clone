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
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Posts</h1>
        <a href=" {{ url('users') }}" class=" hover:underline ">ユーザ一覧<i class=" fas fa-users" class="fa-fw"></i></a>
    </div>
    <!-- 各ポストのカラム -->
    @if (isset($timelines))
    @foreach ($timelines as $timeline)
    <div class="pt-6">
        <div class="max-w-xl px-10 pt-6 pb-2 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mt-4">
                <div><img src="{{ asset('storage/profile_image/' .$timeline->user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block items-center "></div>
                <div class="mr-auto">
                    <a href="{{ url('users/' .$timeline->user->id) }}" class="font-bold items-center ml-4 text-xl text-gray-700 hover:underline">{{ $timeline->user->screen_name }}</a>
                    <span class="text-sm">@</span><span class="text-sm">{{ $timeline->user->name }}</span>
                </div>
                @if ($timeline->user->id === Auth::user()->id)
                <div class=" text-gray-600 font-light ">
                    {{ $timeline->created_at->format('Y-m-d H:i') }}
                </div>
                @else
                <div class=" text-gray-600 mr-9 font-light ">
                    {{ $timeline->created_at->format('Y-m-d H:i') }}
                </div>
                @endif
                <!-- alpine ドロップダウン -->

                @if ($timeline->user->id === Auth::user()->id)
                <div class="flex">
                    <div x-data="{ dropdownOpen: false }" class="">
                        <button @click="dropdownOpen =!dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                            <i class="fas fa-ellipsis-v fa-fw"></i>
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                        <div x-show="dropdownOpen" class="absolute mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                            <a href="{{ url('tweets/' .$timeline->id .'/edit') }}" class="block px-4 py-2 text-sm  text-gray-700 hover:bg-blue-500 hover:text-white">
                                編集
                            </a>
                            <form method="POST" action="{{ url('tweets/' .$timeline->id)}}">
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
                <p class="my-5 text-gray-600">{!! nl2br(e($timeline->text)) !!}</p>
            </div>
            <div class="flex justify-end ml-2">
                <div class="flex justify-end items-center">
                    <a href="{{ url('tweets/' .$timeline->id) }}"><i class="far fa-comment fa-fw"></i></a>
                    <p class="">{{ count($timeline->comments) }}</p>
                </div>

                <div class="flex items-center justify-end ml-3">
                    @if (!in_array($user->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
                    <form method="POST" action="{{ url('favorites/') }}" class="">
                        @csrf

                        <input type="hidden" name="tweet_id" value="{{ $timeline->id }}">
                        <button type="submit" class=""><i class="far fa-heart fa-fw"></i></button>
                    </form>
                    @else
                    <form method="POST" action="{{ url('favorites/' .array_column($timeline->favorites->toArray(), 'id', 'user_id')[$user->id]) }}" class="mb-0">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class=""><i class="fas fa-heart fa-fw"></i></button>
                    </form>
                    @endif
                    <p class="">{{ count($timeline->favorites) }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ここまで -->
    @endforeach
    @endif
    <!-- 各ポストのカラム -->
    <!-- ページネーション -->
    <div class="py-8">
        <div class="flex justify-center">
            <a href="#" class="px-3 py-2 mx-1 font-medium text-gray-500 bg-white rounded-md cursor-not-allowed">
                previous
            </a>

            <a href="#" class="px-3 py-2 mx-1 font-medium text-gray-700 bg-white rounded-md hover:bg-blue-500 hover:text-white">
                1
            </a>

            <a href="#" class="px-3 py-2 mx-1 font-medium text-gray-700 bg-white rounded-md hover:bg-blue-500 hover:text-white">
                2
            </a>

            <a href="#" class="px-3 py-2 mx-1 font-medium text-gray-700 bg-white rounded-md hover:bg-blue-500 hover:text-white">
                3
            </a>

            <a href="#" class="px-3 py-2 mx-1 font-medium text-gray-700 bg-white rounded-md hover:bg-blue-500 hover:text-white">
                Next
            </a>
        </div>
    </div>
</x-app-layout>

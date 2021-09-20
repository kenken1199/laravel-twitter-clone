<x-app-layout>

    <div class="flex items-center justify-between px-2 py-4 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">User</h1>
    </div>
    <div class="py-6">
        <div class="max-w-xl px-10 pt-6 pb-6 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex justify-around">
                <div class="flex-col">
                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block ">
                    <div class="ml-3 mt-2">
                        <h4 class="">{{ $user->name }}</h4>
                        <span class="">{{ $user->screen_name }}</span>
                    </div>
                </div>
                <div class="flex-col flex-grow ">
                    <div>
                        @if ($user->id === Auth::user()->id)
                        <a href="{{ url('users/' .$user->id .'/edit') }}" class="ml-16 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">プロフィールを編集する</a>
                        @else
                        @if ($is_followed)
                        <span class=" ml-4  rounded-sm bg-gray-200">フォローされています</span>
                        @endif
                        @if ($is_following)
                        <form action="{{ route('unfollow', ['user' => $user->id]) }}" method="POST" class="mb-2">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-4 mt-5">フォロー解除</button>
                        </form>
                        @else
                        <form action=" {{ route('follow', ['user' => $user->id]) }}" method="POST" class="mb-2">
                            {{ csrf_field() }}

                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4 mt-5">フォローする</button>
                        </form>
                        @endif

                        @endif
                    </div>
                    @if ($user->id === Auth::user()->id)
                    <div class="flex mt-12 flex-grow">
                        @else
                        <div class="flex mt-7 flex-grow">
                            @endif
                            <div class="flex-col">
                                <p class="font-bold ml-16">ツイート数</p>
                                <span class="ml-24">{{ $tweet_count }}</span>
                            </div>

                            <div class="">
                                <p class=" font-bold ml-4">フォロー数</p>
                                <span class="ml-12">{{ $follow_count }}</span>
                            </div>
                            <div class="">
                                <p class="font-bold ml-4">フォロワー数</p>
                                <span class="ml-14">{{ $follower_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 各ポストのカラム -->
        @if (isset($timelines))
        @foreach ($timelines as $timeline)
        <div class="py-3">
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
                        @if (!in_array(Auth::user()->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
                        <form method="POST" action="{{ url('favorites/') }}" class="">
                            @csrf

                            <input type="hidden" name="tweet_id" value="{{ $timeline->id }}">
                            <button type="submit" class=""><i class="far fa-heart fa-fw"></i></button>
                        </form>
                        @else
                        <form method="POST" action="{{ url('favorites/' .array_column($timeline->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}" class="mb-0">
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
        <div class="py-8 flex justify-center">
            {{ $timelines->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

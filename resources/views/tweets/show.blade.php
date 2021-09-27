<x-app-layout>

    <div class="flex items-center justify-between px-2 py-4 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Post</h1>
    </div>
    <!-- 各ポストのカラム -->
    @if (isset($tweet))
    <div class="pt-6">
        <div class="max-w-xl px-1 md:px-10 md:pt-6 md:pb-2 md:mx-auto bg-white rounded-lg shadow-md mb-4">
            @if ($tweet->user->id === Auth::user()->id)
            <div class="flex justify-between items-center mt-4">
                @else
                <div class="flex justify-between items-center mt-4 md:py-2 py-6">
                    @endif
                    <div><img src="{{ asset('storage/profile_image/' .$tweet->user->profile_image) }}" alt="avatar" class=" mx-2 my-2 h-8 w-8 object-cover md:w-20 md:h-20  rounded-full sm:block items-center "></div>
                    <div class="mr-auto">
                        <a href="{{ url('users/' .$tweet->user->id) }}" class="font-bold items-center ml-1 md:ml-4 text-xl text-gray-700 hover:underline">{{ $tweet->user->screen_name }}</a>
                        <div class="md:ml-4">
                            <span class="text-sm ml-1 md:ml-0">@</span><span class="text-sm">{{ $tweet->user->name }}</span>
                        </div>
                    </div>
                    @if ($tweet->user->id === Auth::user()->id)
                    <div class=" text-gray-600 text-sm font-light ">
                        {{ $tweet->created_at->format('Y-m-d H:i') }}
                    </div>
                    @else
                    <div class=" text-gray-600 item-center text-sm mr-12 md:mr-9 px-6 md:px-10 font-light ">
                        {{ $tweet->created_at->format('Y-m-d H:i') }}
                    </div>
                    @endif
                    <!-- alpine ドロップダウン -->

                    @if ($tweet->user->id === Auth::user()->id)
                    <div class="flex flex-col p-4">
                        <a href="{{ url('tweets/' .$tweet->id .'/edit') }}" class="mb-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-2 rounded">
                            編集
                        </a>
                        <div x-data=" { deleteOpen: false }">
                            <button @click="deleteOpen = true" class=" bg-red-500 hover:bg-red-700 text-white  text-sm font-bold py-2 px-2 rounded">削除</button>
                            <div x-show="deleteOpen" class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center px-4 md:px-0">
                                <div class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center px-4 md:px-0">
                                    <div class="flex flex-col  bg-white shadow-2xl rounded-xl border-2 border-gray-400 py-8 px-14" @click.away="deleteOpen = false">
                                        <div class="flex justify-center mb-4">
                                            <h3 class="font-bold text-3xl items-center w-auto">Are you sure ?</h3>
                                        </div>
                                        <div class="flex flex-col">
                                            <form class="self-center" method="POST" action="{{ url('tweets/' .$tweet->id)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type=" submit" name="name" value="from_tweets_show" class="bg-red-500 shadow w-40  text-white font-bold py-2 px-4 rounded-full"><i class="fas fa-trash fa-fw mr-2"></i>DELETE</button>
                                            </form>
                                            <button @click="deleteOpen = false" class=" bg-gray-500 shadow w-40 self-center text-white font-bold mt-4 py-2 px-4 rounded-full"><i class="fas fa-window-close fa-fw ml-1 mr-2"></i>CANCEL</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-2 border-b">
                    <p class="my-5 ml-2 text-gray-600">{!! nl2br(e($tweet->text)) !!}</p>
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


        <div class="max-w-xl px-2 pt-2 md:px-10 md:pt-6 md:pb-2 md:mx-auto bg-white rounded-lg shadow-md">
            <div class="border-l-4 border-red-400 my-2 pl-2 md:-ml-6 md:pl-6 md:my-4">
                <div class="font-semibold text-gray-800">コメント</div>
            </div>
            <hr class="-mx-6" />


            @forelse ($comments as $comment)
            <div class="flex justify-between items-center  py-4">
                <div><a href="{{ url('users/' .$comment->user->id) }}"><img src="{{ asset('storage/profile_image/' .$comment->user->profile_image) }}" alt="avatar" class="mx-2 my-2 h-8 w-8 object-cover md:w-20 md:h-20  rounded-full sm:block "></a></div>
                <div class="mr-auto">
                    <a href="{{ url('users/' .$comment->user->id) }}" class="font-bold items-center ml-1 md:ml-4 text-xl text-gray-700 hover:underline">{{ $comment->user->screen_name }}</a>
                    <div class="ml-1 md:ml-4"><span class="text-sm">@</span><span class="text-sm">{{ $comment->user->name }}</span></div>
                </div>
                <div class="text-gray-600 text-sm mr-16 md:mr-20 font-light">{{ $comment->created_at->format('Y-m-d H:i') }}</div>
            </div>
            <div class="py-1 my-5 ml-2">
                {!! nl2br(e($comment->text)) !!}
            </div>
            <hr class="boder-b-0 my-4" />
            @empty
            <div>
                <p class="">コメントはまだありません。</p>
            </div>
            @endforelse
        </div>

        <div class="py-6">
            <div class="max-w-xl md:px-10 md:pt-6 md:pb-6 md:mx-auto bg-white rounded-lg shadow-md">
                <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <div class="flex items-center">
                        <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class="mx-2 my-2 h-8 w-8 object-cover md:w-20 md:h-20  rounded-full sm:block ">
                        <div class="ml-1">
                            <a href="{{ url('users/' .$user->id) }}" class="font-bold items-center ml-1 md:ml-4 text-xl text-gray-700 hover:underline"">{{ $user->screen_name }}</a>
                        <div class=" md:ml-4">
                                <span class="text-sm ml-1 md:ml-0">@</span><span class="text-sm">{{ $tweet->user->name }}</span>
                        </div>
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
                <p class="mb-4 font-bold text-red-500 mr-2 md:mr-0">140文字以内</p>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 md:mr-0 md:mb-4 mb-4 mr-2 rounded">
                    コメントする
                </button>
            </div>
            </form>
        </div>
    </div>
</x-app-layout>

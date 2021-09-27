<x-app-layout>


    <div class="flex items-center justify-between px-2 py-4 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Posts</h1>
        <a href=" {{ url('users') }}" class=" hover:underline ">ユーザ一覧<i class=" fas fa-users" class="fa-fw"></i></a>
    </div>
    <!-- 各ポストのカラム -->
    @if (isset($timelines))
    @foreach ($timelines as $timeline)
    <div class="pt-6 mb-4">
        <div class="max-w-xl px-10 pt-6 pb-2 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mt-4">
                <div><img src="{{ asset('storage/profile_image/' .$timeline->user->profile_image) }}" alt="avatar" class=" hidden mx-2 my-2 h-8 w-8 object-cover md:w-20 md:h-20  rounded-full sm:block items-center "></div>
                <div class="mr-auto">
                    <a href="{{ url('users/' .$timeline->user->id) }}" class="font-bold items-center ml-1 md:ml-4 text-xl text-gray-700 hover:underline">{{ $timeline->user->screen_name }}</a>
                    <div class="md:ml-4">
                        <span class="text-sm ml-1 md:ml-0">@</span><span class="text-sm">{{ $timeline->user->name }}</span>
                    </div>
                </div>
                @if ($timeline->user->id === Auth::user()->id)
                <div class=" text-gray-600 text-sm font-light ">
                    {{ $timeline->created_at->format('Y-m-d H:i') }}
                </div>
                @else
                <div class=" text-gray-600 text-sm mr-9 font-light ">
                    {{ $timeline->created_at->format('Y-m-d H:i') }}
                </div>
                @endif
                <!-- alpine ドロップダウン -->

                @if ($timeline->user->id === Auth::user()->id)
                <div class="flex">
                    <div x-data="{ dropdownOpen: false }" class="">
                        <button @click="dropdownOpen =!dropdownOpen" class="relative block rounded-md bg-white p-2 focus:outline-none">
                            <i class="fas fa-ellipsis-v fa-fw"></i>
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full "></div>

                        <div x-show="dropdownOpen" class="absolute mt-2 py-2  w-15 md:w-48 bg-white rounded-md shadow-xl z-20">
                            <a href="{{ url('tweets/' .$timeline->id .'/edit') }}" class="block px-4 py-2 text-sm  text-gray-700 hover:bg-blue-500 hover:text-white">
                                編集
                            </a>
                            <div x-data="{ deleteOpen: false }">
                                <div x-show="deleteOpen" class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center px-4 md:px-0">
                                    <div class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center px-4 md:px-0">
                                        <div class="flex flex-col  bg-white shadow-2xl rounded-xl border-2 border-gray-400 py-8 px-14" @click.away="deleteOpen = false">
                                            <div class="flex justify-center mb-4">
                                                <h3 class="font-bold text-3xl items-center w-auto">Are you sure ?</h3>
                                            </div>
                                            <div class="flex flex-col">
                                                <form class="self-center" method="POST" action="{{ url('tweets/' .$timeline->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type=" submit" class="bg-yellow-400 shadow w-40  text-black font-bold py-2 px-4 rounded-full"><i class="fas fa-trash fa-fw mr-2"></i>DELETE</button>
                                                </form>
                                                <button @click="deleteOpen = false" class=" bg-gray-400 shadow w-40 self-center text-black font-bold mt-4 py-2 px-4 rounded-full"><i class="fas fa-window-close fa-fw ml-1 mr-2"></i>CANCEL</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button @click="deleteOpen = ! deleteOpen" class=" btn text-left w-15 md:w-48 px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white">削除</button>
                            </div>
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
                    <!-- いいねをつける -->
                    @if (!$timeline->isLikedBy(Auth::user()))
                    <span class="likes">
                        <i class="far fa-heart fa-fw like_button" data-tweet_id="{{$timeline->id}}"></i>
                        <span class="like-counter">{{ count($timeline->favorites) }}</span>
                    </span>
                    @else
                    <!-- いいねを消す -->
                    <span class="likes">
                        <i class=" far fas fa-heart fa-fw text-red-600 like_button" data-tweet_id="{{$timeline->id}}"></i>
                        <span class="like-counter">{{ count($timeline->favorites) }}</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- ここまで -->
    @endforeach
    @endif
    <!-- ページネーション -->
    <div class="py-8 flex justify-center">
        {{ $timelines->links() }}
    </div>

</x-app-layout>

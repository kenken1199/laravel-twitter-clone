<x-app-layout>
    <div class="">
        <div class="">
            <div class="">
                <a href="{{ url('users') }}">ユーザ一覧 <i class="fas fa-users" class="fa-fw"></i> </a>
            </div>
            @if (isset($timelines))
            @foreach ($timelines as $timeline)
            <div class="">
                <div class="">
                    <div class="">
                        <img src="{{ asset('storage/profile_image/' .$timeline->user->profile_image) }}" class="">
                        <div class="">
                            <p class="">{{ $timeline->user->name }}</p>
                            <a href="{{ url('users/' .$timeline->user->id) }}" class="">{{ $timeline->user->screen_name }}</a>
                        </div>
                        <div class="">
                            <p class="">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    <div class="">
                        {!! nl2br(e($timeline->text)) !!}
                    </div>
                    <div class="">
                        @if ($timeline->user->id === Auth::user()->id)
                        <!-- alpine ドロップダウン -->
                        <div class="flex">
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                                    <i class="fas fa-ellipsis-v fa-fw"></i>
                                </button>

                                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                                <div x-show="dropdownOpen" class="absolute  left-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                                    <a href="{{ url('tweets/' .$timeline->id .'/edit') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                                        編集
                                    </a>
                                    <form method="POST" action="{{ url('tweets/' .$timeline->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type=" submit" class="text-left w-48 px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- alpine 　ここまで-->
                        @endif
                        <div class="">
                            <a href="{{ url('tweets/' .$timeline->id) }}"><i class="far fa-comment fa-fw"></i></a>
                            <p class="">{{ count($timeline->comments) }}</p>
                        </div>
                        <!-- ここから -->
                        <div class="">
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
                        <!-- ここまで -->
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="">
        {{ $timelines->links() }}
    </div>
    </div>
</x-app-layout>

<x-app-layout>

    <div class="flex items-center justify-between px-2 py-4 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Users</h1>
    </div>
    @foreach ($all_users as $user)
    <div class="mt-4">
        <div class="max-w-xl px-10 pt-6 pb-6 mx-auto bg-white rounded-lg shadow-md">
            @if (auth()->user()->isFollowed($user->id))
            <div class="ml-1 mb-2 w-auto inline-block rounded-sm self-center bg-gray-200">
                <span class="">フォローされています</span>
            </div>
            @endif
            <div class="flex">
                <div class="flex items-center">
                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class=" mx-2 my-2 h-8 w-8 object-cover md:w-20 md:h-20  rounded-full sm:block items-center ">
                    <div class="ml-1">
                        <a href="{{ url('users/' .$user->id) }}" class="font-bold items-center ml-1 md:ml-4 text-xl text-gray-700 hover:underline">{{ $user->screen_name }}</a>
                        <div class="md:ml-4">
                            <span class="text-sm ml-1 md:ml-0">@</span><span class="text-sm">{{ $user->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex-end ml-auto self-center">
                    @if (auth()->user()->isFollowing($user->id))
                    <form action="{{ route('unfollow', ['user' => $user->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">フォロー解除</button>
                    </form>
                    @else
                    <form action="{{ route('follow', ['user' => $user->id]) }}" method="POST">
                        {{ csrf_field() }}

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">フォローする</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach


        <div class="py-8 flex justify-center">
            {{ $all_users->links() }}
        </div>

    </div>
</x-app-layout>

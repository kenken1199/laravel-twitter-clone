<x-app-layout>
    <div class="flex items-center justify-between px-2 py-4 max-w-2xl mx-auto">
        <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Users</h1>
    </div>
    @foreach ($all_users as $user)
    <div class="mt-6">
        <div class="max-w-xl px-10 pt-6 pb-6 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex">
                <div class="flex items-center">
                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" alt="avatar" class=" hidden object-cover w-20 h-20  rounded-full sm:block  ">
                    <div class="ml-1">
                        <p class="">{{ $user->name }}</p>
                        <a href="{{ url('users/' .$user->id) }}" class="hover:underline">{{ $user->screen_name }}</a>
                    </div>
                </div>
                @if (auth()->user()->isFollowed($user->id))
                <div class="ml-1 mb-6 rounded-sm self-center bg-gray-200">
                    <span class="">フォローされています</span>
                </div>
                @endif
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

        <div class="my-8">
            <div class="">
                {{ $all_users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

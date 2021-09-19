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






    <div class="max-w-xl mb-3 px-10 pt-6 pb-2 mx-auto bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ url('users/' .$user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="">
                <div class="">
                    <div class="">
                        <label for="profile_image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Image') }}</label>
                        <div class="flex">
                            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class=" hidden object-cover w-20 h-20  rounded-full sm:block items-center ">

                            <input type="file" name="profile_image" class="@error('profile_image') is-invalid @enderror ml-10 mt-5" autocomplete="profile_image">
                        </div>
                    </div>
                    @error('profile_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="screen_name" class="">{{ __('Account Name') }}</label>

                <div class="">
                    <input id="screen_name" type="text" class=" block mt-1 w-full form-control @error('screen_name') is-invalid @enderror" name="screen_name" value="{{ $user->screen_name }}" required autocomplete="screen_name" autofocus>

                    @error('screen_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="">
                    <input id="name" type="text" class="block mt-1 w-full form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="">
                    <input id="email" type="email" class="block mt-1 w-full form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">更新する</button>
            </div>
        </form>



</x-app-layout>

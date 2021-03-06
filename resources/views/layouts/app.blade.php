<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>



<body class="font-sans h-full  antialiased flex flex-col">
    <nav class="px-6 py-2 bg-white shadow">
        <div x-data="{isOpen: false }" class="max-w-3xl mx-auto py-3 px-6 mb:px-0 md:flex md:justify-between md:items-center">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img src="{{ asset('storage/profile_image/' .Auth::user()->profile_image) }}" alt="avatar" class=" h-10 w-10 object-cover shadow rounded-full">
                    <a href="{{ url('users/' .Auth::user()->id )}}" class="text-gray-800 text-xl hover:text-gray-700 ml-4">{{Auth::user()->name}}</a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu" @click="isOpen = !isOpen">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                            <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menu, if mobile set to hidden -->
            <div :class="isOpen ? 'show' : 'hidden'" class="md:flex items-center">
                <div class="flex flex-col md:flex-row md:ml-6">
                    <a class="my-1 text-sm text-gray-700 font-medium hover:text-indigo-500 md:mx-4 md:my-0" href="{{ route('tweets.index') }}">Home</a>
                    <a class="my-1 text-sm text-gray-700 font-medium hover:text-indigo-500 md:mx-4 md:my-0" href="{{route('tweets.create')}}">??????????????????</a>
                    <div class=" inline my-1 text-sm cursor-pointer text-gray-700 hover:text-indigo-500 md:mx-4 md:my-0">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input type="submit" value="???????????????" class="bg-white ">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class=" bg-gray-100 flex-1">
        {{ $slot }}
    </div>
    <footer class="px-6 py-2 text-gray-100 bg-gray-800">
        <div class="container flex flex-col items-center justify-between mx-auto md:flex-row"><a href="#" class="text-2xl font-bold">Brand</a>
            <p class="mt-2 md:mt-0">All rights reserved 2020.</p>
            <div class="flex mt-4 mb-2 -mx-2 md:mt-0 md:mb-0"><a href="#" class="mx-2 text-gray-100 hover:text-gray-400"><svg viewBox="0 0 512 512" class="w-4 h-4 fill-current">
                        <path d="M444.17,32H70.28C49.85,32,32,46.7,32,66.89V441.61C32,461.91,49.85,480,70.28,480H444.06C464.6,480,480,461.79,480,441.61V66.89C480.12,46.7,464.6,32,444.17,32ZM170.87,405.43H106.69V205.88h64.18ZM141,175.54h-.46c-20.54,0-33.84-15.29-33.84-34.43,0-19.49,13.65-34.42,34.65-34.42s33.85,14.82,34.31,34.42C175.65,160.25,162.35,175.54,141,175.54ZM405.43,405.43H341.25V296.32c0-26.14-9.34-44-32.56-44-17.74,0-28.24,12-32.91,23.69-1.75,4.2-2.22,9.92-2.22,15.76V405.43H209.38V205.88h64.18v27.77c9.34-13.3,23.93-32.44,57.88-32.44,42.13,0,74,27.77,74,87.64Z">
                        </path>
                    </svg></a><a href="#" class="mx-2 text-gray-100 hover:text-gray-400"><svg viewBox="0 0 512 512" class="w-4 h-4 fill-current">
                        <path d="M455.27,32H56.73A24.74,24.74,0,0,0,32,56.73V455.27A24.74,24.74,0,0,0,56.73,480H256V304H202.45V240H256V189c0-57.86,40.13-89.36,91.82-89.36,24.73,0,51.33,1.86,57.51,2.68v60.43H364.15c-28.12,0-33.48,13.3-33.48,32.9V240h67l-8.75,64H330.67V480h124.6A24.74,24.74,0,0,0,480,455.27V56.73A24.74,24.74,0,0,0,455.27,32Z">
                        </path>
                    </svg></a><a href="#" class="mx-2 text-gray-100 hover:text-gray-400"><svg viewBox="0 0 512 512" class="w-4 h-4 fill-current">
                        <path d="M496,109.5a201.8,201.8,0,0,1-56.55,15.3,97.51,97.51,0,0,0,43.33-53.6,197.74,197.74,0,0,1-62.56,23.5A99.14,99.14,0,0,0,348.31,64c-54.42,0-98.46,43.4-98.46,96.9a93.21,93.21,0,0,0,2.54,22.1,280.7,280.7,0,0,1-203-101.3A95.69,95.69,0,0,0,36,130.4C36,164,53.53,193.7,80,211.1A97.5,97.5,0,0,1,35.22,199v1.2c0,47,34,86.1,79,95a100.76,100.76,0,0,1-25.94,3.4,94.38,94.38,0,0,1-18.51-1.8c12.51,38.5,48.92,66.5,92.05,67.3A199.59,199.59,0,0,1,39.5,405.6,203,203,0,0,1,16,404.2,278.68,278.68,0,0,0,166.74,448c181.36,0,280.44-147.7,280.44-275.8,0-4.2-.11-8.4-.31-12.5A198.48,198.48,0,0,0,496,109.5Z">
                        </path>
                    </svg></a>
            </div>
        </div>
    </footer>
    <script>
        let btns = document.querySelectorAll('.like_button');
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener('click', async function() {
                const tweet_id = this.dataset.tweet_id;
                let tweet = {};
                tweet.tweet_id = tweet_id;
                var d = JSON.stringify(tweet);
                let response = await fetch("{{ route('like') }}", {
                    headers: {
                        "X-CSRF-Token": document.querySelector('input[name=_token]').value,
                        'Content-Type': 'application/json;charset=utf-8',
                    },
                    method: 'POST',
                    body: d,
                })
                const data = await response.json();
                const counter = this.nextElementSibling;
                counter.innerHTML = data.review_likes_count;
                this.classList.toggle('text-red-600')
                this.classList.toggle('fas')
            }, false);
        }
    </script>
</body>

</html>

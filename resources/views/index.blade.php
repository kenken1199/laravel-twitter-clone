<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">

    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body class="flex flex-col h-full">
    <div class="flex flex-1">
        <div class="w-full bg-blue-300">
            <h3 class="">あなたの「好き」をフォローしましょう。</h3>
            <h3>話題のトピックを追いかけましょう。</h3>
            <h3>会話に参加しましょう。</h3>
        </div>
        <div class="w-full ">
            <h1 class="text-7xl">「いま」起きていることを見つけよう</h1>
            <h4 class="text-2xl">Twitterをはじめよう</h4>
            @if (Route::has('login'))
            <div class="">
                @auth
                <a href="{{ url('/tweets') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">アカウントを作成</a>
                @endif
                @endauth
            </div>
            @endif
        </div>
    </div>
    <footer class="mx-auto px-6 py-2">
        <span>ホーム</span>
        <span>よんでとは</span>
        <span>利用規約</span>
        <span>プライバシーポリシー</span>
        <span>お問い合わせ</span>
        <p class="text-center">© 2020 Kenta Nakamori</p>
    </footer>
</body>

</html>

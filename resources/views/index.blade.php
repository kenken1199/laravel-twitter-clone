<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">

    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body class="flex flex-col h-full">
    <div class="flex flex-1">
        <div class="w-full bg-cover bg-center " style="background-image: url(image/cover.jpg)">
        </div>
        <div class="w-full flex flex-col justify-center px-10 bg-gray-100">
            <h1 class="text-7xl font-black">「いま」起きていることを見つけよう</h1>
            <h4 class="text-2xl my-10 font-extrabold">Twitterをはじめよう</h4>
            @if (Route::has('register'))
            <div class="my-8">
                <a href="{{ route('register') }}" class="border bg-white border-black hover:bg-gray-100 text-black font-bold py-2 px-12 rounded">アカウントを作成</a>
            </div>
            @endif
            <div>
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="border bg-white border-black hover:bg-gray-100 text-black font-bold py-2 px-20 rounded">ログイン</a>
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
        <p class="text-center">© 2021 Kenta Nakamori</p>
    </footer>
</body>

</html>

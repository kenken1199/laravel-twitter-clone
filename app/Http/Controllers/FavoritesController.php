<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Tweet;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Favorite $favorite)
    {
        $user = auth()->user();
        $tweet_id = $request->tweet_id;
        $is_favorite = $favorite->isFavorite($user->id, $tweet_id);

        if (!$is_favorite) {
            $favorite->storeFavorite($user->id, $tweet_id);
            return back();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $user_id = $favorite->user_id;
        $tweet_id = $favorite->tweet_id;
        $favorite_id = $favorite->id;
        $is_favorite = $favorite->isFavorite($user_id, $tweet_id);

        if ($is_favorite) {
            $favorite->destroyFavorite($favorite_id);
            return back();
        }
        return back();
    }

    public function like(Request $request, Favorite $favorite)
    {
        $user = auth()->user(); //1.ログインユーザー取得
        $tweet_id = $request->tweet_id; //2.投稿idの取得
        $is_favorite = $favorite->isFavorite($user->id, $tweet_id);

        if (!$is_favorite) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            $favorite->storeFavorite($user->id, $tweet_id);
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
            Favorite::where('user_id', $user->id)->where('tweet_id', $tweet_id)->delete();
        }
        //5.この投稿の最新の総いいね数を取得
        $review_likes_count = Tweet::withCount('favorites')->findOrFail($tweet_id)->favorites_count;
        $param = [
            'review_likes_count' => $review_likes_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'text'
    ];

    // getCommentsのwith('user')に必要
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getComments(Int $tweet_id)
    {
        return $this->with('user')->where('tweet_id', $tweet_id)->get();
    }

    public function commentStore(Int $user_id, array $data)
    {
        $this->user_id = $user_id;
        $this->tweet_id = $data['tweet_id'];
        $this->text = $data['text'];
        $this->save();

        return;
    }
}

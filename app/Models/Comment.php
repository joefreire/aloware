<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'comments';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded  = [
        'id',
    ];
    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_replied_id');
    }
}

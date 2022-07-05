<?php
declare(strict_types =1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected  $fillable = [
        'body'
    ];

    protected $casts = [
        'body' => 'array'
    ];

    public  function  post()
    {
        return $this->belongsTo(
            related: Post::class,
            foreignKey: 'post_id'
        );
    }


    public  function  user()
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id'
        );
    }

}

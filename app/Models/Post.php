<?php
declare(strict_types =1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'body' => 'array'
    ];

    public  function  comments()
    {
        return $this->hasMany(
           related:   Comment::class,
           foreignKey: 'post_id'
        );
    }

    public  function  users()
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'post_user',
            foreignPivotKey: 'post_id',
            relatedPivotKey: 'user_id'
        );
    }

}

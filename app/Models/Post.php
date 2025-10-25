<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'post';

    protected $fillable = [
        'topic_id',
        'title',
        'slug',
        'detail',
        'thumbnail',
        'type',
        'description',
        'status',
        'created_by',
        'updated_by'
    ];

    // ✅ Quan hệ: mỗi bài viết thuộc về một chủ đề
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }
}

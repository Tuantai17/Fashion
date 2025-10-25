<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostItem extends Component
{
    public $post_row;

    public function __construct($postitem)
    {
        $this->post_row = $postitem;
    }

    public function render(): View|Closure|string
    {
        $relatedPosts = Post::where('id', '!=', $this->post_row->id)
                            ->where('status', 1)
                            ->orderBy('created_at', 'desc')
                            ->take(4)
                            ->get();

        return view('components.post-item', [
            'post' => $this->post_row,
            'relatedPosts' => $relatedPosts
        ]);
    }
}

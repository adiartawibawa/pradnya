<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class View extends Component
{
    public $post;

    public function mount($slug)
    {
        $this->post = Post::whereSlug($slug)->first();
    }

    public function render()
    {
        return view('livewire.post.view', [
            'post' => $this->post,
        ]);
    }
}

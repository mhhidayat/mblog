<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class BlogPost extends Component
{
    public Post $post;

    public function mount($slug)
    {
        $this->post = Post::published()->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.blog-post')
            ->layout('layouts.app', ['title' => $this->post->title . ' - M-Blog']);
    }
}

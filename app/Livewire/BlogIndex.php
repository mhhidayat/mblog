<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::published()
            ->when($this->search, function ($query) {
                $query->where('title', 'ilike', '%' . $this->search . '%')
                      ->orWhere('content', 'ilike', '%' . $this->search . '%');
            })
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        return view('livewire.blog-index', compact('posts'))
            ->layout('layouts.app', ['title' => 'M-Blog - Latest Posts']);
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, published, draft

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function deletePost($postId)
    {
        try {
            $post = Post::findOrFail($postId);
            $postTitle = $post->title;
            $post->delete();

            // Reset to first page if current page becomes empty
            $this->resetPage();

            session()->flash('message', "Post '{$postTitle}' deleted successfully!");

            // Refresh the component to update stats and post list
            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete post. Please try again.');
        }
    }

    public function togglePublished($postId)
    {
        try {
            $post = Post::findOrFail($postId);
            $newStatus = !$post->published;

            $post->update([
                'published' => $newStatus,
                'published_at' => $newStatus ? now() : null
            ]);

            $statusText = $newStatus ? 'published' : 'unpublished';
            session()->flash('message', "Post '{$post->title}' {$statusText} successfully!");

            // Refresh the component to update stats
            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update post status. Please try again.');
        }
    }

    public function render()
    {
        $posts = Post::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'ilike', '%' . $this->search . '%')
                    ->orWhere('content', 'ilike', '%' . $this->search . '%');
            })
            ->when($this->filter === 'published', function ($query) {
                $query->where('published', true);
            })
            ->when($this->filter === 'draft', function ($query) {
                $query->where('published', false);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Post::count(),
            'published' => Post::where('published', true)->count(),
            'drafts' => Post::where('published', false)->count(),
        ];

        return view('livewire.admin.dashboard', compact('posts', 'stats'))
            ->layout('layouts.admin', ['title' => 'Dashboard']);
    }
}

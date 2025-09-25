<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;

class PostForm extends Component
{
    public Post $post;
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $featured_image = '';
    public $published = false;
    public $published_at = '';

    public $isEditing = false;
    public $showPreview = false;
    public $wordCount = 0;
    public $lastSaved = null;
    public $validationErrors = [];
    public $showValidationAlert = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'slug' => 'required|min:3|max:255|unique:posts,slug',
        'excerpt' => 'nullable|max:500',
        'content' => 'required|min:10',
        'featured_image' => 'nullable|url',
        'published' => 'boolean',
        'published_at' => 'nullable|date',
    ];

    public function mount($post = null)
    {
        if ($post && $post instanceof Post && $post->exists) {
            $this->isEditing = true;
            $this->post = $post;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt;
            $this->content = $post->content;
            $this->featured_image = $post->featured_image;
            $this->published = $post->published;
            $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '';
            $this->updatedContent();
        } else {
            $this->post = new Post();
            // Only load draft if user explicitly requests it, not automatically
            // This prevents old drafts from appearing when creating new posts
        }
    }

    public function updatedTitle()
    {
        if (!$this->isEditing) {
            $this->slug = Str::slug($this->title);
        }
        $this->clearFieldError('title');
        $this->autoSave();
    }

    public function updatedPublished()
    {
        if ($this->published && !$this->published_at) {
            $this->published_at = now()->format('Y-m-d\TH:i');
        }
    }

    public function updatedContent()
    {
        $this->wordCount = str_word_count(strip_tags($this->content));
        $this->clearFieldError('content');
        $this->autoSave();
    }

    public function updatedExcerpt()
    {
        $this->clearFieldError('excerpt');
        $this->autoSave();
    }

    public function updatedSlug()
    {
        $this->clearFieldError('slug');
    }

    public function updatedFeaturedImage()
    {
        $this->clearFieldError('featured_image');
    }

    private function clearFieldError($field)
    {
        if (isset($this->validationErrors[$field])) {
            unset($this->validationErrors[$field]);
            if (empty($this->validationErrors)) {
                $this->showValidationAlert = false;
            }
        }
    }

    private function autoSave()
    {
        // Only auto-save if we're not editing an existing post and there's actual content
        if (!$this->isEditing && ($this->title || $this->content)) {
            session()->put('post_draft', [
                'title' => $this->title,
                'slug' => $this->slug,
                'excerpt' => $this->excerpt,
                'content' => $this->content,
                'featured_image' => $this->featured_image,
            ]);
            $this->lastSaved = now()->format('H:i:s');
        }
    }

    public function hasDraft()
    {
        return session()->has('post_draft') && !$this->isEditing;
    }

    public function loadDraft()
    {
        $draft = session()->get('post_draft');
        if ($draft && !$this->isEditing) {
            $this->title = $draft['title'] ?? '';
            $this->slug = $draft['slug'] ?? '';
            $this->excerpt = $draft['excerpt'] ?? '';
            $this->content = $draft['content'] ?? '';
            $this->featured_image = $draft['featured_image'] ?? '';
            $this->updatedContent();
        }
    }

    public function clearDraft()
    {
        session()->forget('post_draft');
        $this->lastSaved = null;
    }

    public function confirmStartFresh()
    {
        $this->dispatch('confirm-start-fresh');
    }

    public function startFresh()
    {
        $this->clearDraft();
        $this->title = '';
        $this->slug = '';
        $this->excerpt = '';
        $this->content = '';
        $this->featured_image = '';
        $this->published = false;
        $this->published_at = '';
        $this->wordCount = 0;
        $this->lastSaved = null;
        $this->validationErrors = [];
        $this->showValidationAlert = false;
        
        session()->flash('success', 'Form cleared successfully!');
    }

    public function togglePreview()
    {
        $this->showPreview = !$this->showPreview;
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function saveAsDraft()
    {
        $this->published = false;
        $this->published_at = '';
        $this->save();
    }

    public function publishNow()
    {
        $this->published = true;
        $this->published_at = now()->format('Y-m-d\TH:i');
        $this->save();
    }

    public function quickValidate()
    {
        $errors = [];
        
        if (empty(trim($this->title))) {
            $errors[] = 'Title is required';
        }
        
        if (empty(trim($this->content))) {
            $errors[] = 'Content is required';
        }
        
        if (empty(trim($this->slug))) {
            $errors[] = 'URL slug is required';
        }

        return $errors;
    }

    public function loadTemplate($template)
    {
        switch ($template) {
            case 'tutorial':
                $this->title = 'How to [Topic]: A Step-by-Step Guide';
                $this->content = "# Introduction\n\nBrief introduction to what readers will learn.\n\n## Prerequisites\n\n- Requirement 1\n- Requirement 2\n\n## Step 1: [First Step]\n\nDetailed explanation of the first step.\n\n## Step 2: [Second Step]\n\nDetailed explanation of the second step.\n\n## Conclusion\n\nSummarize what was accomplished and next steps.";
                break;
            case 'review':
                $this->title = '[Product/Service] Review: Is It Worth It?';
                $this->content = "# Overview\n\nBrief introduction to what you're reviewing.\n\n## Pros\n\n- Positive aspect 1\n- Positive aspect 2\n\n## Cons\n\n- Negative aspect 1\n- Negative aspect 2\n\n## Final Verdict\n\nYour overall recommendation and rating.";
                break;
            case 'listicle':
                $this->title = 'X Best [Topic] for [Year]';
                $this->content = "# Introduction\n\nWhy this list matters and what criteria you used.\n\n## 1. [First Item]\n\nDescription and why it made the list.\n\n## 2. [Second Item]\n\nDescription and why it made the list.\n\n## Conclusion\n\nSummary and your top recommendation.";
                break;
        }
        $this->generateSlug();
    }

    protected function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:posts,slug' . ($this->isEditing ? ',' . $this->post->id : ''),
            'excerpt' => 'nullable|max:500',
            'content' => 'required|min:10',
            'featured_image' => 'nullable|url',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ];

        return $rules;
    }

    public function validateForm()
    {
        $this->validationErrors = [];
        $this->showValidationAlert = false;

        // Validate title
        if (empty(trim($this->title))) {
            $this->validationErrors['title'] = 'Title is required.';
        } elseif (strlen($this->title) < 3) {
            $this->validationErrors['title'] = 'Title must be at least 3 characters long.';
        } elseif (strlen($this->title) > 255) {
            $this->validationErrors['title'] = 'Title cannot exceed 255 characters.';
        }

        // Validate slug
        if (empty(trim($this->slug))) {
            $this->validationErrors['slug'] = 'URL slug is required.';
        } elseif (strlen($this->slug) < 3) {
            $this->validationErrors['slug'] = 'URL slug must be at least 3 characters long.';
        } elseif (strlen($this->slug) > 255) {
            $this->validationErrors['slug'] = 'URL slug cannot exceed 255 characters.';
        } elseif (!preg_match('/^[a-z0-9-]+$/', $this->slug)) {
            $this->validationErrors['slug'] = 'URL slug can only contain lowercase letters, numbers, and hyphens.';
        }

        // Check slug uniqueness
        if (!isset($this->validationErrors['slug'])) {
            $existingPost = Post::where('slug', $this->slug);
            if ($this->isEditing) {
                $existingPost->where('id', '!=', $this->post->id);
            }
            if ($existingPost->exists()) {
                $this->validationErrors['slug'] = 'This URL slug is already taken. Please choose a different one.';
            }
        }

        // Validate content
        if (empty(trim($this->content))) {
            $this->validationErrors['content'] = 'Content is required.';
        } elseif (strlen($this->content) < 10) {
            $this->validationErrors['content'] = 'Content must be at least 10 characters long.';
        }

        // Validate excerpt
        if (!empty($this->excerpt) && strlen($this->excerpt) > 500) {
            $this->validationErrors['excerpt'] = 'Excerpt cannot exceed 500 characters.';
        }

        // Validate featured image
        if (!empty($this->featured_image) && !filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            $this->validationErrors['featured_image'] = 'Featured image must be a valid URL.';
        }

        // Validate published date
        if ($this->published && !empty($this->published_at)) {
            if (!strtotime($this->published_at)) {
                $this->validationErrors['published_at'] = 'Please enter a valid date and time.';
            }
        }

        if (!empty($this->validationErrors)) {
            $this->showValidationAlert = true;
            return false;
        }

        return true;
    }

    public function dismissValidationAlert()
    {
        $this->showValidationAlert = false;
    }

    public function save()
    {
        // Run custom validation first
        if (!$this->validateForm()) {
            return;
        }

        try {
            // Run Laravel validation as backup
            $this->validate();

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'excerpt' => $this->excerpt,
                'content' => $this->content,
                'featured_image' => $this->featured_image ?: null,
                'published' => $this->published,
                'published_at' => $this->published && $this->published_at ? $this->published_at : null,
            ];

            if ($this->isEditing) {
                $this->post->update($data);
                session()->flash('success', 'Post updated successfully!');
                session()->flash('message', 'Your post has been updated and is now live.');
            } else {
                Post::create($data);
                $this->clearDraft();
                session()->flash('success', 'Post created successfully!');
                session()->flash('message', $this->published ? 'Your post has been published and is now live.' : 'Your post has been saved as a draft.');
            }

            return redirect()->route('admin.dashboard');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle Laravel validation errors
            $this->validationErrors = $e->validator->errors()->toArray();
            $this->showValidationAlert = true;
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while saving the post. Please try again.');
        }
    }

    public function render()
    {
        $title = $this->isEditing ? 'Edit Post' : 'Create New Post';
        
        return view('livewire.admin.post-form')
            ->layout('layouts.admin', ['title' => $title]);
    }
}

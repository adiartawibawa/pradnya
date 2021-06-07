<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class AllPost extends Component
{

    use WithPagination;
    public $searchTerm;
    public $sortColumn = 'created_at';
    public $sortDirection  = 'desc';

    public function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function allPost()
    {
        return Post::where(function ($query) {
            $query->where('author_id', Auth::user()->id);

            if ($this->searchTerm != "") {
                $query->where('title', 'like', '%' . $this->searchTerm . '%');
            }
        })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->with('topic')
            ->with('tags')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.post.all-post', [
            'posts' => $this->allPost(),
        ]);
    }
}

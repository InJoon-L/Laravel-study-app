<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public $newComment;

    protected $rules = [
        'newComment' => 'required|string'
    ];

    protected $listeners = [
        'delete' => 'remove'
    ];

    public function mount() {
        $this->newComment = "Hello World";
    }

    public function remove($commentId) {
        $comment = Comment::find($commentId);
        $comment->delete();

        session()->flash("message", 'Comment deleted successfully');
    }

    public function addComment() {
        $this->validate();

        Comment::create([
            'user_id' => auth()->user()->id,
            'content' => $this->newComment,
        ]);
        $this->newComment = null;
        session()->flash("message", 'Comment created successfully');
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::latest()->paginate(5)
        ]);
    }
}

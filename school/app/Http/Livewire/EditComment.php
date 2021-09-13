<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class EditComment extends ModalComponent
{
    use WithFileUploads;

    public $commentId;
    public $orgComment;
    public $newComment;
    public $image;

    protected $listener = [
        'update' => 'updateComment'
    ];

    public function updateComment() {
        $this->closeModal();
    }

    public function mount($commentId) {
        $this->commentId = $commentId;
        $this->orgComment = Comment::find($commentId);
        $this->newComment = $this->orgComment->content;
    }

    public function render()
    {
        return view('livewire.edit-comment');
    }
}

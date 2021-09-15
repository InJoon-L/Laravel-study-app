<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class EditComment extends ModalComponent
{
    use WithFileUploads;

    public $commentId;
    public $orgComment;
    public $newComment;
    public $image;

    protected $listeners = [
        'update' => 'updateComment'
    ];

    public function updateComment() {
        $this->validate([
            'newComment' => 'required|string',
            'image' => 'nullable|image|max:10240'
        ]);

        // 이미지가 있으면 원하는 폴더에 저장하고 저장된 그
        // 파일의 이름을 기억한다. $imageFileName
        $imageFileName = null;

        if ($this->image) {
            // 기존 Comment 객체의 이미지가 있는지 확인하고
            // 있다면 파일시스템에서 삭제를 먼저 하자.
            if ($this->orgComment->image) {
                // 삭제하자
                Storage::disk('public')->delete('images/'.$this->orgComment->image);
            }

            $imageFileName = $this->storeImage();
            $this->orgComment->image = $imageFileName;
        }

        $this->orgComment->content = $this->newComment;
        $this->orgComment->save();

        $this->newComment = '';
        $this->image = '';

        session()->flash("message", 'Comment updated successfully');
        $this->closeModal();

        $this->emit('commentUpdated');
    }

    public function storeImage() {
        $img = ImageManagerStatic::make($this->image)
        ->resize(300, 300)
        ->encode('jpg');
        $name = Str::random().'.jpg';
        Storage::disk('public')->put('images/'.$name, $img);

        return $name;
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

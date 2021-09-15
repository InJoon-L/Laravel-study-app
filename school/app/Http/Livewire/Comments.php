<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $newComment;
    public $image;
    public $userId;

    protected $rules = [
        'newComment' => 'required|string',
        'image' => 'nullable|image|max:2048'
    ];

    protected $listeners = [
        'delete' => 'remove',
        'commentUpdated' => 'getComments',
        'userSelected',
    ];

    public function userSelected($userId) {
        $this->userId = $userId;
    }

    public function getComments() {

    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function mount() {
        if (!$this->userId) {
            $this->userId = auth()->user()->id;
        }
    }

    public function remove($commentId) {
        $comment = Comment::find($commentId);
        if ($comment->image) {
            Storage::disk('public')->delete('images/'.$comment->image);
        }
        $comment->delete();

        session()->flash("message", 'Comment deleted successfully');
    }

    public function addComment() {
        $this->validate();

        // 이미지가 있으면 원하는 폴더에 저장하고 저장된 그
        // 파일의 이름을 기억한다. $imageFileName
        $imageFileName = null;

        if ($this->image) {
            $imageFileName = $this->storeImage();
        }

        Comment::create([
            'user_id' => auth()->user()->id,
            'content' => $this->newComment,
            'image' => $imageFileName,
        ]);

        $this->newComment = '';
        $this->image = '';

        session()->flash("message", 'Comment created successfully');
    }

    public function storeImage() {
        $img = ImageManagerStatic::make($this->image)
        ->resize(300, 300)
        ->encode('jpg');
        $name = Str::random().'.jpg';
        // $this->image->storeAs('public/images', $name);
        Storage::disk('public')->put('images/'.$name, $img);

        return $name;
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::where('user_id', $this->userId)->latest()->paginate(5)
        ]);
    }
}

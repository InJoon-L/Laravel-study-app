<div>
    @foreach ($comments as $comment)
<div class="card text-center shadow-2xl">
    <figure class="px-10 pt-10">
        @if($comment->image)
        <img src="{{ $comment->image }}" class="rounded-xl">
        @endif
    </figure>
    <div class="card-body">
      <h2 class="card-title">shadow, center, padding</h2>
      <p>{{ $comment->content }}</p>
      <div class="justify-center card-actions">
        <button class="btn btn-outline btn-accent">More info</button>
      </div>
    </div>
</div>
  @endforeach
</div>

<div class="mb-2">
  @foreach ($tags as $tag)
      <x-tag>
        @slot('tagId', $tag->id)
        @slot('tagName', $tag->name)
      </x-tag>
  @endforeach
</div>
@foreach($posts as $post)
<article class="post-content">
	<h3>{{ $post->title }}</h3>
	<p>
		{{ $post->content }}
		<a href="{{ $post->permalink }}">Read more</a>
	</p>
</article>
@endforeach
<div class="text-center">
	{{ paginator_links($posts) }}
</div>

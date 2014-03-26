<?php

use Simple\Repositories\PostRepository as Post;

class SimpleThemeController extends Controller
{
	protected $post;

	public function __construct(Post $post) {
		$this->post = $post;
	}

	/**
	 * All posts.
	 * 
	 * @return Response
	 */
	public function allPosts()
	{
		$posts = $this->post->all();
		return Theme::view('posts', compact('posts'));
	}
}
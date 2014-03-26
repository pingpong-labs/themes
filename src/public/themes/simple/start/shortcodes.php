<?php

/**
 * Get post content wih given id or slug.
 *
 * @param  array   $attr
 * @param  string  $content
 * @return string
 */
Shortcode::register('post-content', function($attr, $content)
{
	$id = array_get($attr, 'id');
	$repo = App::make('Simple\Repositories\PostRepository');
	$post = $repo->findById($id);
	if($post)
	{
		return $post->content;
	}
	return null;
});

/**
 * Portfolio Shortcode.
 *
 * @param  array   $attr
 * @param  string  $content
 * @return string
 */
Shortcode::register('portfolio', function($attr, $content)
{
	$id = Category::whereSlug('portfolio')->first();
	if( ! $id)
	{
		return null;
	}
	$repo = App::make('Simple\Repositories\PostRepository');
	$posts = $repo->findByCategory($id);
	if($posts->count())
	{
		return Theme::view('portfolio', compact('posts'));
	}
});
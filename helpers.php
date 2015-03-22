<?php

if ( ! function_exists('theme'))
{
	/**
	 * Return a specified view from current theme.
	 * 
	 * @param  string $view
	 * @param  array  $data
	 * @param  array  $mergeData
	 * @return \Illuminate\View\View
	 */
	function theme($view, array $data = array(), array $mergeData = array())
	{
		return app('themes')->view($view, $data, $mergeData);
	}
}
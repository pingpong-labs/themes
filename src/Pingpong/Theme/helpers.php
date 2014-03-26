<?php

if( ! function_exists('t'))
{
	/**
	 * Translate the given message.
	 *
	 * @param  string  $id
	 * @param  array   $parameters
	 * @param  string  $domain
	 * @param  string  $locale
	 * @return string
	 */
	function t($id, $parameters = array(), $domain = 'messages', $locale = null)
	{
		return Theme::lang('theme.'.$id, $parameters, $domain, $locale);
	}
}

if( ! function_exists('c'))
{
	/**
	 * Get configuration value form given key.
	 *
	 * @param  string  		$key
	 * @param  string|null  $default
	 * @return string
	 */
	function c($key, $default = null)
	{
		return Theme::config('theme.'.$key, $default);
	}
}


<?php namespace Pingpong\Theme;

use Countable;
use PDOException;
use Illuminate\Foundation\Application;

class Theme implements Countable
{
	/**
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Current theme.
	 *
	 * @var string|mixed $current.
	 */
	protected $current = 'white';

	public function __construct(Application $app) {
		$this->app = $app;
		$this->view = $app['view'];
		$this->themeFinder = $app['theme.finder'];
	}

	/**
	 * Get all themes.
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->themeFinder->all();
	}

	/**
	 * Get all themes with detail for each theme.
	 *
	 * @return array
	 */
	public function allDetails()
	{
		return $this->themeFinder->allDetails();
	}

	/**
	 * Is theme exists ?
	 *
	 * @param 	string   $theme
	 * @return 	boolean|mixed
	 */
	public function has($theme)
	{
		return in_array($theme, $this->all());
	}

	/**
	 * Get detail for the specified theme.
	 *
	 * @param 	string   	$theme
	 * @param 	null|mixed  $default
	 * @return 	array
	 */
	public function get($theme, $default = null)
	{
		if($this->has($theme))
		{
			return $this->themeFinder->detail($theme);
		}
		return $default;
	}

	/**
	 * Set current theme.
	 *
	 * @param 	string   $theme
	 * @return 	self
	 */
	public function set($theme)
	{
		$this->current = $theme;
		return $this;
	}

	/**
	 * Get the current theme.
	 *
	 * @return string
	 */
	public function current()
	{
		try{
	    	if(site('theme') !== $this->current)
	    	{
	    		return site('theme') == '' ? $this->current : site('theme');
	    	}
	    	return $this->current;
	    }
	    catch(PDOException $e){
	       return $this->current;
	    }
	}

	/**
	 * Get count all themes.
	 *
	 * @return integer
	 */
	public function count()
	{
		return count($this->all());
	}

	/**
	 * Get theme path.
	 * 
	 * @return string
	 */
	public function getPath()
	{
		return $this->app['config']->get('theme::theme.path', null);
	}

	/**
	 * Call view from current theme.
	 *
	 * @param 	string   $url
	 * @param 	array    $data
	 * @param 	array    $mergeData
	 * @return Response
	 */
	public function view($view, $data = array(), $mergeData = array())
	{
		$name = $this->current().'::'.$view;
		return $this->view->make($name, $data, $mergeData);
	}

	/**
	 * Generate a asset url for current theme.
	 *
	 * @param 	string   $url
	 * @param 	boolean  $secure
	 * @return 	Response
	 */
	public function asset($url, $secure = false)
	{
		return $this->app['url']->asset('themes/'. $this->current().'/assets/'.$url, $secure);
	}

	/**
	 * Generate a link to a CSS file.
	 *
	 * @param  string  $url
	 * @param  array   $attributes
	 * @return string
	 */
	public function style($url, $attributes = array(), $secure = false)
	{
		$defaults = array('media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet');

		$attributes = $attributes + $defaults;

		$attributes['href'] = $this->asset($url, $secure);

		return '<link'.$this->app['html']->attributes($attributes).'>'.PHP_EOL;
	}

	/**
	 * Generate a link to a JavaScript file.
	 *
	 * @param  string  $url
	 * @param  array   $attributes
	 * @return string
	 */
	public function script($url, $attributes = array(), $secure = false)
	{
		$attributes['src'] = $this->asset($url, $secure);

		return '<script'.$this->app['html']->attributes($attributes).'></script>'.PHP_EOL;
	}

	/**
	 * Translate the given message.
	 *
	 * @param  string  $id
	 * @param  array   $parameters
	 * @param  string  $domain
	 * @param  string  $locale
	 * @return string
	 */
	public function lang($id, $parameters = array(), $domain = 'messages', $locale = null)
	{
		$lang = $this->app['translator']->trans(Theme::current().'::'.$id, $parameters, $domain, $locale);
		if(is_array($lang))
		{
			if(isset($lang[0]) and count($lang) == 1)
			{
				return value($lang[0]);
			}
			return $lang;
		}
		return $lang;
	}

	/**
	 * Get the specified configuration value for current theme.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function config($key, $default = null)
	{
		$config = $this->app['config']->get($this->current().'::'.$key, $default);
		if(is_array($config))
		{
			if(isset($config[0]) and count($config) == 1)
			{
				return value($config[0]);
			}
			return $config;
		}
		return $config;
	}
}
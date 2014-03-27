<?php namespace Pingpong\Theme;

use Exception;
use Illuminate\Foundation\Application;

class ThemePresenter
{
	/**
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $file;

	/**
	 * Current theme name.
	 *
	 * @var string $theme
	 */
	protected $theme;

	/**
	 * Current theme detail.
	 *
	 * @var string $detail
	 */
	protected $detail;

	public function __construct($theme, Application $app)
	{
		$this->theme = $theme;
		$this->app = $app;
		$this->file = $app['files'];
		$this->setDetail();
	}

	/**
	 * Get content detail from current theme.
	 *
	 * @return mixed
	 */
	public function getContent()
	{
		$path = $this->getThemePath();
		$file = $path.$this->theme.'/theme.json';
		if($this->file->exists($file))
		{
			return $this->file->get($file);
		}
		throw new Exception("Theme [$this->theme] does not exists.");		  
	}

	/**
	 * Set detail to the storage.
	 *
	 * @return self
	 */
	protected function setDetail($option = false)
	{
		$this->detail = json_decode($this->getContent(), $option);
		return $this;
	}

	/**
	 * Get content detail from current theme.
	 *
	 * @return mixed
	 */
	public function getDetail()
	{
		return $this->detail;
	}

	/**
	 * Get content detail from current theme.
	 *
	 * @param  boolean $option
	 * @return mixed
	 */
	public function get($option = false)
	{
		return $this->setDetail($option)->getDetail();
	}

	/**
	 * Magic method get to handle get property.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if($key == 'image')
		{
			return $this->getImage();
		}
		if($key == 'slug')
		{
			return $this->theme;
		}
		return isset($this->detail->$key)
			? $this->detail->$key
			: null;
	}

	/**
	 * Get screenshoot image.
	 * 
	 * @return mixed
	 */
	public function getImage()
	{
		$image = $this->getThemePath() . $this->theme . '/theme.png';
		if(file_exists($image))
		{
			return asset("themes/$this->theme/theme.png");
		}
		return null;
	}

	/**
	 * Get content detail from current theme.
	 *
	 * @return mixed
	 */
	public function __toString()
	{
		return $this->get(TRUE);
	}

	/**
	 * Get theme path.
	 *
	 * @return string
	 */
	protected function getThemePath()
	{
		return $this->app['theme']->getPath();
	}
}
<?php namespace Pingpong\Theme;

use Illuminate\Support\Str;
use Simple\Theme\ThemePresenter;
use Illuminate\Foundation\Application;

class ThemeFinder
{
	/**
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $file;

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->file = $app['files'];
	}

	/**
	 * Get all theme by folder name.
	 *
	 * @return array
	 */
	public function all()
	{
		$collection = array();
		$themes = $this->file->directories($this->getThemePath());
		foreach ($themes as $theme) {
			$name = basename($theme);
			if( ! Str::startsWith($name, '.'))
			{
				$collection[] = $name;
			}
		}
		return $collection;
	}

	/**
	 * Get all with detail for each theme.
	 *
	 * @return array
	 */
	public function allDetails()
	{
		$collection = array();
		foreach ($this->all() as $theme) {
			$collection[$theme] = new ThemePresenter($theme, $this->app);
		}
		return $collection;
	}

	/**
	 * Get detail from the specified theme.
	 *
	 * @return array
	 */
	public function detail($theme, $option = true)
	{
		$themes = $this->allDetails();
		return $themes[$theme]->get($option);
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
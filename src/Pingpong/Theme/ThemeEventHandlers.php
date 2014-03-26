<?php namespace Pingpong\Theme;

use Simple\Interfaces\SubscribleInterface;

class ThemeEventHandlers implements SubscribleInterface
{
	/**
	 * @var \Simple\Theme\Theme
	 */
	protected $theme;

	/**
	 * @var \Simple\Theme\Theme
	 */
	public function __construct(Theme $theme) {
		$this->theme = $theme;
	}

	/**
	 * Subscribe method.
	 * 
	 * @param  $events
	 * @return void
	 */
	public function subscribe($event)
	{
		$event->listen('theme.routes', __CLASS__.'@includeRoutesFile');
	}

	/**
	 * @return void
	 */
	public function includeRoutesFile()
	{
		$file = $this->theme->getPath() .'/'. $this->theme->current() . '/start/routes.php';
		if(file_exists($file))
		{
			include $file;
		}
	}
}
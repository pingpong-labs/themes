<?php namespace Pingpong\Theme;

use Pingpong\Interfaces\SubscribleInterface;

class ThemeEventHandlers implements SubscribleInterface
{
	/**
	 * @var \Pingpong\Theme\Theme
	 */
	protected $theme;

	/**
	 * @var \Pingpong\Theme\Theme
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
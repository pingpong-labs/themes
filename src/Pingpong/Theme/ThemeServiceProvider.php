<?php namespace Pingpong\Theme;

use Illuminate\Support\ServiceProvider;
use Pingpong\Theme\Command\ThemeMakeCommand;
use Pingpong\Theme\Command\ThemePublishCommand;

class ThemeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('pingpong/theme');
		$this->registerNamespaces();
		$this->registerAutoloader();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['theme.finder'] = $this->app->share(function($app)
		{
			return new ThemeFinder($app);
		});
		$this->app['theme'] = $this->app->share(function($app)
		{
			return new Theme($app);
		});
		$this->app['theme.generator'] = $this->app->share(function($app)
		{
			return new ThemeMakeCommand;
		});
		$this->app['theme.publisher'] = $this->app->share(function($app)
		{
			return new ThemePublishCommand;
		});
		$this->commands('theme.generator', 'theme.publisher');
		$this->registerHelpers();
	}

	/**
	 * Register The Namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		$themes = $this->app['theme']->all();
		$path = $this->app['theme']->getPath();

		// register global themes namespace
		$this->app['view']->addNamespace('themes', $path);
		
		// register single theme namespace
		// there is register config, views and lang for the specified theme
		foreach ($themes as $theme) {
			$this->app['config']->addNamespace($theme, $path.$theme.'/config/');
			$this->app['view']->addNamespace($theme, $path.$theme.'/views/');
			$this->app['translator']->addNamespace($theme, $path.$theme.'/lang/');
		}
	}

	/**
	 * Register The Autoloader.
	 *
	 * @return void
	 */
	public function registerAutoloader()
	{
		$path = $this->app['theme']->getPath();
		$themes = $this->app['theme']->all();
		foreach ($themes as $theme) {
			$file = $path.$theme.'/start/global.php';
			if($this->app['files']->exists($file))
			{
				require $file;
			}
		}
	}

	/**
	 * Register The Helpers.
	 *
	 * @return void
	 */
	public function registerHelpers()
	{
		require __DIR__.'/helpers.php';
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('theme', 'theme.finder');
	}

}
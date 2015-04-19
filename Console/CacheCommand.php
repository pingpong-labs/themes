<?php

namespace Pingpong\Themes\Console;

use Illuminate\Console\Command;

class CacheCommand extends Command {

	/**
	 * Command name.
	 * 
	 * @var string
	 */
	protected $name = 'theme:cache';

	/**
	 * Command description.
	 * 
	 * @var string
	 */
	protected $description = 'Create a theme cache file for faster theme loading';

	/**
	 * Execute command.
	 * 
	 * @return void
	 */
	public function fire()
	{
		$this->clear();
		$this->cache();
	}

	/**
	 * Clear cached themes.
	 * 
	 * @return void
	 */
	protected function clear()
	{
		$this->laravel['cache']->forget($this->laravel['themes']->getCacheKey());

		$this->info("Theme cache cleared!");
	}

	/**
	 * Cache the themes.
	 * 
	 * @return void
	 */
	protected function cache()
	{
		$this->laravel['cache']->put(
			$this->laravel['themes']->getCacheKey(),
			$this->laravel['themes']->toArray(),
			$this->laravel['themes']->getCacheLifetime()
		);

		$this->info("Themes cached successfully!");
	}

}
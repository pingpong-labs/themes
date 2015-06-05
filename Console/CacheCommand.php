<?php

namespace Pingpong\Themes\Console;

use Illuminate\Console\Command;

class CacheCommand extends Command
{
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
     */
    public function fire()
    {
        $this->clear();
        $this->cache();
    }

    /**
     * Clear cached themes.
     */
    protected function clear()
    {
        $this->laravel['themes']->forgetCache();

        $this->info('Theme cache cleared!');
    }

    /**
     * Cache the themes.
     */
    protected function cache()
    {
        $this->laravel['themes']->cache();

        $this->info('Themes cached successfully!');
    }
}

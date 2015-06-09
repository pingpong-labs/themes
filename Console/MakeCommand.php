<?php

namespace Pingpong\Themes\Console;

use Illuminate\Console\Command;
use Pingpong\Support\Stub;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeCommand extends Command
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $name = 'theme:make';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Create a new theme';

    /**
     * Execute command.
     */
    public function fire()
    {
        $name = strtolower($this->argument('name'));

        if ($this->laravel['themes']->has($name) && !$this->option('force')) {
            $this->error('Theme already exists.');

            return;
        }

        $this->generate($name);
    }

    /**
     * Generate a new theme by given theme name.
     *
     * @param string $name
     */
    protected function generate($name)
    {
        $themePath = config('themes.path').'/'.$name;

        $this->laravel['files']->copyDirectory(__DIR__.'/stubs/theme', $themePath);

        Stub::createFromPath(__DIR__.'/stubs/json.stub', compact('name'))
            ->saveTo($themePath, 'theme.json')
        ;

        Stub::createFromPath(__DIR__.'/stubs/theme.stub')
            ->saveTo($themePath, 'theme.php')
        ;

        $this->info('Theme created successfully.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the theme being created.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force creation if theme already exists.'],
        ];
    }
}

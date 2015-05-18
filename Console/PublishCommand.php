<?php

namespace Pingpong\Themes\Console;

use Illuminate\Console\Command;
use Pingpong\Themes\Theme;
use Symfony\Component\Console\Input\InputArgument;

class PublishCommand extends Command
{

    /**
     * Command name.
     *
     * @var string
     */
    protected $name = 'theme:publish';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Publish theme\'s assets';

    /**
     * Execute command.
     *
     * @return void
     */
    public function fire()
    {
        if ($theme = $this->argument('name')) {
            $this->publish($theme);
        }

        $this->publishAll();
    }

    protected function publishAll()
    {
        foreach ($this->laravel['themes']->all() as $theme) {
            $this->publish($theme);
        }
    }

    protected function publish($theme)
    {
        $theme = $theme instanceof Theme ? $theme : $this->laravel['themes']->find($theme);

        if (! is_null($theme)) {
            $assetsPath = $theme->getPath('assets');

            $destinationPath = public_path('themes/'.$theme->getLowerName());
            
            $this->laravel['files']->copyDirectory($assetsPath, $destinationPath);
            
            $this->line("Asset published from: <info>{$theme->getName()}</info>");
        }
    }

    public function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the theme being used.'],
        ];
    }
}

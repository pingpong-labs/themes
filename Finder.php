<?php namespace Pingpong\Themes;

use Illuminate\Filesystem\Filesystem;

class Finder {

    protected $filename = 'theme.json';

    protected $path;

    public function __construct($path, Filesystem $finder = null)
    {
        $this->path = $path;
    
        $this->finder = $finder ?: new Filesystem;
    }

    public function find()
    {
        $found = $this->finder->in($path)->files()->name($this->filename)->depth('<= 3')->followLinks();

        $themes = [];

        foreach ($found as $file)
        {
            $themes[] = $file;
        }

        return $themes;
    }
    
}
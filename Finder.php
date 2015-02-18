<?php namespace Pingpong\Themes;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder as SymfonyFinder;

class Finder {

    protected $filename = 'theme.json';

    protected $path;

    public function __construct($path, SymfonyFinderSymfonyFinder $finder = null)
    {
        $this->path = $path;
    
        $this->finder = $finder ?: new SymfonyFinder;
    }

    public function find()
    {
        $themes = [];
        
        if(is_dir($path = $this->path))
        {       
            $found = $this->finder->in($this->path)->files()->name($this->filename)->depth('<= 3')->followLinks();

            foreach ($found as $file)
            {
                $themes[] = $file;
            }
        }

        return $themes;
    }
    
}
<?php namespace Pingpong\Themes;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder as SymfonyFinder;

class Finder {

    /**
     * The symfony finder instance.
     * 
     * @var SymfonyFinder
     */
    protected $finder;

    /**
     * The constructor.
     * 
     * @param $finder SymfonyFinder
     */
    public function __construct(SymfonyFinder $finder = null)
    {    
        $this->finder = $finder ?: new SymfonyFinder;
    }

    /**
     * Find the specified theme by searching a 'theme.json' file as identifier.
     * 
     * @param  string $path
     * @param  string $filename
     * @return array
     */
    public function find($path, $filename = 'theme.json')
    {
        $themes = [];
        
        if(is_dir($path))
        {       
            $found = $this->finder->in($path)->files()->name($filename)->depth('<= 3')->followLinks();

            foreach ($found as $file) $themes[] = $file;
        }

        return $themes;
    }
    
}
<?php

namespace Pingpong\Themes;

use Pingpong\Support\Json;
use Symfony\Component\Finder\Finder as SymfonyFinder;

class Finder
{
    /**
     * The symfony finder instance.
     *
     * @var SymfonyFinder
     */
    protected $finder;

    /**
     * The array of themes.
     *
     * @var array
     */
    protected $themes = [];

    /**
     * Determinte whether the theme has been scanned or not.
     *
     * @var bool
     */
    protected $scanned = false;

    /**
     * The scanned path.
     *
     * @var string
     */
    protected $path;

    /**
     * The filename of theme's identifier.
     *
     * @var string
     */
    const FILENAME = 'theme.json';

    /**
     * The constructor.
     *
     * @param $finder SymfonyFinder
     */
    public function __construct(SymfonyFinder $finder = null)
    {
        $this->finder = $finder ?: new SymfonyFinder();
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Find the specified theme by searching a 'theme.json' file as identifier.
     *
     * @param string $path
     * @param string $filename
     *
     * @return $this
     */
    public function scan()
    {
        if ($this->scanned == true) {
            return $this;
        }

        if (is_dir($path = $this->getPath())) {
            $found = $this->finder
                ->in($path)
                ->files()
                ->name(self::FILENAME)
                ->depth('== 1')
                ->followLinks();

            foreach ($found as $file) {
                $this->themes[] = new Theme($this->getInfo($file));
            }
        }

        $this->scanned = true;

        return $this;
    }

    /**
     * Get themes.
     *
     * @return array
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Find in path.
     *
     * @param string $path
     *
     * @return array
     */
    public function find($path)
    {
        return $this->setPath($path)->scan()->getThemes();
    }

    /**
     * Get theme info from json file.
     *
     * @param SplFileInfo $file
     *
     * @return array
     */
    protected function getInfo($file)
    {
        $attributes = Json::make($path = $file->getRealPath())->toArray();

        $attributes['path'] = dirname($path);

        return $attributes;
    }
}

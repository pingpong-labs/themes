<?php namespace Pingpong\Themes;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

class Finder {

    /**
     * The Laravel Filesystem.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The Laravel Config Repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The current theme path.
     *
     * @var string
     */
    protected $path;

    /**
     * The constructor.
     *
     * @param Filesystem $files
     * @param Repository $config
     */
    public function __construct(Filesystem $files, Repository $config)
	{
        $this->files = $files;
        $this->config = $config;
    }

    /**
     * Get all themes.
     *
     * @return array
     */
    public function all()
    {
        $themes = array();

        if( ! $this->files->isDirectory($path = $this->getPath())) return $themes;

        $folders = $this->files->directories($path);

        foreach($folders as $theme)
        {
            $themes[] = basename($theme);
        }

        return $themes;
    }

    /**
     * Set theme path.
     *
     * @param $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        
        return $this;
    }

    /**
     * Get theme path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path ?: $this->config->get('themes::path');
    }

    /**
     * Check whether the given theme in all themes.
     *
     * @param $theme
     * @return bool
     */
    public function has($theme)
    {
        return in_array($theme, $this->all());
    }

    /**
     * Get theme path by given theme name.
     *
     * @param $theme
     * @return null|string
     */
    public function getThemePath($theme)
    {
        if( ! $this->has($theme)) return null;

        return $this->getPath() . "/{$theme}";
    }

    /**
     * Get The Laravel Filesystem.
     *
     * @return Filesystem
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Get The Laravel Config Repository.
     *
     * @return Repository
     */
    public function getConfig()
    {
        return $this->config;
    }
    
}
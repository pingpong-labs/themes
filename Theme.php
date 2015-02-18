<?php namespace Pingpong\Themes;

use Illuminate\View\Factory;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\Translator;

class Theme {

    /**
     * The Pingpong Themes Finder Object.
     *
     * @var Finder
     */
    protected $finder;

    /**
     * The Laravel Config Repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The Laravel Translator.
     *
     * @var Translator
     */
    protected $lang;

    /**
     * The Laravel View.
     *
     * @var Factory
     */
    protected $views;

    /**
     * The current theme active.
     *
     * @var string
     */
    protected $current;

    protected $path;

    protected $filename = 'theme.json';

    /**
     * The constructor.
     *
     * @param Finder $finder
     * @param Repository $config
     * @param Factory $views
     * @param Translator $lang
     * @internal param Factory $view
     */
    public function __construct(Finder $finder, Repository $config, Factory $views, Translator $lang)
    {
        $this->finder = $finder;
        $this->config = $config;
        $this->lang = $lang;
        $this->views = $views;
    }

    /**
     * Register the namespaces.
     */
    public function registerNamespaces()
    {
        foreach($this->all() as $theme)
        {
            foreach(array('views', 'lang') as $hint)
            {
                $this->{$hint}->addNamespace($theme, $this->getNamespacePath($theme, $hint));
            }
        }
    }

    /**
     * Get path for namespace.
     *
     * @param $theme
     * @param $type
     * @return string
     */
    protected function getNamespacePath($theme, $type)
    {
        return $this->getThemePath($theme) . "/{$type}";
    }

    /**
     * Get theme path by given theme name.
     *
     * @param $theme
     * @return null|string
     */
    public function getThemePath($theme)
    {
        return $this->finder->getThemePath($theme);
    }

    /**
     * Get current theme.
     *
     * @return string
     */
    public function getCurrent()
    {
        return $this->current ?: $this->config->get('themes.default');
    }

    /**
     * Set current theme.
     *
     * @param string $current
     * @return $this
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * The alias "setCurrent" method.
     *
     * @param $theme
     * @return $this
     */
    public function set($theme)
    {
        return $this->setCurrent($theme);
    }

    /**
     * Get all themes.
     *
     * @return array
     */
    public function all()
	{
		return $this->finder->find($this->path, $this->filename);
	}

    /**
     * Check whether the given theme in all themes.
     *
     * @param $theme
     * @return bool
     */
    public function has($theme)
    {
        return $this->finder->has($theme);
    }

    /**
     * Alias for "has" method.
     *
     * @param $theme
     * @return bool
     */
    public function exists($theme)
    {
        return $this->has($theme);
    }

    /**
     * Set theme path on runtime.
     *
     * @param $path
     * @return Finder
     */
    public function setPath($path)
    {
        return $this->finder->setPath($path);
    }

    /**
     * Get theme path.
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->finder->getPath();
    }

    /**
     * Get view from current theme.
     *
     * @param $view
     * @param array $data
     * @param array $mergeData
     * @return mixed
     */
    public function view($view, $data = array(), $mergeData = array())
    {
        return $this->views->make($this->getThemeNamespace($view), $data, $mergeData);
    }

    /**
     * Get config from current theme.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return $this->config->get($this->getThemeNamespace($key), $default);
    }

    /**
     * Get lang from current theme.
     *
     * @param $key
     * @param array $replace
     * @param null $locale
     * @return string
     */
    public function lang($key, $replace = array(), $locale = null)
    {
        return $this->lang->get($this->getThemeNamespace($key), $replace, $locale);
    }

    /**
     * Get theme namespace by given key.
     *
     * @param $key
     * @return string
     */
    protected function getThemeNamespace($key)
    {
        return $this->getCurrent() . "::{$key}";
    }
}
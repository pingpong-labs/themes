<?php

namespace Pingpong\Themes;

use Illuminate\Cache\Repository as Cache;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Illuminate\View\Factory;

class Repository implements Arrayable
{
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

    /**
     * The path of themes.
     *
     * @var
     */
    protected $path;

    /**
     * The constructor.
     *
     * @param Finder     $finder
     * @param Config     $config
     * @param Factory    $views
     * @param Translator $lang
     *
     * @internal param Factory $view
     */
    public function __construct(
        Finder $finder,
        Config $config,
        Factory $views,
        Translator $lang,
        Cache $cache
    ) {
        $this->finder = $finder;
        $this->config = $config;
        $this->lang = $lang;
        $this->views = $views;
        $this->cache = $cache;
    }

    /**
     * Register the namespaces.
     */
    public function registerNamespaces()
    {
        foreach ($this->all() as $theme) {
            foreach (array('views', 'lang') as $hint) {
                $this->{$hint}->addNamespace($theme->getLowerName(), $theme->getPath($hint));
            }

            $theme->boot();
        }
    }

    /**
     * Find the specified theme.
     *
     * @param string $search
     *
     * @return \Pingpong\Themes\Theme|null
     */
    public function find($search)
    {
        foreach ($this->all() as $theme) {
            if ($theme->getLowerName() == strtolower($search)) {
                return $theme;
            }
        }

        return;
    }

    /**
     * Get theme path by given theme name.
     *
     * @param $theme
     *
     * @return null|string
     */
    public function getThemePath($theme)
    {
        return $this->path."/{$theme}";
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
     *
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
     *
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
        if ($this->useCache()) {
            return $this->getCached();
        }

        return $this->scan();
    }

    /**
     * Get all themes.
     *
     * @return array
     */
    public function scan()
    {
        return $this->finder->find($this->getPath());
    }

    /**
     * Get cached themes.
     *
     * @return array
     */
    public function getCached()
    {
        $cached = $this->cache->get(
            $this->getCacheKey(),
            []
        );

        return $this->formatCache($cached);
    }

    /**
     * Determine whether the cache is enabled.
     *
     * @return bool
     */
    public function useCache()
    {
        return $this->getCacheStatus() == true;
    }

    /**
     * Get cache key.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return $this->config->get('themes.cache.key');
    }

    /**
     * Get cache lifetime.
     *
     * @return int
     */
    public function getCacheLifetime()
    {
        return $this->config->get('themes.cache.lifetime');
    }

    /**
     * Get cache status.
     *
     * @return bool
     */
    public function getCacheStatus()
    {
        return $this->config->get('themes.cache.enabled');
    }

    /**
     * Format for each cached theme to a Theme instance.
     *
     * @param array|string $cached
     *
     * @return array
     */
    protected function formatCache($cached)
    {
        $themes = is_array($cached) ? $cached : json_decode($cached, true);

        $results = [];

        foreach ($themes as $theme) {
            $results[] = new Theme($theme);
        }

        return $results;
    }

    /**
     * Cache the themes.
     */
    public function cache()
    {
        $this->cache->put(
            $this->getCacheKey(),
            $this->toJson(),
            $this->getCacheLifetime()
        );
    }

    /**
     * Forget cached themes.
     */
    public function forgetCache()
    {
        $this->cache->forget($this->getCacheKey());
    }

    /**
     * Convert all themes to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($theme) {
            return $theme->toArray();
        }, $this->scan());
    }

    /**
     * Convert all themes to a json string.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Check whether the given theme in all themes.
     *
     * @param $theme
     *
     * @return bool
     */
    public function has($theme)
    {
        return !is_null($this->find($theme));
    }

    /**
     * Alias for "has" method.
     *
     * @param $theme
     *
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
     *
     * @return Finder
     */
    public function setPath($path)
    {
        return $this->path = $path;
    }

    /**
     * Get theme path.
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path ?: $this->config->get('themes.path');
    }

    /**
     * Get view from current theme.
     *
     * @param $view
     * @param array $data
     * @param array $mergeData
     *
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
     *
     * @return mixed
     */
    public function config($key, $default = null)
    {
        if (Str::contains($key, '::')) {
            list($theme, $config) = explode('::', $key);
        } else {
            $theme = $this->getCurrent();
            $config = $key;
        }

        $theme = $this->find($theme);

        return $theme ? $theme->config($config) : $default;
    }

    /**
     * Get lang from current theme.
     *
     * @param $key
     * @param array $replace
     * @param null  $locale
     *
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
     *
     * @return string
     */
    protected function getThemeNamespace($key)
    {
        return $this->getCurrent()."::{$key}";
    }

    /**
     * Get theme namespace.
     *
     * @param string $key
     *
     * @return string
     */
    public function getNamespace($key)
    {
        return $this->getThemeNamespace($key);
    }

    /**
     * Register a view composer to current theme.
     *
     * @param string|array    $views
     * @param string|callable $callback
     * @param int|null        $priority
     */
    public function composer($views, $callback, $priority = null)
    {
        $theViews = [];

        foreach ((array) $views as $view) {
            $theViews[] = $this->getThemeNamespace($view);
        }

        $this->views->composer($theViews, $callback, $priority);
    }
}

<?php

namespace Pingpong\Themes;

use Illuminate\Contracts\Support\Arrayable;

class Theme implements Arrayable
{
    /**
     * Theme name.
     *
     * @var string
     */
    protected $name;

    /**
     * Theme description.
     *
     * @var string
     */
    protected $description;

    /**
     * Author information.
     *
     * @var array
     */
    protected $author = [];

    /**
     * Theme status. Enabled (true) or Disabled (false).
     *
     * @var bool
     */
    protected $enabled = true;

    /**
     * The theme path.
     *
     * @var string
     */
    protected $path;

    /**
     * Get the theme's files.
     *
     * @var array
     */
    protected $files = [];

    /**
     * Create new instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->setAttributes($attributes);
    }

    /**
     * Set attributes.
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Get theme path.
     *
     * @param string $hint
     *
     * @return string
     */
    public function getPath($hint = null)
    {
        if (!is_null($hint)) {
            return $this->path.'/'.$hint;
        }

        return $this->path;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get name as lowercase.
     *
     * @return string
     */
    public function getLowerName()
    {
        return strtolower($this->name);
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get author info.
     *
     * @return array
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Determine whether this theme is disabled.
     *
     * @return bool
     */
    public function disabled()
    {
        return !$this->enabled();
    }

    /**
     * Determine whether this theme is enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return $this->enabled == true;
    }

    /**
     * Determine whether the current theme is equal with this theme.
     *
     * @return bool
     */
    public function isActive()
    {
        return ThemeFacade::getCurrent() == $this->name;
    }

    /**
     * Get author info.
     *
     * @param string $type
     * @param null   $default
     *
     * @return string|null
     */
    public function getAuthorInfo($type, $default = null)
    {
        return array_get($this->author, $type, $default);
    }

    /**
     * Get author name.
     *
     * @param null $default
     *
     * @return string|null
     */
    public function getAuthorName($default = null)
    {
        return $this->getAuthorInfo('name', $default);
    }

    /**
     * Get author email.
     *
     * @param null $default
     *
     * @return string|null
     */
    public function getAuthorEmail($default = null)
    {
        return $this->getAuthorInfo('email', $default);
    }

    /**
     * Get info from this theme.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return $default;
    }

    /**
     * Get theme files.
     *
     * @return void
     */
    public function getFiles()
    {
        return $this->get('files', []);
    }

    /**
     * Boot the theme.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->getFiles() as $filename) {
            $path = $this->path . '/' . $filename;
            
            if (file_exists($path)) {
                require $path;
            };
        }
    }

    /**
     * Handle call to __get method.
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Handle call to __set method.
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        }
    }

    /**
     * Convert theme instance to array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'author' => $this->author,
            'enabled' => $this->enabled,
            'path' => $this->path,
            'files' => $this->files,
        ];
    }

    /**
     * Get theme's config value.
     *
     * @param  string $key
     * @param  string|null $default
     * @return string|null
     */
    public function config($key, $default = null)
    {
        $parts = explode('.', $key);

        $filename = head($parts);

        $parts = array_slice($parts, 0);

        $path = $this->path . "/config/config.php";

        if (! file_exists($path)) {
            $path = $this->path . "/config/{$filename}.php";
        }

        $key = implode('.', $parts);

        $config = file_exists($path) ? require $path : [];

        return array_get($config, $key, $default);
    }
}

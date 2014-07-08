<?php namespace Pingpong\Themes\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Theme
 * @package Pingpong\Themes\Facades
 */
class Theme extends Facade
{
    /**
     * Get Facade Accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
	{
		return 'pingpong.themes';
	}
}
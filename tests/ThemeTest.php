<?php

use Mockery as m;
use Pingpong\Themes\Theme;

class ThemeTest extends PHPUnit_Framework_TestCase
{
    function tearDown()
    {
        m::close();
    }

    protected function getPath()
    {
        return __DIR__ . '/../public/themes/';
    }

    function testInitialize()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $this->assertInstanceOf('Pingpong\Themes\Theme', $theme);
    }

    function testGetAllThemes()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $finder->shouldReceive('all')->once()->andReturn(['default']);

        $themes = $theme->all();

        $this->assertTrue(is_array($themes));
        $this->assertArrayHasKey(0, $themes);
        $this->assertArrayNotHasKey(1, $themes);
    }

    function testHasTheme()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $finder->shouldReceive('has')->once()->with('default')->andReturn(true);

        $hasTheme = $theme->has('default');

        $this->assertTrue($hasTheme);
    }

    function testGetCurrentThemeAndWillReturnFromConfig()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $config->shouldReceive('get')->once()->with('themes::default')->andReturn('default');

        $currentTheme = $theme->getCurrent();

        $this->assertEquals($currentTheme, 'default');
    }

    function testSetAndGetCurrentTheme()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $theme->setCurrent('white');

        $currentTheme = $theme->getCurrent();

        $this->assertEquals($currentTheme, 'white');
    }

    function testGetThemesPath()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $finder->shouldReceive('getPath')->once()->andReturn($this->getPath());

        $path = $theme->getPath();

        $this->assertEquals($path, $this->getPath());
    }

    function testThemePathForTheSpecifiedTheme()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $themePath = $this->getPath() . "/default";

        $finder->shouldReceive('getThemePath')->once()->with('default')->andReturn($themePath);

        $path = $theme->getThemePath('default');

        $this->assertEquals($path, $themePath);
    }

    function testSetAndGetThemesPath()
    {
        $finder = m::mock('Pingpong\Themes\Finder');
        $config = m::mock('Illuminate\Config\Repository');
        $view = m::mock('Illuminate\View\Factory');
        $lang = m::mock('Illuminate\Translation\Translator');

        $theme = new Theme($finder, $config, $view, $lang);

        $finder->shouldReceive('setPath')->once()->with($this->getPath())->andReturn($this->getPath());
        $finder->shouldReceive('getPath')->once()->andReturn($this->getPath());

        $theme->setPath($this->getPath());

        $this->assertEquals($theme->getPath(), $this->getPath());
    }
}
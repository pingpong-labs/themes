<?php

use Mockery as m;
use Pingpong\Themes\Finder;

class FinderTest extends PHPUnit_Framework_TestCase
{
    function tearDown()
    {
        m::close();
    }

    protected function getPath()
    {
        return __DIR__ . '/../public/themes/';
    }

    function testGetAllThemes()
    {
        $config = m::mock('Illuminate\Config\Repository');
        $files  = m::mock('Illuminate\Filesystem\Filesystem');

        $finder = new Finder($files, $config);

        $config->shouldReceive('get')->once()->andReturn($this->getPath());

        $files->shouldReceive('isDirectory')->once()->andReturn(true);        
        $files->shouldReceive('directories')->once()->andReturn(['themes']);

        $all = $finder->all();

        $this->assertTrue(is_array($all));
        $this->assertArrayHasKey(0, $all);
        $this->assertArrayNotHasKey(1, $all);
    }

    function testHasATheme()
    {
        $config = m::mock('Illuminate\Config\Repository');
        $files  = m::mock('Illuminate\Filesystem\Filesystem');

        $finder = new Finder($files, $config);
        $finder->setPath($this->getPath());

        $files->shouldReceive('isDirectory')->times(2)->andReturn(true);   
        $files->shouldReceive('directories')->times(2)->andReturn(['default']);

        $this->assertTrue($finder->has('default'));
        $this->assertNotTrue($finder->has('white'));
    }

    function testSetThemePath()
    {
        $config = m::mock('Illuminate\Config\Repository');
        $files  = m::mock('Illuminate\Filesystem\Filesystem');

        $finder = new Finder($files, $config);

        $theFinder = $finder->setPath($this->getPath());

        $this->assertInstanceOf('Pingpong\Themes\Finder', $theFinder);
        $this->assertInstanceOf('Pingpong\Themes\Finder', $finder);
    }

    function testGetThemePath()
    {
        $config = m::mock('Illuminate\Config\Repository');
        $files  = m::mock('Illuminate\Filesystem\Filesystem');

        $finder = new Finder($files, $config);

        $config->shouldReceive('get')->times(3)->andReturn($this->getPath());

        $files->shouldReceive('isDirectory')->times(2)->andReturn(true);
        $files->shouldReceive('directories')->times(2)->andReturn(['default']);

        $themePath1 = $finder->getThemePath('default');
        $themePath2 = $finder->getThemePath('white');

        $this->assertEquals($themePath1, $this->getPath() . "/default");
        $this->assertNull($themePath2);
    }
}
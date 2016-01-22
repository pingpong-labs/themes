<?php

use Pingpong\Themes\Finder;
use Pingpong\Themes\Repository;

class ThemeTest extends TestCase
{
    /**
     * @var Repository
     */
    private $repository;

    public function setUp()
    {
        if (! $this->app) {
            $this->refreshApplication();
        }

        $this->app['config']->set([
            'themes' => [
                'path' => __DIR__ . DIRECTORY_SEPARATOR . 'themes',
                'cache' => [
                    'enabled' => false,
                    'key' => 'pingpong.themes.for.testing',
                    'lifetime' => 1,
                ]
            ]
        ]);
    }

    public function test_get_all_theme()
    {
        $this->repository = $this->createRepository();
        $allThemes = $this->repository->all();

        $this->assertEquals(2, count($allThemes));
    }

    public function test_find_theme()
    {
        $this->repository = $this->createRepository();
        $test1 = $this->repository->find('theme1');

        $this->assertInstanceOf('Pingpong\Themes\Theme', $test1);
    }

    public function test_set_get_theme()
    {
        $this->repository = $this->createRepository();
        $this->repository->setCurrent('theme1');
        $current = $this->repository->getCurrent();

        $this->assertEquals('theme1', $current);
    }

    public function test_check_theme()
    {
        $this->repository = $this->createRepository();
        $result = $this->repository->has('theme1');

        $this->assertTrue($result);
    }

    public function test_get_theme_path()
    {
        $this->repository = $this->createRepository();
        $result = $this->repository->getThemePath('theme1');

        $expected = $this->app['config']->get('themes.path') . DIRECTORY_SEPARATOR . 'theme1';

        $this->assertEquals($expected, $result);
    }

    public function test_get_cached()
    {
        $this->repository = $this->createRepository();
        $result = $this->repository->getCached();

        $this->assertEmpty($result);
    }

    public function test_get_cached_if_cache_enabled()
    {
        $this->app->config->set(['themes.cache.enabled' => true]);

        $this->repository = $this->createRepository();
        $this->repository->all();

        $result = $this->repository->getCached();

        $this->repository->forgetCache();

        $this->app->config->set(['themes.cache.enabled' => false]);

        $this->assertEquals(2, count($result));
    }

    public function test_to_array()
    {
        $this->repository = $this->createRepository();

        $expected = [
            'theme1',
            'theme2'
        ];

        $this->assertSame($expected, array_column($this->repository->toArray(), 'name'));
    }

    public function test_to_json()
    {
        $this->repository = $this->createRepository();

        $expected = [
            'theme1',
            'theme2'
        ];

        $result = $this->repository->toJson();

        $this->assertSame($expected, array_column(json_decode($result, true), 'name'));
    }

    private function createRepository()
    {
        return new Repository(
            new Finder(),
            $this->app['config'],
            $this->app['view'],
            $this->app['translator'],
            $this->app['cache.store']
        );
    }
}
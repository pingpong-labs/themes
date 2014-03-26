<?php namespace Pingpong\Theme\Command;

use Theme;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThemeMakeCommand extends Command {

	protected $folders = [
		'assets/',
		'assets/css/',
		'assets/js/',
		'config/',
		'lang/',
		'lang/en/',
		'start/',
		'views/',
	];

	protected $files = [
		'theme.json',
		'config/theme.php',
		'lang/en/theme.php',
		'start/global.php',
		'start/helpers.php',
		'views/index.blade.php',
		'views/template.blade.php',
	];

	protected $stubs = [
		'json.stub',
		'config.stub',
		'lang.stub',
		'global.stub',
		'helpers.stub',
		'views/index.stub',
		'views/template.stub',
	];

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'theme:make';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a new theme.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->name = strtolower($this->argument('name'));
		if(Theme::has($this->name))	
		{
			return $this->error("Theme [$this->name] already exists.");
		}
		return $this->generate($this->name);
	}

	/**
	 * Generate new theme.
	 *
	 * @return array
	 */
	protected function generate()
	{
		$this->generateFolders();
		$this->generateFiles();
		$this->info("Theme [$this->name] has been created.");
	}

	/**
	 * Generate theme folders.
	 *
	 * @return array
	 */
	protected function generateFolders()
	{
		$path = Theme::getPath();
		foreach ($this->folders as $folder) {
			$folderPath = $path . $this->name . '/' . $folder;
			@mkdir($folderPath, 0755, true);
		}
	}

	/**
	 * Generate theme files.
	 *
	 * @return void
	 */
	protected function generateFiles()
	{		
		$path = Theme::getPath();
		foreach ($this->files as $key => $file) {
			$filename = $path . $this->name . '/' . $file;
			$this->makeFile($key, $filename);
			$this->info("Created: ".$filename);
		}
	}

	/**
	 * Create new file.
	 *
	 * @param  string  $key
	 * @param  string  $filename
	 * @return void
	 */
	protected function makeFile($key, $filename)
	{
		$content = $this->getStub($key);
		$content = str_replace('{{name}}', $this->name, $content);
		@file_put_contents($filename, $content);
	}

	/**
	 * Get stub template.
	 *
	 * @param  integer  $key
	 * @return string
	 */
	protected function getStub($key)
	{
		return file_get_contents(__DIR__.'/stubs/'.$this->stubs[$key]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'Theme name.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}

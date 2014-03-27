<?php namespace Pingpong\Theme\Command;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThemePublishCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'theme:publish';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publish default themes to destination folder. Destination default is public directory.';

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
		$path = __DIR__.'/../../../public/';
		$dest = $this->option('path') ? $this->option('path') : public_path();
		$file = new File;
		
		if($file->copyDirectory($path, $dest))
		{
			return $this->info('Themes has been published.');
		}
		return $this->error('Can not publish themes. Is ' . $dest . ' path directory writable?');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('path', null, InputOption::VALUE_OPTIONAL, 'Destination path.', null),
		);
	}

}

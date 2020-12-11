<?php declare(strict_types=1);
namespace Open\Cli;

use Symfony\Component\Console\Input\{InputArgument, InputInterface, InputOption};
use Symfony\Component\Console\Output\OutputInterface;
use function Open\open;

/** The console command. */
class Command extends \Symfony\Component\Console\Command\Command {

	/** @var string The command name. */
	protected static $defaultName = "open";

	/** Configures the current command. */
	protected function configure(): void {
		$this
			->setDescription("Open whatever you want, such as URLs, files or executables, regardless of the platform you use.")
			->addArgument("target", InputArgument::REQUIRED, "The target to open")
			->addArgument("arguments", InputArgument::OPTIONAL | InputArgument::IS_ARRAY, "The arguments of the application to open the target with")
			->addOption("application", "a", InputOption::VALUE_REQUIRED, "The application to open the target with")
			->addOption("background", "b", InputOption::VALUE_NONE, "Do not bring the application to the foreground (macOS only)")
			->addOption("wait", "w", InputOption::VALUE_NONE, "Wait for the opened application to exit");
	}

	/**
	 * Executes the current command.
	 * @param $input The input arguments and options.
	 * @param $output The console output.
	 * @return The exit code.
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		/** @var string $target */
		$target = $input->getArgument("target");
		open($target, [
			"application" => $input->getOption("application") ?? "",
			"arguments" => $input->getArgument("arguments"),
			"background" => $input->getOption("background"),
			"wait" => $input->getOption("wait")
		]);

		return 0;
	}
}

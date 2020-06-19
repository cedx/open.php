<?php declare(strict_types=1);
namespace Open;

use Symfony\Component\Process\Process;

/**
 * Opens the specified target.
 * @param string $target The target to open.
 * @param array<string, mixed> $options The options to apply.
 * @return Process The spawned child process.
 */
function open(string $target, array $options = []): Process {
	assert(mb_strlen($target) > 0);

	$application = $options["application"] ?? "";
	$arguments = $options["arguments"] ?? [];
	$background = $options["background"] ?? false;
	$wait = $options["wait"] ?? false;

	$command = [];
	$isWsl = Wsl::isWsl();
	$isWindows = PHP_OS_FAMILY == "Windows" || $isWsl;
	$outputDisabled = false;

	if (PHP_OS_FAMILY == "Darwin") {
		$command[] = "open";
		if ($wait) $command[] = "--wait-apps";
		if ($background) $command[] = "--background";
		if ($application) array_push($command, "-a", $application);
		$command[] = $target;
		if ($arguments) array_push($command, "--args", ...$arguments);
	}
	else if ($isWindows) {
		$command[] = "cmd.exe";
		array_push($command, "/c", "start", '""', "/b");
		if ($wait) $command[] = "/wait";
		if ($application) $command[] = escapeshellarg($isWsl && mb_substr($application, 0, 5) == "/mnt/" ? Wsl::resolvePath($application) : $application);
		if ($arguments) array_push($command, ...array_map("escapeshellarg", $arguments));
		$command[] = str_replace("&", "^&", escapeshellarg($target));
	}
	else {
		$localXdgOpen = new \SplFileInfo(__DIR__."/../bin/xdg-open");
		$command[] = $application ?: ($localXdgOpen->isExecutable() ? $localXdgOpen->getRealPath() : "xdg-open");
		if ($arguments) array_push($command, ...$arguments);
		if (!$wait) $outputDisabled = true;
		$command[] = $target;
	}

	$process = $isWindows ? Process::fromShellCommandline(implode(" ", $command)) : new Process($command);
	if ($outputDisabled) $process->disableOutput();
	$process->setTimeout(null);

	if ($wait) $process->mustRun();
	else $process->run();
	return $process;
}

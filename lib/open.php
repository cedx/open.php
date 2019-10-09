<?php declare(strict_types=1);
namespace Open;

use Symfony\Component\Process\{Process};
use Symfony\Component\Process\Exception\{ProcessFailedException};

/**
 * Opens the specified target.
 * @param string $target The target to open.
 * @param array $options The options to apply.
 * @return Process The spawned child process.
 * @throws ProcessFailedException If the process didn't terminate successfully.
 */
function open(string $target, array $options = []): Process {
  $application = $options['application'] ?? '';
  $arguments = $options['arguments'] ?? [];
  $background = $options['background'] ?? false;
  $wait = $options['wait'] ?? false;

  $command = [];
  $isWsl = Wsl::isWsl();
  $isWindows = PHP_OS_FAMILY == 'Windows' || $isWsl;
  $outputDisabled = false;

  if (PHP_OS_FAMILY == 'Darwin') {
    $command[] = 'open';
    if ($wait) $command[] = '--wait-apps';
    if ($background) $command[] = '--background';
    if ($application) array_push($command, '-a', $application);
    $command[] = $target;
    if ($arguments) array_push($command, '--args', ...$arguments);
  }
  else if ($isWindows) {
    $command[] = 'cmd.exe';
    array_push($command, '/c', 'start', '', '/b');
    if ($wait) $command[] = '/wait';
    if ($application) $command[] = $isWsl && mb_substr($application, 0, 5) == '/mnt/' ? Wsl::resolvePath($application) : $application;
    if ($arguments) array_push($command, ...$arguments);
    $command[] = str_replace('&', '^&', $target);
  }
  else {
    $command[] = $application ?: 'xdg-open';
    if ($arguments) array_push($command, ...$arguments);
    if (!$wait) $outputDisabled = true;
    $command[] = $target;
  }

  $process = $isWindows ? Process::fromShellCommandline('TODO' /* TODO */) : new Process($command);
  if ($outputDisabled) $process->disableOutput();
  $process->setTimeout(null);
  $process->start();
  if ($wait) {
    $exitCode = $process->wait();
    if ($exitCode > 0) throw new ProcessFailedException($process);
  }

  return $process;
}

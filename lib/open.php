<?php declare(strict_types=1);
namespace Open;

use Symfony\Component\Process\{Process};
use Symfony\Component\Process\Exception\{ProcessFailedException};

/**
 * Opens the specified target.
 * @param string $target The target to open.
 * @param bool $wait Value indicating whether to wait for the opened application to exit.
 * @param array $options The options to apply.
 * @return Process The spawned child process.
 * @throws ProcessFailedException If the process didn't terminate successfully.
 */
function open(string $target, bool $wait = false, array $options = []): Process {
  $command = [];
  $isWsl = PHP_OS_FAMILY == 'Linux' && WindowsSubsystemForLinux::isWsl();
  $outputDisabled = false;

  if (PHP_OS_FAMILY == 'Darwin') {
    $command[] = 'open';
    if ($wait) $command[] = '--wait-apps';
    if ($options['background'] ?? false) $command[] = '--background';
    if ($application = $options['application'] ?? '') {
      $command[] = '-a';
      $command[] = $application;
    }

    $command[] = $target;
    if ($arguments = $options['arguments'] ?? []) {
      $command[] = '--args';
      $command = array_merge($command, $arguments);
    }
  }
  else if (PHP_OS_FAMILY == 'Windows' || $isWsl) {
    $command[] = $isWsl ? 'cmd.exe' : 'cmd';
    $command = array_merge($command, ['/c', 'start', '""', '/b']);
    if ($wait) $command[] = '/wait';
    if ($application = $options['application'] ?? '')
      $command[] = $isWsl && mb_substr($application, 0, 5) == '/mnt/' ? WindowsSubsystemForLinux::resolveWslPath($application) : $application;

    if ($arguments = $options['arguments'] ?? []) $command = array_merge($command, $arguments);
    $command[] = str_replace('&', '^&', $target);
  }
  else {
    $command[] = $options['application'] ?? 'xdg-open';
    if ($arguments = $options['arguments'] ?? []) $command = array_merge($command, $arguments);
    if (!$wait) $outputDisabled = true;
    $command[] = $target;
  }

  $process = new Process($command);
  if ($outputDisabled) $process->disableOutput();
  $process->setTimeout(null);
  $process->start();
  if ($wait) {
    $exitCode = $process->wait();
    if ($exitCode > 0) throw new ProcessFailedException($process);
  }

  return $process;
}

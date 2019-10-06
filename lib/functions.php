<?php declare(strict_types=1);
namespace Open;

/**
 * Gets a value indicating whether the process is running inside Windows Subsystem for Linux.
 * @return bool `true` if the process is running inside Windows Subsystem for Linux, otherwise `false`.
 */
function isWindowsSubsystemForLinux(): bool {
  if (PHP_OS_FAMILY != 'Linux') return false;
  if (mb_stripos(php_uname(), 'microsoft')) return true;
  return (bool) mb_stripos((string) @file_get_contents('/proc/version'), 'microsoft');
}

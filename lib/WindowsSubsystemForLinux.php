<?php declare(strict_types=1);
namespace Open;

/** Provides helper methods for the Windows Subsystem for Linux. */
abstract class WindowsSubsystemForLinux {

  /**
   * Gets a value indicating whether the process is running inside Windows Subsystem for Linux.
   * @return bool `true` if the process is running inside Windows Subsystem for Linux, otherwise `false`.
   */
  static function isWsl(): bool {
    if (PHP_OS_FAMILY != 'Linux') return false;
    if (mb_stripos(php_uname(), 'microsoft')) return true;
    return (bool) mb_stripos((string) @file_get_contents('/proc/version'), 'microsoft');
  }

  /**
   * Resolves the specified WSL path to a Windows path.
   * @param string $path A WSL path.
   * @return string The Windows path corresponding to the specified WSL path.
   */
  static function resolveWslPath(string $path): string {
    $escapedPath = escapeshellarg($path);
    return trim(`wsl -w $escapedPath`);
  }
}

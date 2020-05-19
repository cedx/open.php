<?php declare(strict_types=1);
namespace Open;

/** Provides helper methods for the Windows Subsystem for Linux. */
abstract class Wsl {

	/**
	 * Gets a value indicating whether the process is running inside Windows Subsystem for Linux.
	 * @return bool `true` if the process is running inside Windows Subsystem for Linux, otherwise `false`.
	 */
	static function isWsl(): bool {
		if (PHP_OS_FAMILY != "Linux") return false;
		if (mb_stripos(php_uname(), "microsoft")) return true;

		$procFile = new \SplFileObject("/proc/version");
		return (bool) mb_stripos((string) $procFile->fread($procFile->getSize()), "microsoft");
	}

	/**
	 * Resolves the specified WSL path to a Windows path.
	 * @param string $path A WSL path.
	 * @return string The Windows path corresponding to the specified WSL path.
	 */
	static function resolvePath(string $path): string {
		assert(mb_strlen($path) > 0);
		$escapedPath = escapeshellarg($path);
		return trim(`wslpath -w $escapedPath`);
	}
}

<?php declare(strict_types=1);

/** @var string The usage information. */
return $usage = <<<'EOT'
Open whatever you want, such as URLs, files or executables, regardless of the platform you use.

Usage: open_cli [options] <application|file|url> [-- <arguments>]

Options:
-b, --background    Do not bring the application to the foreground (macOS).
-h, --help          Output usage information.
-v, --version       Output the version number.
-w, --wait          Wait for the opened application to exit.
EOT;

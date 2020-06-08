---
path: src/branch/main
source: bin/open_cli
---

# Command line interface
From a command prompt, install the `open_cli` executable:

``` shell
composer global require cedx/open
```

!!! tip
	Consider adding the [`composer global`](https://getcomposer.org/doc/03-cli.md#global) executables directory to your system path.

Then use it to open a document or URL:

``` shell
$ open_cli --help

Description:
	Open whatever you want, such as URLs, files or executables, regardless of the platform you use.

Usage:
	open [options] [--] <target> [<arguments>...]

Arguments:
	target                         The target to open
	arguments                      The arguments of the application to open the target with

Options:
	-a, --application=APPLICATION  The application to open the target with
	-b, --background               Do not bring the application to the foreground (macOS only)
	-w, --wait                     Wait for the opened application to exit
	-h, --help                     Display this help message
	-q, --quiet                    Do not output any message
	-V, --version                  Display this application version
			--ansi                     Force ANSI output
			--no-ansi                  Disable ANSI output
	-n, --no-interaction           Do not ask any interactive question
	-v|vv|vvv, --verbose           Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

For example:

``` shell
# Open a URL in the default browser.
open_cli https://belin.io

# Open a URL in the given browser.
open_cli --application=firefox https://belin.io

# Open a URL in the given browser, using the specified arguments.
open_cli --application=chrome https://belin.io -- --incognito

# Open an image in the default viewer and wait for the opened application to quit.
open_cli --wait funny.gif
```

path: blob/master
source: bin/open_cli

# Command line interface
From a command prompt, install the `open_cli` executable:

```shell
composer global require cedx/open
```

!!! tip
    Consider adding the [`composer global`](https://getcomposer.org/doc/03-cli.md#global) executables directory to your system path.

Then use it to open a document or URL:

```shell
$ open_cli --help

Open whatever you want, such as URLs, files or executables, regardless of the platform you use.

Usage: open_cli [options] <target> [-- <arguments>]

Options:
-a, --application    The application to open the target with.
-b, --background     Do not bring the application to the foreground (macOS).
-h, --help           Output usage information.
-v, --version        Output the version number.
-w, --wait           Wait for the opened application to exit.
```

For example:

```shell
# Open a URL in the default browser.
open_cli https://belin.io

# Open a URL in the given browser.
open_cli --application=firefox https://belin.io

# Open a URL in the given browser, using the specified arguments.
open_cli --application=chrome https://belin.io -- --incognito

# Open an image in the default viewer and wait for the opened application to quit.
open_cli --wait funny.gif
```

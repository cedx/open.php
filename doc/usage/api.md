---
path: src/branch/master
source: src/open.php
---

# Application programming interface
This package provides a single function, `Open\open()`, allowing to open a document or URL:

```php
<?php
use function Open\{open};

function main(): void {
  // Open a URL in the default browser.
  open('https://belin.io');

  // Open a URL in the given browser.
  open('https://belin.io', ['application' => 'firefox']);

  // Open a URL in the given browser, using the specified arguments.
  open('https://belin.io', [
    'application' => 'chrome',
    'arguments' => ['--incognito']
  ]);

  // Open an image in the default viewer
  // and wait for the opened application to quit.
  open('funny.gif', ['wait' => true]);
}
```

The function returns the spawned child process, an instance of the [`\Symfony\Component\Process\Process` class](https://symfony.com/doc/current/components/process.html).  
You would normally not need to use this for anything, but it can be useful if you'd like to perform operations directly on the spawned process.

!!! info
    The function uses the command `start` on Windows, `open` on macOS
    and `xdg-open` on other platforms.

## Options
The behavior of the `Open\open()` function can be customized using the following options.

### string **application**
Specify the application to open the target with.

The application name is platform dependent. For example, Goole Chrome is `chrome` on Windows, `google-chrome` on Linux and `google chrome` on macOS.

You may also pass in the application's full path. For example on Windows Subsystem for Linux, this can be `"/mnt/c/Program Files (x86)/Google/Chrome/Application/chrome.exe"`.

```php
<?php
open('https://belin.io', ['application' => 'firefox']);
```

### array **arguments**
Specify the arguments to pass when using a custom `application` option.

```php
<?php
open('https://belin.io', ['application' => 'chrome', 'arguments' => ['--incognito']]);
```

### bool **background**
Do not bring the application to the foreground (macOS only).

```php
<?php
open('spreadsheet.xlsx', ['background' => true]);
```

### bool **wait**
Wait for the opened application to exit before proceeding to the next statement. If `false`, immediately goes to the next statement after opening the application.

```php
<?php
open('funny.gif', ['wait' => true]);
```

!!! tip
    On Windows, you have to explicitly specify the `application` option for it to be able to wait.

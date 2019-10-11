<?php declare(strict_types=1);
use function Open\{open};

/** Demonstrates the usage of the `open()` function. */
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

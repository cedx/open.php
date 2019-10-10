path: blob/master
source: lib/open.php

# Application programming interface
Use the `Open\open` function to a document or URL:

```php
<?php
use function Open\{open};

function main(): void {
  open('https://belin.io');
}
```

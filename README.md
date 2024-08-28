# cxml-php
![Contributors](https://img.shields.io/github/contributors-anon/cloudonix/cxml-php)
[![Packagist](https://img.shields.io/packagist/v/cloudonix/cxml-php)](https://packagist.org/packages/cloudonix/cxml-php)

## Documentation

The documentation for the Cloudonix CXML markup language can be found [here](https://developers.cloudonix.com/cxml).

The PHP library documentation can be found [here](https://developers.cloudonix.com/libraries/cxml-php)

## Supported PHP Versions

This library supports the following PHP versions:
- PHP 8.0
- PHP 8.1
- PHP 8.2
- PHP 8.3

## Installation

You can install `cxml-php` via [composer](https://getcomposer.org/) or by downloading the source.

```shell
composer require cloudonix/cxml-php
```

### Test your installation
Here is a sample PHP script that will generate a CXML Voice Application document, using the library:

```php
<?php

require(__DIR__ . "/vendor/autoload.php");

use Cloudonix\CXML\Response;

$responder = new Response();
$responder->dial("12127773456");
$responder->redirect("https://example.com/script.php");

$responder->gather([
    (new Response())->play("https://example.com/playfile.mp3")->attributes(["loop" => 3]),
    (new Response())->pause()->attributes(["length" => 5]),
])->attributes(["action" => "https://example.com/script.php"]);

$responder->hangup();

echo $responder;
```

Copy&Paste the above script to a new file, and execute it from the command line, the following should be the result:

```shell
$ php cxmlResponder.php 
<Response>
  <DIAL>12127773456</DIAL>
  <REDIRECT>https://example.com/script.php</REDIRECT>
  <GATHER action="https://example.com/script.php">
    <PLAY loop="3">https://example.com/playfile.mp3</PLAY>
    <PAUSE length="5" />
  </GATHER>
  <HANGUP />
</Response>
```
## Usage

### Create a CXML Document Response with a `<PLAY>` and `<HANGUP>`
```php
<?php

require(__DIR__ . "/vendor/autoload.php");

use Cloudonix\CXML\Response;

$responder = new Response();
$responder
    ->play("https://example.com/playfile.mp3")
    ->attributes([
        "loop" => 3,
        "statusCallback" => "https://example.com/statusCallback"
    ]);
$responder->hangup();

echo $responder;
```

Expected result:
```xml
<Response>
  <PLAY loop="3" statusCallback="https://example.com/statusCallback">https://example.com/playfile.mp3</PLAY>
  <HANGUP />
</Response>
```

### Create a CXML Document Response with a `<GATHER>`, `<PLAY>`, `<PAUSE>` and `<HANGUP>`
```php
<?php

require(__DIR__ . "/vendor/autoload.php");

use Cloudonix\CXML\Response;

$responder = new Response();
$responder->gather([
    (new Response())->play("https://example.com/playfile.mp3")->attributes(["loop" => 3]),
    (new Response())->pause()->attributes(["length" => 5]),
])->attributes(["action" => "https://example.com/script.php"]);
$responder->hangup();

echo $responder;
```

Expected result:
```xml
<Response>
  <GATHER action="https://example.com/script.php">
    <PLAY loop="3">https://example.com/playfile.mp3</PLAY>
    <PAUSE length="5" />
  </GATHER>
  <HANGUP />
</Response>
```

## Getting help

If you need help installing or using the library, please check the [Cloudonix Developers Website](https://developers.cloudonix.com) first.

If you've instead found a bug in the library or would like new features added, go ahead and open issues or pull requests against this repo!

[CXML]: https://developers.cloudonix.com/cxml
[libdocs]: https://developers.cloudonix.com/libraries/cxml-php
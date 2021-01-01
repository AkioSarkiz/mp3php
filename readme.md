# MP3 PHP

[![Build Status](https://travis-ci.org/AkioSarkiz/php-mp3.svg?branch=master)](https://travis-ci.org/AkioSarkiz/php-mp3)

Package for manipulation mp3 files in php. 

### Requires  

- Php >= 7.4
- FFmpeg
- Support platform: linux

### Example 
```php
use AkioSarkiz\Mp3Php\Mp3;

// create object
$mp3item = new Mp3('source.mp3');

// check is valid
$mp3item->isValid();

// get duration of mp3
$mp3item->getDuration();

// add meta
$mp3item->addMeta([
    'album' => 'custom album',
], 'source_with_meta.mp3');

// clear meta
$mp3item->clearMeta('source_clear.mp3');

// get all info
$mp3item->getInfo();

// get path
$mp3item->getPath();

// get size mp3
$mp3item->size();

// get kbs of mp3
$mp3item->getKbs();

// convert mp3 to your kbs
$mp3item->convert('source_64.mp3', 64);
```

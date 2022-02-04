# Local File System

![PHP Composer](https://github.com/ArtARTs36/php-local-file-system/workflows/PHP%20Composer/badge.svg?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
<a href="https://poser.pugx.org/artarts36/local-file-systemr/d/total.svg">
<img src="https://poser.pugx.org/artarts36/local-file-system/d/total.svg" alt="Total Downloads">
</a>

This package provides implementation of [FileSystem Contracts](https://github.com/ArtARTs36/php-file-system-contracts) for Local FileSystem.

## Installation

Run command: `composer require artarts36/local-file-system`

## Usage

```php
use ArtARTs36\FileSystem\Local\LocalFileSystem;

$fs = new LocalFileSystem();

$fs->removeDir('/etc/');
````

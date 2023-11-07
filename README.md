# Boatrace Ninja Converter

[![Latest Stable Version](https://poser.pugx.org/boatrace-ninja/converter/v/stable)](https://packagist.org/packages/boatrace-ninja/converter)
[![Latest Unstable Version](https://poser.pugx.org/boatrace-ninja/converter/v/unstable)](https://packagist.org/packages/boatrace-ninja/converter)
[![License](https://poser.pugx.org/boatrace-ninja/converter/license)](https://packagist.org/packages/boatrace-ninja/converter)

## Installation
```
$ composer require boatrace-ninja/converter
```

## Usage
```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Boatrace\Ninja\Converter;

var_dump(Converter::convertToTechniqueId('逃げ')); // int(1)
var_dump(Converter::convertToTechniqueId('差し')); // int(2)
var_dump(Converter::convertToTechniqueId('まくり')); // int(3)
var_dump(Converter::convertToTechniqueId('まくり差し')); // int(4)
var_dump(Converter::convertToTechniqueId('抜き')); // int(5)
var_dump(Converter::convertToTechniqueId('恵まれ')); // int(6)

var_dump(Converter::convertToTechniqueName(1)); // string(6) "逃げ"
var_dump(Converter::convertToTechniqueName(2)); // string(6) "差し"
var_dump(Converter::convertToTechniqueName(3)); // string(9) "まくり"
var_dump(Converter::convertToTechniqueName(4)); // string(15) "まくり差し"
var_dump(Converter::convertToTechniqueName(5)); // string(6) "抜き"
var_dump(Converter::convertToTechniqueName(6)); // string(9) "恵まれ"
```

## License
The Boatrace Ninja Converter is open source software licensed under the [MIT license](LICENSE).

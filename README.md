# maguttiSpatialBuilder V2
Laravel Builder Mysql Spatial Extension

[![Latest Version on Packagist](https://img.shields.io/packagist/v/magutti/magutti-spatial.svg?style=flat-square)](https://packagist.org/packages/magutti/magutti-spatial)
[![Total Downloads](https://img.shields.io/packagist/dt/magutti/magutti-spatial.svg?style=flat-square)](https://packagist.org/packages/magutti/magutti-spatial)


Laravel Builder extensions to calculate distances between two Spatial points with Mysql.

MaguttiSpatialBuilder by default use meter as unit.
## Installation

You can install the package via composer:

```bash
composer require magutti/magutti-spatial
```

## Usage
Add in your  Model
```php
use Magutti\MaguttiSpatial\Builders\SpatialBuilder;

class Location extends Model
{
    .......
    protected $spatialFields = [
        'lng',
        'lat'
    ];
   
    function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }
    .......
}
```

## Example of usage
Get all points where the distance from a given position are less than 1Km
```php
Location::select(['id','lat','lng'])
           ->whitDistance([9.5970498, 45.693161])
           ->whereDistance([9.5970498, 45.693161],1000)
           ->get()
```
where 9.5970498, 45.693161 is your position and 1000 is the max distance in meters.


or if you want uses miles
```php
Location::select(['id','lat','lng'])
           ->whitDistanceInMiles([9.5970498, 45.693161])
           ->whereDistance([9.5970498, 45.693161],10,'mi')
           ->get()
``` 

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email marco@magutti.com instead of using the issue tracker.

## Credits

-   [marcoax](https://github.com/magutti)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.



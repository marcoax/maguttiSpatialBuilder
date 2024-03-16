# magutti-spatial V4
Laravel Builder Mysql Spatial Extension

[![Latest Stable Version](http://poser.pugx.org/magutti/magutti-spatial/v)](https://packagist.org/packages/magutti/magutti-spatial)
[![Total Downloads](http://poser.pugx.org/magutti/magutti-spatial/downloads)](https://packagist.org/packages/magutti/magutti-spatial)
[![License](http://poser.pugx.org/magutti/magutti-spatial/license)](https://packagist.org/packages/magutti/magutti-spatial)
[![PHP Version Require](http://poser.pugx.org/magutti/magutti-spatial/require/php)](https://packagist.org/packages/magutti/magutti-spatial)

Laravel Builder extensions to calculate distances between two Spatial points  using Mysql native function `ST_Distance_Sphere`.

`ST_Distance_Sphere` default unit to find distance is meters.

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
    // you can override the default longitude and latitude fields
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

### Example of usage
Get all points where the distance from a given position are less than 1Km
```php
Location::select(['id','lng','lat'])
           ->whitDistance([8.9246844, 45.4152695]) // return distance in meters (default)
           ->whereDistance([8.9246844, 45.4152695],1000)
           ->get()
```
where **8.9246844** (longitude), **45.4152695** (latitude) is your position and **1000** is the max distance in meters.

 

``` sql
SELECT `id`,
       `lng`,
       `lat`,
       St_distance_sphere(Point(8.9246844, 45.4152695), Point(lng, lat)) * 1 AS
       distance
FROM   `locations`
WHERE  St_distance_sphere(Point(8.9246844, 45.4152695), Point(lng, lat)) < 1000 
```

Using Miles
```php
Location::select(['id','lat','lng'])
           ->whitDistanceInMiles([8.9246844, 45.4152695]) // return distance in Miles
           ->whereDistance([8.9246844, 45.4152695],10,'mi')
           ->get()
``` 

Find the closest point to you  in Km 
```php
Location::select(['id','lat','lng'])
           ->whitDistanceInKm([8.9246844, 45.4152695]) 
           ->whereDistance([8.9246844, 45.4152695],10,'km')
           ->closest()
``` 


## Helpers
The package provide some pre-built methods to calculate distance in Km, Miles or Feet.
```php

whitDistanceInKm(array $point)    -> return distance in Km;
whitDistanceInMiles(array $point) -> return distance in Miles (mi);
whitDistanceInFeet(array $point)  -> return distance in Feet (ft);

and for filtering by distance

whereDistanceInKm(array $point, float $distance)     -> filter point by a given distance in Km
whereDistanceInMiles(array $point, float $distance)  -> filter point by a given distance in Miles
whereDistanceInFeet(array $point, float $distance)   -> filter point by a given distance in Miles


``` 
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email marco@magutti.com instead of using the issue tracker.

## Credits

-   [marcoax](https://github.com/magutti)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.



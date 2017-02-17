# PHP - Associative Arrays Simplified

This library allow simplified manipulation of recursive associative arrays with an object oriented aproach in php.

[![Build Status](https://travis-ci.org/oliverde8/AssociativeArraySimplified.svg?branch=master)](https://travis-ci.org/oliverde8/AssociativeArraySimplified) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/?branch=master)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fc4c6968-5c27-49ee-9cda-4d648aa650f9/big.png)](https://insight.sensiolabs.com/projects/fc4c6968-5c27-49ee-9cda-4d648aa650f9)

## Associative Array 

This is the main clas of the library. It allows the manipulation of the association arrays with ease. 

This allow you to get data from an associative array with ease. This can be used many places even for getting information from SESSION or POST & GET values.

### Exemple

To get a value from a simple array. 

```php
$array = ['a' => 1, 'b' => 2,];
$object = new AssociativeArray($array);

$this->get('a');
//This will return '1'

$this->get('c');
//This will return null
```

What really helps is you can actually set a default value to get. 

```php
$this->get('c', 10);
//This will return 10
```

But most importantly it's recursive. 

```php
$array = ['a' => ['b' => 2]];
$object = new AssociativeArray($array);

$this->get('a');
//This will return ['b' => 2]

$this->get(['a', 'b']);
//This will return 2
```

> And of course you can continue to use default values with the recursive get.

You can also use separators to use simple strings in the get : 

```php
$this->get('a/b');
//This will return 2
```

Of course you can simply edit the content of the array :

```php
// Both of these do the same thing.
$this->set('a/d', 10);
$this->set(['a','d'], 10);
```

And finally you can get back your array : 

```php
// And you get back the array.
$this->array()
```

## Exemple static methods

The class has also static methods to manipulate your array directly.

```php
$array = ['a' => ['b' => 2]];
AssociativeArray::getFromKey($array, 'a/b'); 
// Will return 2
```

And to set new data.
```php
$array = ['a' => ['b' => 2]];
AssociativeArray::setFromKey($array, 'a/c', 'yop); 
// Will return ['a' => ['b' => 2, 'c' => 'yop']] 
```

## More Exemples. 

When creating the AssociativeArray you can specify the separator to use. So instead of 
```php
$array = ['a' => ['b' => 2]];
$object = new AssociativeArray($array);
$this->get('a/b');
```

You can write

```php
$array = ['a' => ['b' => 2]];
$object = new AssociativeArray($array, '.');
$this->get('a.b');
```

# TODO
* Check composer & Add to packagist. Yop all is ready for take off
* Add some more options (clear, disable new data ...)
* Add a second version using references to use less memory.
* Something else? Open a ticket :) 

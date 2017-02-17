# PHP - Associative Arrays Simplified

This library allow simplified manipulation of recursive associative arrays with an object oriented aproach in php.

[![Latest Stable Version](https://poser.pugx.org/oliverde8/associative-array-simplified/v/stable)](https://packagist.org/packages/oliverde8/associative-array-simplified)
[![Build Status](https://travis-ci.org/oliverde8/AssociativeArraySimplified.svg?branch=master)](https://travis-ci.org/oliverde8/AssociativeArraySimplified) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/oliverde8/AssociativeArraySimplified/?branch=master)
[![Total Downloads](https://poser.pugx.org/oliverde8/associative-array-simplified/downloads)](https://packagist.org/packages/oliverde8/associative-array-simplified)
[![License](https://poser.pugx.org/oliverde8/associative-array-simplified/license)](https://packagist.org/packages/oliverde8/associative-array-simplified)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fc4c6968-5c27-49ee-9cda-4d648aa650f9/big.png)](https://insight.sensiolabs.com/projects/fc4c6968-5c27-49ee-9cda-4d648aa650f9)

## Associative Array 

This is the main clas of the library. It allows the manipulation of the association arrays with ease. 

This allow you to get data from an associative array with ease. This can be used many places even for getting information from SESSION or POST & GET values.

Typically when we try and get information from a an array of which we don't know the content we need to write a lot of conditions :

```php
$array = ['a' => ['b' => 2, 'c' => 3]];
if (isset($array['a'])) {
    $valB = isset($array['a']['b']) ? $array['a']['b'] : "default";
    $valB = isset($array['a']['c']) ? $array['a']['c'] : "default";
}
```

After a certain while we write a lot conditions and the array is very nested it becomes difficult to understand. 
This library makes it much easier to write code of this type & makes it easier to read and understand. 
The code above is simply replaced by : 

```php
$object = new AssociativeArray( ['a' => ['b' => 2, 'c' => 3]]);
$valB = $object->get('a/b', 'default');
$valB = $object->get('a/c', 'default');
```

## Requirments
* `PHP` 5.4 or higher.

## Installation

You should always install the library using composer. 

```bash
composer require oliverde8/associative-array-simplified
```

**Manual installation is not recomended and not supported.**

## Usage Exemples

### Get values from a simple array

```php
$array = ['a' => 1, 'b' => 2,];
$object = new AssociativeArray($array);

$object->get('a');
//This will return '1'

$object->get('c');
//This will return null
```

### Get a value and if no value is set get a default one

```php
$object->get('c', 10);
//This will return 10
```

### Get nested values recursively

```php
$array = ['a' => ['b' => 2]];
$object = new AssociativeArray($array);

$object->get('a');
//This will return ['b' => 2]

$object->get(['a', 'b']);
//This will return 2
```

> And of course you can continue to use default values with the recursive get.

### Use separators in the string keys to get nested values 

The default separator is `/`

```php
$object->get('a/b');
//This will return 2
```

### You can set new values or replace them.

```php
// Both of these do the same thing.
$object->set('a/d', 10);
$object->set(['a','d'], 10);
```

### You can get back your array 

```php
// And you get back the array.
$object->array()
```

### Using custom separators

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

### Example usage of static methods

The class has also static methods to manipulate your array directly. The method of the objects actually uses these static methods to manipulate the array. 

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

## Other functions

The class has also other functions.

* **clear :** Empties all the data from the array.
* **keyExist :** Checks if a key exists. (value may be null)

## FAQ

### Why don't the associative array has an iterator ?

Associative Array Simplified doesen't try and replace arrays; other libraries were designed to do so. 
This library simply makes it easier yo access values in associative arrays.

### Why don't the associative array return associative array instead of normal array's ?

This is something I spent quite some time to decide, but doing it that way would require during the creation of the associative array to process the array to create the nested associative arrays.
This would have slowned then the process of creation without really increasing perormance at any other level. On long term I might create a second object working that way.

There is some questions about this how should this work : 

```php
$array = ['a' => ['b' => 2]];
$object = new AssociativeArray($array);

$object->get('a');
//This will return ['b' => 2]

$object->get(a)->get('b');
//Should return 2

$object->get(a)->get('b')->get('c', 'default');
//Will make an error but should have returned 'default'
```

So there is some reflexion to be done on the subject.

### Why don't the assotiative array use references ?

It's planned. Current implementation is slower as it duplicated the arrays during the set operations.

### ...

## TODO

* Add some more options (clear, disable new data ...)
* uses references to use less memory.
* create second version returning Associative Array instead of normal arrays.
* Something else? Open a ticket :) 

### Php once(memoize) function 

It does not make different logic each time, it does it in one go and stores the result in memory, so there is no extra operation and time loss when it is called repeatedly, it returns the previous result


**for install with composer** 
```console

composer require  zeus/once:dev-main
```
**for test**
```console
composer test
```
**Basic usage** 

```php

use function Zeus\Memoize\once;

$closure=function (){
 sleep(1);
 return random_int(1,100);
}

echo once($closure); // same value (it will sleep)
echo once($closure); //same value, it tooks from cache 

```
**Parameter usage** 


```php

use function Zeus\Memoize\once;


 $http = new  Http();
 
 $closure = function () use ($http) {
     return $http->get('https://www.foobar.com');
 };
 
 $content = once($closure);
 $content1=once($closure);
 
 //$content===$content1 =>true

```

**it sensitive to object change**
<br>
Via the **&** operator




```php


use function Zeus\Memoize\once;


 $person = new  Linkedin();
 $person->setName('dılo sürücü');
 
 $closure = function () use (&$person) {
     return $http->getProfiles();
 };
 
$content = once($closure);
$person->setName('abdulkadir sürücü');
$content1=once($closure);
 
 //$content===$content1 =>false

```

**once wrappers for objects**
<br>
OnceWrapper object offers memoize for object,
<br>
usage

```php
use Zeus\Memoize\OnceWrapper;


class Random
{

    /**
     * @throws Exception
     */
    public function getInteger(int $start, int $end):int
    {
        return random_int($start, $end);
    }
}

 $random = new Random();
 $once = new OnceWrapper($random);

 $first = $once->getInteger(1, 100);
 $second = $once->getInteger(1, 100);
 $this->assertEquals($first, $second);

```

>do you notice something, getInteger() method Random object in method but it's like the method of OnceWrapper object, yes it works just like that

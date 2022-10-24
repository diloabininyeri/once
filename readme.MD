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
**using** 

```php

use function Zeus\Memoize\once;

$closure=function (){
 sleep(1);
 return random_int(1,100);
}

echo once($closure); // same value (it will sleep)
echo once($closure); //same value, get from cache 

```


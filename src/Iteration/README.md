# General

This namespace defines the classes and interfaces necessary for looping ("iterating") through a set of values in an object.

For example:
```
// Define MyClass
class MyClass
{
    private $array = [ 1, 2, 3 ];
}

// Create a new object of type MyClass
$myObject = new MyClass();

// For each array item in my object, add them together
$total = 0;
foreach( $myObject as $value ) {
    $total += $value;
}
```

In order to accomplish this, there are three necessary components, in order:
1. `foreach()`
2. `IIterable`
3. `Iterator`

These are described below.


# foreach()

`foreach()` is the standard loop control that is built in to PHP that every one is familiar with. What most people are not familiar with is how to loop over an object. PHP actually allows for this via the [Traversable interface](https://www.php.net/manual/en/class.traversable.php). However, this leaves much to be desired and muddies the waters of what actually needs to be done. That's why we're here.

In this implementation, `foreach()` loops over an `IIterable` object. In order to make an object iterable, make its class implement `IIterable`.


# IIterable

`IIterable` describes an object that can be looped over by a `foreach()` loop. In order to do so, the `IIterable` must inform the `foreach()` loop _how_ to loop over its contents. It does this by specifying an `Iterator` via the `getIterator()` method.


# Iterator

`Iterator` instructs the `foreach()` loop how to walk through and retrieve the items in `IIterable`. It does this by four main methods:
1. `rewind()`:     Resets to the first item.
2. `hasCurrent()`: Informs `foreach()` that there is a key and value at the current position.
3. `getKey()`:     Retrieves the current key.
4. `getValue()`:   Retrieves the current value.
5. `goToNext()`:   Moves the internal cursor to the next item.

In order to define a new `Iterator`, all of these methods must be implemented.
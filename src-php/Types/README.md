# Usage

Use `TypeLookupSingleton::getInstance()` to retrieve a singleton instance of the `TypeLookup` implementation. This can be used as follows:

```
$typeLookup = TypeLookupSingleton::getInstance();

// Retrieve type information by the name of the type
$integerType = $typeLookup->getByName( 'int' );

// Retrieve type information by its value
$stringType = $typeLookup->getByValue( 'foobar' );
```


# Extending

If someone would like to implement a custom `TypeLookup` implementation, they can. Do so by extending the `TypeLookup` class.

Do not extend `TypeLookupSingleton`: it is marked as final to prevent this from happening. `TypeLookupSingleton` should only ever be used to retrieve the default implementation of `TypeLookup`.
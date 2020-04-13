# Iterating Collections

Iterating a Collection can be done by wrapping that Collection in a `foreach()` loop.

To iterate over a Collection's values:
```
foreach( $collection->getValues() as $value ) {
    // ...
}
```

To iterate over a Collection's keys:
```
foreach( $collection->getKeys() as $key ) {
    // ...
}
```

Note: all Collections can be iterated over using the above examples, regardless if it is a Dictionary or Sequence.


## Dictionary

Iterating over a Dictionary produces a `KeyValuePair` for each entry. This is because Dictionaries support non-scalar keys, such as objects, and PHP's `foreach()` loop does not handle these. This workaround is similar to C#'s implementation.

```
foreach( $dictionary as $item ) {
    $key   = $item->getKey();
    $value = $item->getValue();

    // ...
}
```


## Sequence

A Sequence's values can be iterated over directly without needing to retrieve its values first:

```
foreach( $sequence as $key ) {
    // ...
}
```
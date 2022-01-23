# Types

Each PHP type category is represented as its own Type class, which gives information about that Type. All Type classes implement `TypeInterface`.

1. `new ArrayType()`
2. `new BooleanType()`
3. `new ClassType(string $name)`
   * `$name` expects the class name.
4. `new FloatType()`
5. `new IntegerType()`
6. `new InterfaceType(string $name)`
    * `$name` expects the interface name.
7. `new StringType()`

## See also
* [Type Interfaces](../TypeInterface)
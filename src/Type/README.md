# Types

Each PHP type is represented as its own Type class, which retrieves information about it.

1. `new ArrayType()` - Array Type.
2. `new BooleanType()` - Bool / Boolean Type.
3. `new ClassType(string $name)` - Class Type.
   * `$name` - the class name.
4. `new FloatType()` - Float / Double Type.
5. `new IntegerType()` - Integer Type.
6. `new InterfaceType(string $name)` - Interface Type.
    * `$name` - the interface name.
7. `new StringType()` - String Type.

## See also
* [Type Interfaces](../TypeInterface)
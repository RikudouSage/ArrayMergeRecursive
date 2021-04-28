# array_merge_recursive replacement

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8807e12a330745af9c07ec5c91961f27)](https://app.codacy.com/gh/RikudouSage/ArrayMergeRecursive?utm_source=github.com&utm_medium=referral&utm_content=RikudouSage/ArrayMergeRecursive&utm_campaign=Badge_Grade_Settings)
[![Tests](https://github.com/RikudouSage/ArrayMergeRecursive/actions/workflows/test.yaml/badge.svg)](https://github.com/RikudouSage/ArrayMergeRecursive/actions/workflows/test.yaml)
[![Coverage Status](https://img.shields.io/coveralls/github/RikudouSage/ArrayMergeRecursive/master.svg)](https://coveralls.io/github/RikudouSage/ArrayMergeRecursive?branch=master)
[![Download](https://img.shields.io/packagist/dt/rikudou/array-merge-recursive.svg)](https://packagist.org/packages/rikudou/array-merge-recursive)

## Installation

`composer require rikudou/array-merge-recursive`

## Description

The php function [`array_merge_recursive`](https://www.php.net/manual/en/function.array-merge-recursive.php)
behaves a little confusingly and not at all like
[`array_merge`](https://www.php.net/manual/en/function.array-merge.php).

Example of confusing behavior:

```php
<?php

$array1 = [
    'test' => 'test'
];

$array2 = [
    'test' => 'test2'
];

$result = array_merge_recursive($array1, $array2);

// $result = 
// array(1) {
//   'test' =>
//   array(2) {
//     [0] =>
//     string(4) "test"
//     [1] =>
//     string(5) "test2"
//   }
// }
```

As you can see, the built in function doesn't replace the same
keys but instead merges them together.

Compared to regular `array_merge`:

```php
<?php

$array1 = [
    'test' => 'test'
];

$array2 = [
    'test' => 'test2'
];

$result = array_merge($array1, $array2);

// $result = 
// array(1) {
//   'test' =>
//   string(5) "test2"
// }
```

The `array_merge` replaces the values with whatever comes
latest but doesn't work for deep array structures.

This library replaces the `array_merge_recursive` behavior to work
like regular `array_merge` while maintaining the ability
to merge deep arrays recursively.

Example:

```php
<?php

use function Rikudou\ArrayMergeRecursive\array_merge_recursive;

$array1 = [
    'test' => 'test'
];

$array2 = [
    'test' => 'test2'
];

$result = array_merge_recursive($array1, $array2);

// $result = 
// array(1) {
//   'test' =>
//   string(5) "test2"
// }
```

## Deeper level array example

These two arrays are used in the following example:

```php
<?php

$array1 = [
    'test' => [
        'key1' => 'test',
        'key2' => 'test',
        'key3' => 'test'
    ]
];

$array2 = [
    'test' => [
        'key2' => 'test2',
        'key4' => 'test2'
    ]
];
```

### Result of built-in `array_merge_recursive`

```
array(1) {
  'test' =>
  array(4) {
    'key1' =>
    string(4) "test"
    'key2' =>
    array(2) {
      [0] =>
      string(4) "test"
      [1] =>
      string(5) "test2"
    }
    'key3' =>
    string(4) "test"
    'key4' =>
    string(5) "test2"
  }
}
```

Here you can see that `key2` gets changed to array with both values
added.

### Result of built-in `array_merge`

```
array(1) {
  'test' =>
  array(2) {
    'key2' =>
    string(5) "test2"
    'key4' =>
    string(5) "test2"
  }
}
```
Since `array_merge` doesn't work recursively it completely replaces
the `test` key with value from 2nd array.

### Result of `array_merge_recursive` from this library

```
array(1) {
  'test' =>
  array(4) {
    'key1' =>
    string(4) "test"
    'key2' =>
    string(5) "test2"
    'key3' =>
    string(4) "test"
    'key4' =>
    string(5) "test2"
  }
}
```

This library correctly replaces the `key2` with later value
while keeping the whole tree.

php-jqString
===
A PHP String class that wraps the native string functions to provide an easy and similar access as in jQuery/Javascript syntax; also adding some features not included in the original class.

This class is based on the String class written by [Alec Gorge] (https://github.com/alecgorge) but with some additions and modifications, [here] (https://github.com/egpo/PHP-String-Class) is the original class.

String Class Methods
---
Here are some of the methods used in this class, for a full list, check the String.php file.

Creating a new String object:
```
class String implements ArrayAccess { }

$str = new String("some text");
```
Converts the String object into a string
```
public function toString () { }
```
ArrayAccess Methods
Similar to array_key_exists
```
public function offsetExists ($index) { }
```
Retrieves an array value
```
public function offsetGet ($index) { }
```
Sets an array value
```
public function offsetSet ($index, $val) { }
```
Removes an array value
```
public function offsetUnset ($index) { }
```
Create a new Sting
```
public static function create ($obj) { }
```
Standard PHP substr function, return a new String object
```
public function substr ($start, $length = NULL) { }
```
Standard PHP substr function, return a string
```
public function _substr ($start, $length = NULL) { }
```
Similar functionality of [jQuery substring] (http://www.w3schools.com/jsref/jsref_substring.asp)
```
public function substring ($start, $end) { }
```
Regular expression match.  
flags implement the same as the flags for **preg_match_all** [PHP funciton] (http://php.net/preg_match_all)
```
public function match ($regex, $flags = PREG_PATTERN_ORDER) { } 
```
Regualr expression Reverse match.
```
public function reversematch ($regex, $flags = PREG_PATTERN_ORDER) { } 
```
Regex replace
```
public function replace ($search, $replace, $regex = false) { }
```
Convert String to lower case
```
public function toLowerCase () { }
```
Convert String to upper case
```
public function toUpperCase () { }
```
Trim a string, but with additional charlist option, [here] (http://php.net/manual/en/function.trim.php)
```
public function trim ($charlist = null) { }
```
Left Trim a string, but with additional charlist option, [here] (http://php.net/manual/en/function.ltrim.php)
```
public function ltrim ($charlist = null) { }
```
Right Trim a string, but with additional charlist option, [here] (http://php.net/manual/en/function.rtrim.php)
```
public function rtrim ($charlist = null) { }
```
Implements [PHP's str_word_count] (http://php.net/manual/en/function.str-word-count.php)
```
public function word_count ($format = 0, $charlist = UTF8_DECODED_CHARLIST) { }
```
Returns string block between two Regex, the result in similar behavior as match.
```
public function block ($begin_regex, $end_regex, $flags = PREG_PATTERN_ORDER) { }
```
Returns string block between two Regex, the result in similar behavior as match.
```
public function reverseblock ($begin_regex, $end_regex, $flags = PREG_PATTERN_ORDER) { }
```

Array Class Methods
---
```
class Arr extends ArrayObject { }
```
Array concatenate
```
public function add () { }
```
Get array element
```
public function get ($i) { }
```
Perform [each] (http://api.jquery.com/each/) loop on an array
```
public function each ($callback) { }
``` 
Push one or more elements onto the end of array, if key not null, can push on array of array
```
public function push ($value, $key=NULL) { }
```
Pops the last element of the array
```
public function pop () { }
```
Shift an element off the beginning of array
```
public function shift () { }
```
UnShift an element off the beginning of array
```
public function unshift ($value) { }
```
Takes an input array object and returns a new array object without duplicate values.
Implements the PHP's [array_unique] (http://il1.php.net/manual/en/function.array-unique.php) function
```
public function unique ($sort_flags = SORT_STRING){ }
```
Join two arrays
```
public function join ($paste = '') { }
```
Sort an array
```
public function sort () { }
```

License: The MIT License (MIT)
---
Copyright (c) 2014 Ze'ev Cohen (zeevc AT egpo DOT net)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
 
http://opensource.org/licenses/MIT

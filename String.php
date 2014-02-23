<?php

// A PHP String class that wraps the native string functions to provide an easy and similar access as in 
// jQuery/Javascript syntax; also adding some features not included in the original class.
//
// Based on String class written by Alec Gorge but with some additions and modifications
// https://github.com/alecgorge/PHP-String-Class
//
// When a method/function is by Alec, I will mention that as like this: 
//   by A.G.
// If modified I will mention like this:
//   by A.G. - modified


/**
@function mb_str_split - Converts a string to an array.
@param (str) string - The input string.
@param (length) int - Maximum length of the chunk.
@return array - If the optional split_length parameter is specified, the returned array will be broken down into chunks with each being split_length in length, 
				otherwise each chunk will be one character in length.
				FALSE is returned if split_length is less than 1. If the split_length length exceeds the length of string, 
				the entire string is returned as the first (and only) array element.
@author A.G.
*/
if (!function_exists('mb_str_split')) {
    function mb_str_split($str, $length = 1)
    {
        preg_match_all('/.{1,' . $length . '}/us', $str, $matches);
        return $matches[0];
    }
}
/**
@function mb_str_word_count - Return information about words used in a string
@param (string) string - The string
@param (format) int - Specify the return value of this function. The current supported values are:
@... 0 - returns the number of words found
@... 1 - returns an array containing all the words found inside the string
@... 2 - returns an associative array, where the key is the numeric position of the word inside the string and the value is the actual word itself
@param (charlist) string - A list of additional characters which will be considered as 'word'
@return array - Returns an array or an integer, depending on the format chosen.
@author Z.C.
*/
define('WC_COUNT', 0);
define('WC_WORDS', 1);
define('WC_WORDS_ASSOC', 2);
define('PREG_OFFSET_CAPTURE_INNER',50);
if (! function_exists ('mb_str_word_count')) {
	function mb_str_word_count ($string, $format = 0, $charlist = UTF8_DECODED_CHARLIST) {
		$r = str_word_count(utf8_decode($string),$format,$charlist);
		if($format == WC_WORDS || $format == WC_WORDS_ASSOC) {
			foreach($r as $k => $v) {
				$u[$k] = utf8_encode($v);
			}
			return $u;
		}
		return $r;
	}
}
/**
@function mb_str_split - Converts a string to an array.
@param (str) string - The input string.
@param (length) int - Maximum length of the chunk.
@return array - If the optional split_length parameter is specified, the returned array will be broken down into chunks with each being split_length in length, 
				otherwise each chunk will be one character in length.
				FALSE is returned if split_length is less than 1. If the split_length length exceeds the length of string, 
				the entire string is returned as the first (and only) array element.
@author A.G.
*/
if (!function_exists('mb_str_replace')) {
	function mb_str_replace($search,$replace,$subject){
		$offset = 0;
		while(!is_bool($pos = mb_strpos($subject, $search, $offset))){
			$offset = $pos + mb_strlen($replace);
			$subject = mb_substr($subject, 0, $pos). $replace . mb_substr($subject, $pos+mb_strlen($search));
		}
	
		return $subject;
	}
}
/**
@function is_filename - Finds whether a value is a filename
@param (filename) string - The value being checked
@return bool - Returns TRUE if value is a filename, FALSE otherwise.
@author Z.C.
*/
if (! function_exists ('is_filename')) {
	function is_filename ($filename){
		return preg_match("/^[\w.-]+$/", $filename);
	}
}
/**
@function is_pathname - Finds whether a value is a pathname
@param (filename) string - The value being checked
@return bool - Returns TRUE if value is a pathname, FALSE otherwise.
@author Z.C.
*/
if (! function_exists ('is_pathname')) {
	function is_pathname ($pathname){
		return preg_match("/^[\/\w:.-]+$/", $pathname);
	}
}

class StaticString {
        /* static methods wrapping multibyte */

        /**
         * Wrapper for substr
         * 
         * @author A.G.
         */
        public static function substr ($string, $start, $length = NULL) {
                if(String::$multibyte) {
                        return new String(mb_substr($string, $start, $length, String::$multibyte_encoding));
                }
                return new String(substr($string, $start, $length));
        }
        
        /**
         * @function (_substr) - Same as strstr, but returns a string instead of String object
         * @author Z.C.
         */
        
        public static function _substr ($string, $start, $length = NULL) {
        	if(String::$multibyte) {
        		return mb_substr($string, $start, $length, String::$multibyte_encoding);
        	}
        	return substr($string, $start, $length);
        }
        

        /**
         * Equivelent of Javascript's String.substring
         * @link http://www.w3schools.com/jsref/jsref_substring.asp
         * @author A.G. with modification done by Z.C.
         */
        public static function substring ($string, $start, $end) {
                if(empty($end)) {
                        return self::substr($string, $start);
                }
                return self::substr($string, $start, $end - $start);
        }

        /**
         * Equivelent of Javascript's String.substring, but returns string instead of String object
         * @link http://www.w3schools.com/jsref/jsref_substring.asp
         * @author Z.C.
         */
		public static function _substring ($string, $start, $end) {
        	if(empty($end)) {
        		return self::_substr($string, $start);
        	}
        	return self::_substr($string, $start, $end - $start);
        }
        
        /**
         * @author A.G. 
         */
        public function charAt ($str, $point) {
                return self::substr($str, $point, 1);
        }
        /**
         * @author A.G. 
         */
		public function charCodeAt ($str, $point) {
                return ord(self::substr($str, $point, 1));
        }
		/**
         * @function concat - Joins two arrays
         * @author A.G.
         */
        public static function concat () {
                $args = func_get_args();
                $r = "";
                foreach($args as $arg) {
                        $r .= (string)$arg;
                }
                return $arg;
        }

        /**
         * @author A.G. 
         */
        public static function fromCharCode ($code) {
                return chr($code);
        }

        /**
         * @author A.G. 
         */
        public static function indexOf ($haystack, $needle, $offset = 0) {
                if(String::$multibyte) {
                        return mb_strpos($haystack, $needle, $offset, String::$multibyte_encoding);
                }
                return strpos($haystack, $needle, $offset);
        }

        /**
         * @author A.G. 
         */
        public static function lastIndexOf ($haystack, $needle, $offset = 0) {
                if(String::$multibyte) {
                        return mb_strrpos($haystack, $needle, $offset, String::$multibyte_encoding);
                }
                return strrpos($haystack, $needle, $offset);
        }

        /**
         * @function match - Perform a global regular expression match, but combines jQuery and PHP functionality
         * @param string $haystack - The input string.
         * @param string $regex - The pattern to search for, as a string.
         * @param int $flags - Check out this http://php.net/manual/en/function.preg-match-all.php for more info
         * @return Arr - Returns an array of full pattern matches (which might be null), or FALSE if an error occurred.
         * 
         * @link http://www.w3schools.com/jsref/jsref_match.asp, http://il1.php.net/manual/en/function.preg-match-all.php
         * @author A.G. with modification done by Z.C.
         */
        public static function match ($haystack, $regex, $flags = PREG_PATTERN_ORDER) {
                preg_match_all($regex, $haystack, $matches, $flags);
                return new Arr($matches[0]);
        }
        /**
         * @function reversematch - Same as match but results are returned in reverse order

         * @link http://www.w3schools.com/jsref/jsref_match.asp, http://il1.php.net/manual/en/function.preg-match-all.php
         * @author Z.C.
         */
        public static function reversematch ($haystack, $regex, $flags = PREG_PATTERN_ORDER) {
        	preg_match_all($regex, $haystack, $matches, $flags);
        	return new Arr(array_reverse($matches[0]));
        }
        
        
        // by A.G.
        /**
         * @function replace - Perform a regular expression search and replace
         * @param string $haystack - The input string.
         * @param string $regex - The pattern to search for, as a string.
         * @param int $flags - Check out this http://php.net/manual/en/function.preg-match-all.php for more info

         * @param unknown $haystack
         * @param unknown $needle
         * @param unknown $replace
         * @param unknown $regex
         * 
         * @link http://php.net/manual/en/function.preg-replace.php
         * @author A.G. - modified by Z.C.
         */
        public static function replace ($haystack, $needle, $replace, $regex = false) {
                if($regex) {
                	$r = preg_replace('/'.$needle.'/', $replace, $haystack);
                } else {
                	if(String::$multibyte) {
                		$r = mb_str_replace($needle, $replace, $haystack);
                		//$r = preg_replace('/'.$needle.'/', $replace, $haystack);//mb_ereg_replace($needle, $replace, $haystack);
					} else {
                    	$r = str_replace($needle, $replace, $haystack);
					}
                }
                return new String($r);
        }

        // by A.G.
        public static function strlen ($string) {
                if(String::$multibyte) {
                        return mb_strlen($string, String::$multibyte_encoding);
                }
                return strlen($string);
        }

        // by A.G.
        public static function slice ($string, $start, $end = null) {
                return self::substring($string, $start, $end);
        }

        // by A.G.
        public static function toLowerCase ($string) {
                if(String::$multibyte) {
                        return new String(mb_strtolower($string, String::$multibyte_encoding));
                }
                return new String(strtolower($string));
        }

        // by A.G.
        public static function toUpperCase ($string) {
                if(String::$multibyte) {
                        return new String(mb_strtoupper($string, String::$multibyte_encoding));
                }
                return new String(strtoupper($string));
        }

        // by A.G.
        public static function split ($string, $at = '') {
                if(empty($at)) {
                        if(String::$multibyte) {
                                return new Arr(mb_str_split($string));
                        }
                        return new Arr(str_split($string));
                }
                return new Arr(explode($at, $string));
        }

        /* end static wrapper methods */
        
        // by Z.C.
        public static function word_count ($string, $format = 0, $charlist = UTF8_DECODED_CHARLIST) {
        	return mb_str_word_count($string, $format, $charlist);
        }
        
        // by Z.C.
        public static function matchwords ($haystack, $regex, $flags = PREG_PATTERN_ORDER) {
                preg_match_all($regex, $haystack, $matches, $flags);
                return new Arr($matches[0]);
        }

        // by Z.C.
        //
        // Returns array of matching blocks between two regex.
        // No flags, default: PREG_PATTERN_ORDER:
        //   Arr[0] <- <body ...> .... </body>
        //  PREG_OFFSET_CAPTURE:
        //  Arr[0][0] <body ...> .... </body>
        //        [1] pos
        // Arr[1] <- Inner block; without the regex parts
        // Arr[2] <-

        public static function block ($string, $begin_regex, $end_regex, $order, $flags = PREG_PATTERN_ORDER) {
        	$matches = new Arr();

        	$begin = StaticString::match($string, $begin_regex, PREG_OFFSET_CAPTURE);
        	$end = StaticString::match($string, $end_regex, PREG_OFFSET_CAPTURE);
        	$endidx=0;
        	foreach($begin as $key => $val) {
        		while($end[$endidx][1]){
        			if ($end[$endidx][1] > $begin[$key][1]){
        				$push = Array();
        				switch($flags){
        					case PREG_PATTERN_ORDER: {
       							$push = StaticString::_substring ($string,$begin[$key][1],$end[$endidx][1]+StaticString::strlen($end[$endidx][0]));
								$endidx++;
        					} break;
        					case PREG_OFFSET_CAPTURE: {
        						$push[0] = StaticString::_substring ($string,$begin[$key][1],$end[$endidx][1]+StaticString::strlen($end[$endidx][0]));
        						$push[1] = $begin[$key][1];
        						$endidx++;
        					} break;
        					case PREG_OFFSET_CAPTURE_INNER: {
        						$push[0] = StaticString::_substring ($string,$begin[$key][1],$end[$endidx][1]+StaticString::strlen($end[$endidx][0]));
        						$push[1] = $begin[$key][1];      						
        						$push[2] = StaticString::strlen($begin[$key][0]);
        						$push[3] = $end[$endidx][1];
        						$push[4] = StaticString::strlen($end[$endidx][0]);
        						$endidx++;
        					} break;
        				} // switch
						if ($order == 'f'){
      						$matches->push($push);
       					} else {
       						$matches->unshift($push);
       					}
        				break;
					} else {
        				$endidx++;
        			}
        		} // while
        	}
        	return $matches;
    	}
}
        
class String implements ArrayAccess {
        public static $multibyte_encoding = null;
        public static $multibyte = false;

        private $value;
        private static $checked = false;

        /* magic methods */
        public function __construct ($string) {
                if(!self::$checked) {
                        self::$multibyte = extension_loaded('mbstring');
                }
                if(is_null(self::$multibyte_encoding)) {
                        if(self::$multibyte) {
                                self::$multibyte_encoding = mb_internal_encoding();
                        }
                }
                $this->value = (string)$string;
        }
        
        public function __toString () {
                return $this->value;
        }

        /* end magic methods */
        
        /* ArrayAccess Methods */
        
        /** offsetExists ( mixed $index )
                *
                * Similar to array_key_exists
                */
        // by A.G.
        public function offsetExists ($index) {
                return !empty($this->value[$index]);
        }
        
        /* offsetGet ( mixed $index ) 
         *
         * Retrieves an array value
         */
        // by A.G.
        public function offsetGet ($index) {
                return StaticString::substr($this->value, $index, 1)->toString();
        }
        
        /* offsetSet ( mixed $index, mixed $val ) 
         *
         * Sets an array value
         */
        // by A.G.
        public function offsetSet ($index, $val) {
                $this->value = StaticString::substring($this->value, 0, $index) . $val . StaticString::substring($this->value, $index+1, StaticString::strlen($this->value));
        }
        
        /* offsetUnset ( mixed $index ) 
         *
         * Removes an array value
         */
        // by A.G.
        public function offsetUnset ($index) {
                $this->value = StaticString::substr($this->value, 0, $index) . StaticString::substr($this->value, $index+1);
        }

        // by A.G.
        public static function create ($obj) {
                if($obj instanceof String) return new String($obj);
                return new String($obj);
        }
        
        // by Z.C.
        public function _substr ($start, $length = NULL) {
        	return StaticString::_substr($this->value, $start, $length);
        }
        
        /* public methods */
        // by A.G. - modified
        // A bug was fixed when $length was not provided, neededto add = NULL
        public function substr ($start, $length = NULL) {
                return StaticString::substr($this->value, $start, $length);
        }

        // by A.G.
        public function substring ($start, $end) {
                return StaticString::substring($this->value, $start, $end);
        }

        // by A.G.
        public function charAt ($point) {
                return StaticString::substr($this->value, $point, 1);
        }

        // by A.G.
        public function charCodeAt ($point) {
                return ord(StaticString::substr($this->value, $point, 1));
        }

        // by A.G.
        public function indexOf ($needle, $offset = 0) {
                return StaticString::indexOf($this->value, $needle, $offset);
        }

        // by A.G.
        public function lastIndexOf ($needle) {
                return StaticString::lastIndexOf($this->value, $needle);
        }

        // by A.G. - modified
        public function match ($regex, $flags = PREG_PATTERN_ORDER) {
                return StaticString::match($this->value, $regex, $flags);
        }

        // by A.G.
        public function replace ($search, $replace, $regex = false) {
                return StaticString::replace($this->value, $search, $replace, $regex);
        }

        // by A.G.
        public function first () {
                return StaticString::substr($this->value, 0, 1);
        }

        // by A.G.
        public function last () {
                return StaticString::substr($this->value, -1, 1);
        }

        // by A.G.
        public function search ($search, $offset = null) {
                return $this->indexOf($search, $offset);
        }

        // by A.G.
        public function slice ($start, $end = null) {
                return StaticString::slice($this->value, $start, $end);
        }

        // by A.G.
        public function toLowerCase () {
                return StaticString::toLowerCase($this->value);
        }

        // by A.G.
        public function toUpperCase () {
                return StaticString::toUpperCase($this->value);
        }

        // by A.G.
        public function toUpper () {
                return $this->toUpperCase();
        }

        // by A.G.
        public function toLower () {
                return $this->toLowerCase();
        }

        // by A.G.
        public function split ($at = '') {
                return StaticString::split($this->value, $at);
        }

        // by A.G.
        public function trim ($charlist = null) {
                return new String(trim($this->value, $charlist));
        }

        // by A.G.
        public function ltrim ($charlist = null) {
                return new String(ltrim($this->value, $charlist));
        }

        // by A.G.
        public function rtrim ($charlist = null) {
                return new String(rtrim($this->value, $charlist));
        }

        // by A.G.
        public function toString () {
                return $this->__toString();
        }
        
        // by Z.C.
        public function reversematch ($regex, $flags = PREG_PATTERN_ORDER) {
        	return StaticString::reversematch($this->value, $regex, $flags);
        }
        
        // by Z.C.
        public function word_count ($format = 0, $charlist = UTF8_DECODED_CHARLIST) {
        	return StaticString::word_count ($this->value, $format, $charlist);
        }
        
        // by Z.C.
        public function block ($begin_regex, $end_regex, $flags = PREG_PATTERN_ORDER) {
			return StaticString::block($this->value, $begin_regex, $end_regex, 'f', $flags);
        }
        
        // by Z.C.
        public function reverseblock ($begin_regex, $end_regex, $flags = PREG_PATTERN_ORDER) {
			return StaticString::block($this->value, $begin_regex, $end_regex, 'r', $flags);
        }
        
}
class Arr extends ArrayObject {
        private static $ret_obj = true;

        // by A.G.
        public function add () {
                $val = 0;
                foreach($this as $vals) {
                        $val += $vals;
                }
                return $val;
        }

        // by A.G.
        public function get ($i) {
                $val = $this->offsetGet($i);
                if(is_array($val)) {
                        return new self($val);
                }
                if(is_string($val) && self::$ret_obj) {
                        return new String($val);
                }
                return $val;
        }

        // by A.G.
        public function each ($callback) {
        	//echo $callback."<br>";
                foreach($this as $key => $val) {
                        call_user_func_array($callback, array(
                                $val, $key, $this
                        ));
                }
                return $this;
        }

        // by A.G.
        public function set ($i, $v) {
                $this->offsetSet($i, $v);
                return $this;
        }

        // by A.G. - modified
        //  Push one or more elements onto the end of array
        public function push ($value, $key=NULL) {
        		if ($key){
        			$this[$key][] = $value;
        		} else {
        			$this[] = $value;
        		}
                return $this;
        }

        // Pop the element off the end of array
        // by Z.C.
        public function pop () {
			$array = (array)$this;
        	$value = array_pop($array);
        	$this->exchangeArray($array);
        	if(is_array($value)) {
        		return new self($value);
        	}
        	if(is_string($value) && self::$ret_obj) {
        		return new String($value);
        	}
        	return $value;
		}
        	        
        // Shift an element off the beginning of array
        // by Z.C.
        public function shift () {
        	$array = (array)$this;
        	$value = array_shift($array);
        	$this->exchangeArray($array);
        	if(is_array($value)) {
        		return new self($value);
        	}
        	if(is_string($value) && self::$ret_obj) {
        		return new String($value);
        	}
        	return $value;
		}

        // UnShift an element off the beginning of array
        // by Z.C.
        // int array_unshift ( array &$array , mixed $value1 [, mixed $... ] )
        public function unshift ($value) {
        	$array = (array)$this;
        	array_unshift($array, $value);
        	$this->exchangeArray($array);
        	return count($this);
        }

        // by Z.C.
        // unique - Takes an input array object and returns a new array object without duplicate values.
        // The input array.
        // sort_flags
        // SORT_REGULAR - compare items normally (don't change types)
        // SORT_NUMERIC - compare items numerically
        // SORT_STRING - compare items as strings
        // SORT_LOCALE_STRING - compare items as strings, based on the current locale.
        //
        // int array_unshift ( array &$array , mixed $value1 [, mixed $... ] )
        public function unique ($sort_flags = SORT_STRING){
        	$array = (array)$this;
        	return new Arr(array_unique($array, $sort_flags));
        }
        
        // by A.G.
        public function join ($paste = '') {
                return implode($paste, $this->getArrayCopy());
        }

        // by A.G.
        public function sort () {
                $this->asort();
                return $this;
        }

        // by A.G.
        public function toArray () {
                return $this->getArrayCopy();
        }

        // by A.G.
        public function natsort () {
                parent::natsort();
                return $this;
        }

        // by A.G.
        public function rsort () {
                parent::uasort('Arr::sort_alg');
                return $this;
        }

        // by A.G.
        public static function sort_alg ($a,$b) {
            if ($a == $b) {
                        return 0;
                }
                return ($a < $b) ? 1 : -1;
        }
}
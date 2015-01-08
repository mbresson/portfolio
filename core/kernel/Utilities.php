<?php
assert(defined('ROOT'));


/*******************************
             CLASS
*******************************/

class Utilities {

  /**
   * @param array $array
   * An associative array.
   *
   * @return array
   */
  public static function assoc_array_shuffle($array) {
    $keys = array_keys($array);
    $new = array();

    shuffle($keys);

    foreach($keys as $key) {
      $new[$key] = $array[$key];
    }

    return $new;
  }

}


<?php
assert(defined('ROOT'));


/*******************************
             CLASS
*******************************/

class Data {

  public static function exists($filename) {
    return file_exists("core/data/$filename.php");
  }

  /**
   * @param string $filename
   * the name of the config file to decode, excluding its extension
   *
   * @return array
   * the configuration loaded from the file
   */
  public static function load($filename) {
    $contents = array();

    ob_start();
    include "core/data/$filename.php";
    ob_end_clean();

    return $contents;
  }

}

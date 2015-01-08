<?php
assert(defined('ROOT'));


/*******************************
         DEPENDENCIES
*******************************/

require_once 'Data.php';


/*******************************
             CLASS
*******************************/

class Works {

  private static $works = array();
  private static $categories = array();
  private static $licenses = array();


  /**
   * @param string $work
   * The name of the work.
   *
   * @return bool
   * False if the work is not lised in $works or
   *       if its file in works/ directory doesn't exist.
   */
  public static function exists($work) {
    return 
      array_key_exists($work, Works::$works) &&
      Data::exists('works/' . $work);
  }


  /**
   * @return array
   */
  public static function get_categories() {
    return Works::$categories;
  }


  /**
   * @return array
   */
  public static function get_licenses() {
    return Works::$licenses;
  }


  /**
   * @return array
   */
  public static function get_works() {
    return Works::$works;
  }


  public static function init() {
    $data = Data::load('Works');

    Works::$works = $data['works'];
    Works::$categories = $data['categories'];
    Works::$licenses = $data['licenses'];
  }


  /**
   * @param string $work
   * The name of the work to load.
   *
   * @return array
   * All information related to this work.
   */
  public static function load_work($work) {
    return Data::load('works/' . $work);
  }

}


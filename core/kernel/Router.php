<?php
assert(defined('ROOT'));


/*******************************
         DEPENDENCIES
*******************************/

require_once 'Controllers.php';
require_once 'Data.php';
require_once 'I18N.php';


/*******************************
             CLASS
*******************************/

class Router {

  private static $routes = array();

  private static $root = '/';


  /**
   * @return string
   */
  public static function get_root() {
    return Router::$root;
  }


  /**
   * @return array
   */
  public static function get_routes() {
    return Router::$routes;
  }


  public static function init() {
    $config = Data::load('Routes');

    Router::$routes = $config['routes'];
    Router::$root = $config['root'];

    $app = \Slim\Slim::getInstance();

    // set the controller for the 404 error
    $app->notFound("Controllers::not_found");

    foreach(Router::$routes as $controller => $route) {
      switch($route['type']) {

        case 'get':
          $app->get($route['url'], "Controllers::$controller");
          break;

        case 'post':
          $app->post($route['url'], "Controllers::$controller");
          break;

        /*
         * we don't register routes of type 'file' or 'external'
         * because they don't require a controller and/or a view
         */

        case 'file':
          $preferred_language = I18N::get_preferred_language();

          Router::$routes[$controller]['url'] = Router::build_localized_filelink(
            $route['url'] . '.' . $route['extension'],
            $preferred_language
          );

          break;

        case 'external':
          break;
      }
    }
  }

  /**
   * @param string $preferred_language
   * A language code, e.g. 'fr'.
   *
   * @return string
   * The complete path to the file.
   */
  public static function build_localized_filelink($filename, $preferred_language = NULL) {
    if(!is_string($preferred_language)) {
      $preferred_language = I18N::get_preferred_language();
    }

    $ext_index = strpos($filename, '.');
    if($ext_index === false) {
      $route['url'] = $filename;
      $route['extension'] = '';
    } else {
      $route['url'] = substr($filename, 0, $ext_index);
      $route['extension'] = substr($filename, $ext_index);
    }

    /*
     * is there a version of the file for this $language?
     * if no, link to the file in the fallback language
     */
    $default_language = I18N::get_default_language();

    $path = 'files/' .
      $route['url'] . '-' .
      $preferred_language .
      $route['extension'];

    if(!file_exists($path)) {
      $path = 'files/' .
        $route['url'] . '-' .
        $default_language .
        $route['extension'];
    }

    return $path;
  }

}


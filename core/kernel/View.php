<?php
assert(defined('ROOT'));


/*******************************
         DEPENDENCIES
*******************************/

require_once 'I18N.php';
require_once 'Router.php';


/*******************************
             CLASS
*******************************/

class View {

  /**
   * @return array
   * An array containing all the data needed by the template files.
   * - [I18N] (array)
   * - [Router] (array)
   */
  public static function data() {
    return array(
      'I18N' => array(
        'preferred_language' => I18N::get_preferred_language(),
        'languages' => I18N::get_languages()
      ),

      'Router' => array(
        'routes' => Router::get_routes(),
        'root' => Router::get_root()
      )
    );
  }

  /**
   * @param string $controller
   * The name of the calling controller
   *
   * @param array $add_data
   * Additional data to transmit to the view
   *
   * Renders a template file with Twig.
   */
  public static function render($controller, $add_data = NULL) {
    $data = View::data();
    $data['page'] = array(
      'title' => Router::get_routes()[$controller]['name'],
      'id' => $controller
    );

    if(is_array($add_data)) {
      $data['data'] = $add_data;
    }

    $app = \Slim\Slim::getInstance();

    $app->view()->setData(
      'GLOB',
      $data
    );

    $app->render("$controller.twig");
  }

  public static function render_unregistered_route($name, $title) {
    $data = View::data();
    $data['page'] = array(
      'title' => $title,
      'id' => $name
    );

    $app = \Slim\Slim::getInstance();

    $app->view()->setData(
      'GLOB',
      $data
    );

    $app->render("$name.twig");
  }
}


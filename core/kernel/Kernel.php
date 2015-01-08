<?php
assert(defined('ROOT'));


/*******************************
         DEPENDENCIES
*******************************/

require_once 'Data.php';
require_once 'I18N.php';
require_once 'Router.php';


/*******************************
             CLASS
*******************************/

class Kernel {

  private static $dev = true;

  /**
   * Initializes Slim framework
   */
  public static function init() {
    $config = Data::load('Config');
    Kernel::$dev = $config['dev'];

    // create Slim instance
    session_cache_limiter(false);
    session_start();

    $app = new \Slim\Slim(array(
      'templates.path' => 'core/views',
      'view' => new \Slim\Views\Twig(),
      'log.level' => (Kernel::$dev ? \Slim\Log::DEBUG : \Slim\Log::WARN),
      'log.enabled' => true,
      'log.writer' => new \Slim\Logger\DateTimeFileWriter(array(
        'path' => 'core/logs',
        'name_format' => 'Y-m-d'
      ))
    ));

    // tweak Twig (add cache directory and I18N extension)
    $view = $app->view();

    $view->parserOptions = array(
      'charset' => 'utf-8',
      'cache' => realpath('core/views_cache'),
      'auto_reload' => true,
      'strict_variables' => true,
      'autoescape' => true
    );

    $view->parserExtensions = array(
      new \Slim\Views\TwigExtension(),
      'Twig_Extensions_Extension_I18n'
    );

    // initialize gettext with I18N class
    I18N::init();
    Router::init();
  }

}


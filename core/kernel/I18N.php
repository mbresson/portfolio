<?php
assert(defined('ROOT'));


/*******************************
         DEPENDENCIES
*******************************/

require_once 'Data.php';


/*******************************
            GLOBALS
*******************************/

// name of the cookie used to store the preferred language
// name of the URL parameter used to change the preferred language
define('I18N_LOCALE_TAG', 'lc');

// 1 year
define('I18N_COOKIE_LIFETIME', (60 * 60 * 24 * 360));


/*******************************
             CLASS
*******************************/

class I18N {

  // language informations containing [name], [abbr] and [code]
  private static $languages = array();

  private static $textdomain = 'default';

  private static $default_language = "en";
  private static $preferred_language = NULL;


  /**
   * @return array
   */
  public static function get_default_language() {
    return I18N::$default_language;
  }


  /**
   * @return array
   */
  public static function get_languages() {
    return I18N::$languages;
  }


  /**
   * @return array
   */
  public static function get_preferred_language() {
    if(!is_null(I18N::$preferred_language)) {
      return I18N::$preferred_language;
    }

    $app = \Slim\Slim::getInstance();

    // first, use the URL locale parameter, if provided
    $get = $app->request->get(I18N_LOCALE_TAG);

    if(!is_null($get)) {
      if(I18N::is_language_supported($get)) {
        I18N::set_preferred_language($get);

        return $get;
      }
    }

    // else, use the locale cooking if existing
    $cookie = $app->getCookie(I18N_LOCALE_TAG);

    if(!is_null($cookie)) {
      if(I18N::is_language_supported($cookie)) {
        return $cookie;
      }
    }

    // no preferred language, fallback to default one
    return I18N::get_default_language();
  }


  public static function init() {
    $config = Data::load('I18N');

    I18N::$languages = $config['languages'];
    I18N::$default_language = array_keys($config['languages'])[0];
    I18N::$textdomain = $config['textdomain'];

    $language = I18N::$languages[I18N::get_preferred_language()];

    setlocale(LC_ALL, $language['code']);

    bindtextdomain(I18N::$textdomain, 'core/l10n');
    textdomain(I18N::$textdomain);
  }


  /**
   * @param string $language
   * A language abbreviation code (e.g. en, fr)
   *
   * @retval bool
   */
  public static function is_language_supported($language) {
    return in_array(
      $language,
      array_keys(I18N::$languages)
    );
  }

  
  /**
   * @param string $language
   * A language abbreviation code (e.g. en, fr)
   *
   * Stores the preferred language in a cookie.
   */
  public static function set_preferred_language($language) {
    if(I18N::is_language_supported($language)) {
      I18N::$preferred_language = $language;

      $app = \Slim\Slim::getInstance();

      $app->setCookie(
        I18N_LOCALE_TAG,
        $language,
        time() + I18N_COOKIE_LIFETIME
      );
    }
  }
}


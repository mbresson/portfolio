<?php
assert(defined('ROOT'));


/*******************************
         DEPENDENCIES
*******************************/

require_once 'Data.php';
require_once 'Email.php';
require_once 'I18N.php';
require_once 'MathCaptcha.php';
require_once 'Post.php';
require_once 'Router.php';
require_once 'Utilities.php';
require_once 'View.php';
require_once 'Works.php';


/*******************************
             CLASS
*******************************/

class Controllers {

  public static function home() {
    $wisdom = Data::load('Wisdom');

    $index = mt_rand(0, count($wisdom) - 1);

    $data = array(
      'wisdom' => $wisdom[$index]
    );

    View::render('home', $data);
  }

  public static function not_found() {
    View::render_unregistered_route('404', '404');
  }

  public static function works() {
    Works::init();

    $works = Works::get_works();

    // search a thumbnail image for every work
    foreach($works as $key => $work) {
      $tn_prefix = 'img/works/' . $key . '/' . $key . '.tn';

      if(file_exists($tn_prefix . '.png')) {
        $works[$key]['thumbnail'] = router::get_root() . $tn_prefix . '.png';
      } else if(file_exists($tn_prefix . '.jpg')) {
        $works[$key]['thumbnail'] = router::get_root() . $tn_prefix . '.jpg';
      } else {
        $works[$key]['thumbnail'] = router::get_root() . 'img/works/missing.tn.png';
      }
    }

    /*
     * Sort the works by using Unicode comparison functions if possible.
     * If it's not possible, just shuffle the works.
     */
    if(class_exists('Collator')) {
      $language = I18N::get_preferred_language();
      $locale = I18N::get_languages()[$language]['code'];
      $collator = new Collator($locale);

      uasort($works, function($a, $b) use($collator) {
        return $collator->compare($a['name'], $b['name']);
      });
    } else {
      $works = Utilities::assoc_array_shuffle($works);
    }

    $data = array(
      'works' => $works,
      'categories' => Works::get_categories()
    );

    View::render('works', $data);
  }

  public static function work($work_id) {
    Works::init();

    if(!Works::exists($work_id)) {
      $app = \Slim\Slim::getInstance();
      $app->notFound();
      return;
    }

    $works = Works::get_works();
    $licenses = Works::get_licenses();
    $work = Works::load_work($work_id);

    $summary = $works[$work_id];
    $summary['work_id'] = $work_id;

    if(array_key_exists('license', $work)) {
      $work['license'] = $licenses[$work['license']];
    }

    if(array_key_exists('screenshots', $work)) {
      foreach($work['screenshots'] as $index => $screenshot) {
        // prepare the path to the screenshot and its thumbnail

        $path = 'img/works/' . $summary['work_id'] . '/' . $screenshot['src'];

        $allowed_extensions = ['.png', '.jpg'];
        $path_no_extension = $path;

        // get the path without the final extension
        foreach($allowed_extensions as $extension) {
          $ext_pos = strrpos($path, $extension);

          if($ext_pos === false) {
            continue;
          }

          $path_no_extension = substr($path, 0, $ext_pos);
          break;
        }

        $path_thumbnail = $path;

        // try various extensions for the thumbnail file
        foreach($allowed_extensions as $extension) {
          if(file_exists($path_no_extension . '.min' . $extension)) {
            $path_thumbnail = $path_no_extension . '.min' . $extension;
            break;
          }
        }
        
        $work['screenshots'][$index]['thumbnail'] = $path_thumbnail;
      }
    }

    $data = array(
      'summary' => $summary,
      'work' => $work
    );

    View::render('work', $data);
  }

  public static function contact() {
    $captcha = new MathCaptcha();
    $form_id = uniqid();

    $_SESSION['form_id'] = $form_id;
    $_SESSION['mq'] = $captcha->get_answer();
    $_SESSION['started'] = time(); // used to protect the form against bots, see contact_post()

    $data = array(
      'captcha' => $captcha->get_image(),
      'form' => array(
        'id' => $form_id
      )
    );

    View::render('contact', $data);
  }

  public static function contact_post() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $response = $app->response();

    $config = Data::load('Email');

    $response['Content-Type'] = 'application/json';

    /*
     * This function can return different answers to the client:
     *
     * [
     *   'ok' => true
     * ]
     * If the message was successfully sent.
     *
     * [
     *   'ok' => false,
     *   'error' => 'server'
     * ]
     * If the message couldn't be sent due to a server-side bug.
     *
     * [
     *   'ok' => false,
     *   'error' => 'session expired'
     * ]
     * The session has expired since the form was created.
     * This message is also sent if we suspect that the form has been filled by a bot
     * (e.g. the form has been filled in less than 2 seconds).
     *
     * [
     *   'ok' => false,
     *   'error' => 'missing fields',
     *   'missing' => array('email', ...)
     * ]
     * Some form fields are missing (the list of missing fields is sent).
     *
     * [
     *   'ok' => false,
     *   'error' => 'invalid fields',
     *   'invalid' => array('email', ...)
     * ]
     * Some form fields are invalid (the list of invalid fields is sent).
     * If the captcha is invalid, a new captcha is also sent.
     */

    if(
      (
        // The session may have expired since the form was created.
        empty($_SESSION['form_id']) ||
        empty($_SESSION['mq']) ||
        empty($_SESSION['started'])
      ) ||
        // The form may have been filled by a bot (in less than 2 seconds).
        time() - $_SESSION['started'] < 2
    ) {
      session_destroy();

      $response->write(
        json_encode(array(
          'ok' => false,
          'error' => 'session expired'
        ))
      );

      return;
    }

    $fields = array('form_id', 'name', 'email', 'message', 'mq');

    $missing = Post::collect_missing_fields($fields);
    $data = $request->post();

    // Some form fields may be missing.
    if(count($missing) > 0) {
      $response->write(
        json_encode(array(
          'ok' => false,
          'error' => 'missing fields',
          'missing' => $missing
        ))
      );

      return;
    }

    $invalid = array();

    // Some form fields may be invalid.

    // The email address may be unproperly formatted (basic check: is there a @?).
    $email_regex = '/^[^@]*@[^@]*$/';

    if(preg_match($email_regex, $data['email']) != 1) {
      $invalid[] = 'email';
    }

    // The captcha may be incorrect.
    if(strcmp($data['mq'], $_SESSION['mq']) != 0) {
      $captcha = new MathCaptcha();
      $_SESSION['mq'] = $captcha->get_answer();

      $invalid[] = 'mq';
      $invalid['mq'] = $captcha->get_image();
    }

    if(count($invalid) > 0) {
      $response->write(
        json_encode(array(
          'ok' => false,
          'error' => 'invalid fields',
          'invalid' => $invalid
        ))
      );

      return;
    }

    // All ok, we send the message.
    session_destroy();
    unset($_SESSION['form_id']);
    unset($_SESSION['mq']);
    unset($_SESSION['started']);

    $title = 'New message from ' . $data['name'];

    $message = "name: " . $data['name'] .
      "\nemail: " . $data['email'] . "\n" .
      "\n\n" . $data['message'] . "\n";

    // HTML version of the message
    $html = "<strong>Name</strong>: " . $data['name'] . "<br />" .
      "<br /><strong>Email address</strong>: " . $data['email'] . "<br />" .
      "<br /><br />" . $data['message'] . "<br />";

    $sent = Email::send(
      $data['email'],
      $config['owner'],
      $title,
      $message,
      $html
    );

    if(!$sent) {
      $response->write(
        json_encode(array(
          'ok' => false,
          'error' => 'server'
        ))
      );
    } else {
      $response->write(
        json_encode(array(
          'ok' => true
        ))
      );
    }
  }

}


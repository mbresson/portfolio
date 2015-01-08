<?php
assert(defined('ROOT'));


/*******************************
             CLASS
*******************************/

class Post {

  /*
   * @param array $fields
   * The list of all mandatory fields (identified by their name).
   *
   * @return array
   * The list of missing fields, or NULL on success.
   */
  public static function collect_missing_fields($fields) {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $data = $request->post();
    $missing = array();

    foreach($fields as $field) {
      if(empty($data[$field])) {
        $missing[] = $field;
      }
    }

    return $missing;
  }

}


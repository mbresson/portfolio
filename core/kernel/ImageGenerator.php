<?php
assert(defined('ROOT'));


/*******************************
             CLASS
*******************************/

class ImageGenerator {

  /**
   * @param string $text
   *
   * @param array $color
   * The color of the text when drawn.
   *
   * @return string
   * The content of the PNG generated to display the text, stored in base 64
   * or NULL on failure.
   *
   * This function requires php-gd extension.
   */
  public static function create_from_text($text, $color = array(255, 255, 255)) {
    if(!is_array($color) || count($color != 3)) {
      $color = array(255, 255, 255);
    }

    $font = 5; // php-gd built-in font

    $width = imagefontwidth($font) * strlen($text);
    $height = imagefontheight($font);

    $img = imagecreate($width, $height);

    if($img === false) {
      return NULL;
    }

    $background = imagecolorallocate($img, 150, 150, 150);
    $text_color = imagecolorallocate($img, $color[0], $color[1], $color[2]);

    imagecolortransparent($img, $background);
    imagestring($img, $font, 0, 0, $text, $text_color);

    ob_start();
    imagepng($img);
    $png = ob_get_contents();
    ob_end_clean();

    imagedestroy($img);

    return base64_encode($png);
  }

}


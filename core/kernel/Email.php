<?php
assert(defined('ROOT'));


/*******************************
             CLASS
*******************************/

class Email {

  /*
   * @retval bool
   *
   * @param string $from
   * @param string $to
   * @param string $title
   * @param string $message
   * @param string $html
   */
  public static function send($from, $to, $title, $message, $html) {
    $mail = new \PHPMailer;
    $mail->CharSet = "UTF-8";

    $mail->isSendmail();

    $mail->From = $from;
    $mail->addAddress($to);

    $mail->WordWrap = 50;
    $mail->isHTML(true);

    $mail->Subject = $title;
    $mail->Body = $html;
    $mail->AltBody = $message;

    return $mail->send();
  }

}


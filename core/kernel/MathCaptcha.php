<?php
assert(defined('ROOT'));


/*******************************
         DEPENDENCIES
*******************************/

require_once 'ImageGenerator.php';


/*******************************
             CLASS
*******************************/

// this class is used to generate a math question and its answer
// to protect forms against bots
class MathCaptcha {

  private $answer = 0;
  private $image = "";

  private static $operators = ['+', '-', 'x', '/'];

  /**
   * @param int $left_operand
   *
   * @param int $right_operand
   *
   * @param string $operator
   * '+', '-', 'x' or '/'
   *
   * @return int
   */
  private static function compute_answer($left_operand, $right_operand, $operator) {
    switch($operator) {
      case '+': return $left_operand + $right_operand;
      case '-': return $left_operand - $right_operand;
      case 'x': return $left_operand * $right_operand;
      case '/': return $left_operand / $right_operand;
      default: return 0;
    }
  }

  /**
   * @return int
   */
  public function get_answer() {
    return $this->answer;
  }

  /**
   * @return string
   */
  public function get_image() {
    return $this->image;
  }

  public function __construct() {
    // select a random operator
    $operator_index = mt_rand(0, count(MathCaptcha::$operators) - 1);
    $operator = MathCaptcha::$operators[$operator_index];

    $left_operand = 0;
    $right_operand = 0;

    // generate the operands
    switch($operator) {
      case '+':
        $left_operand = mt_rand(0, 1000);
        $right_operand = mt_rand(0, 1000);
        break;

      case '-':
        // it must be an easy subtraction: no negative result and choose easy numbers
        $left_operand = mt_rand(0, 100);
        $right_operand = mt_rand(0, $left_operand);
        break;

      case 'x':
        $left_operand = mt_rand(1, 10);
        $right_operand = mt_rand(1, 10);
        break;

      case '/':
        // the quotient must be an integer number to keep the division easy to compute for a human
        $right_operand = mt_rand(1, 10);
        $left_operand = mt_rand(1, 10) * $right_operand;
        break;
    }

    // compute the answer
    $this->answer = MathCaptcha::compute_answer($left_operand, $right_operand, $operator);

    // generate a base 64 PNG image
    $this->image = ImageGenerator::create_from_text($left_operand . $operator . $right_operand);
  }

}


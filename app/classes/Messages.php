<?php
/**
 * Used for handling server-user messages.
 */
class Messages
{
  /**
   * Displays Message View component.
   */
  public static function printMessage() {
    require __DIR__."/../views/components/message.view.php";
    self::unsetMessage();
  }

  /**
   * Prepares a message to be outputted.
   *
   * @param String $type Output style.
   * @param String $text Message content.
   */
  public static function setMessage($type, $text) {
    self::setMessageType($type);
    $_SESSION["message"]["text"] = $text;
  }

  /**
   * Sets the style of the output.
   *
   * @param String $type Output style.
   */
  private static function setMessageType($type) {
    switch($type) {
      case "success":
        $_SESSION["message"]["type"] = "alert-success";
      break;
      case "error":
      $_SESSION["message"]["type"] = "alert-danger";
      break;
      case "info":
      $_SESSION["message"]["type"] = "alert-primary";
      break;
    }
  }

  /**
   * Tells if the message session variable is set.
   *
   * @return Boolean
   */
  public static function issetMessage() {
    if(!empty($_SESSION["message"])) {
      return true;
    }
    return false;
  }

  /**
   * Unsets the message session variable.
   */
  public static function unsetMessage() {
    unset($_SESSION["message"]);
  }
}

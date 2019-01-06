<?php
abstract class Controller
{
  protected $action;
  protected $params;

  /**
   * Calls a method defined in the request.
   *
   * @param String $action Method belonging to this Controller.
   * @param Array $params Additional parameters.
   */
  public function __construct($action, $params) {
    $this->action = $action;
    if(count($params) <= 1) {
      $params = array_shift($params);
    }
    $this->params = $params;
    // $this->$action($params);
  }

  /**
   * Displays a proper View.
   *
   * @param  Boolean $mainView A flag indicating if the main view should be displayed.
   * @param  String $customView Name (or short path) of the custom view file.
   */
  protected function displayView($customView = null) {
    if($customView === null) {
      $dir = preg_replace("#Controller$#", "", get_class($this));
      $dir = strtolower($dir);
      $view = __DIR__."/../views/".$dir."/".$this->action.".view.php";
    }
    else {
      $customView = explode("/", $customView);
      if(count($customView) > 1) {
        $dir = array_shift($customView);
      }
      else {
        $dir = preg_replace("#Controller$#", "", get_class($this));
        $dir = strtolower($dir);
      }
      $customView = array_pop($customView);
      $view = __DIR__."/../views/".$dir."/".$customView.".view.php";
    }
    require __DIR__."/../views/components/nav.view.php";
    require $view;
  }

  /**
   * Assures that the User is logged in.
   */
  protected function loggedIn() {
    if(!isset($_SESSION['authorized'])) {
      header('Location: '.ROOT_URL.'/users/login');
      exit;
    }
    else return true;
  }

  /**
   * Assures that the User is logged out.
   */
  protected function loggedOut() {
    if(isset($_SESSION['authorized'])) {
      header('Location: '.ROOT_URL.'/shares/index');
      exit;
    }
    else return true;
  }
}

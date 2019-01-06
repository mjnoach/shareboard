<?php
/**
 * Parses the request URL and instantiates a proper Controller.
 */
class Router
{
  // Defaults
  private $controller = "HomeController";
  private $action = "home";
  private $params = array();

  private $request = array();

  /**
   * Parses URL.
   *
   * @param String $url Request URL.
   */
  public function __construct($uri) {
    $uri = trim($uri, "/");
    $request = explode("/", $uri);

    $controller = array_shift($request);
    if(!$controller == null) {
      $this->controller = $controller."Controller";
    }

    $action = array_shift($request);
    if(!$action == null) {
      $this->action = $action;
    }

    $this->params = $request;
  }

  /**
   * Instantiates a Controller.
   *
   * @return Controller
   */
  public function route() {
    if(!class_exists($this->controller)) {
      $this->error();
    }
    if(!method_exists($this->controller, $this->action)) {
      $this->error();
    }
    return new $this->controller($this->action, $this->params);
  }

  /**
   * Displays an error page when the request does not match any controllers or its methods.
   */
  private function error() {
    require __DIR__."/views/components/404.view.php";
    exit;
  }
}

<?php
/**
 * Default controller.
 */
class HomeController extends Controller
{
  public function __construct($action, $params) {
    parent::__construct($action, $params);
    $this->$action($this->params);
  }

  /**
   * Displays main home page.
   */
  protected function home() {
    $this->displayView();
  }
}

<?php
class SharesController extends Controller
{
  public function __construct($action, $params) {
    parent::__construct($action, $params);
    if($this->loggedIn()) {
      $this->$action($this->params);
    }
  }

  protected function deleteComment() {
    if(!isset($_POST['commentId'])) {
      header('Location: '.ROOT_URL.'/shares/index');
      exit;
    }
    $this->model = new SharesModel();
    $this->model->deleteComment();
  }

  protected function comment() {
  if(!isset($_POST['text'])) {
    header('Location: '.ROOT_URL.'/shares/index');
    exit;
  }
    $this->model = new SharesModel();
    $this->model->comment();
  }

  protected function dislike() {
    $this->model = new SharesModel();
    $this->model->dislike();
  }

  protected function delete() {
    $this->model = new SharesModel();
    $this->model->delete();
  }

  protected function like() {
    $this->model = new SharesModel();
    $this->model->like();
  }

  protected function one($share = null) {
    if($share == null) {
      header('Location: '.ROOT_URL.'/shares/index');
      exit;
    }
    $this->model = new SharesModel();
    if($this->model->one($share) === false) {
      $this->displayView("components/404");
    }
    else {
      $this->displayView();
    }
  }

  protected function index($page = null) {
    if($page == null) $page = 1;
    $this->model = new SharesModel();
    $this->displayView($this->model->index($page));
  }

  protected function add() {
    $this->model = new SharesModel();
    $this->displayView($this->model->add());
  }
}

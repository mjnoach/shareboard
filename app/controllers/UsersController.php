<?php
/**
 * Manages user-specific functionality.
 */
class UsersController extends Controller
{
  protected $guestOnlyAccess = array('login', 'register');

  public function __construct($action, $params) {
    parent::__construct($action, $params);
    // Logged-out-users-only access
    if(in_array($this->action, $this->guestOnlyAccess) && $this->loggedOut()) {
      $this->$action($this->params);
    }
    // Logged-in-users-only access
    else if($this->loggedIn()) {
      $this->$action($this->params);
    }
  }

  /**
   * AJAX.
   * Upload new profile picture.
   */
  protected function upload_profile_pic() {
    $this->model = new UsersModel();
    $this->model->upload_profile_pic();
  }

  /**
   * AJAX.
   * Modify the About section in User's profile.
   */
  protected function about() {
    $this->model = new UsersModel();
    $this->model->about();
  }

  /**
   * Delete User's profile.
   */
  protected function delete() {
    $this->model = new UsersModel();
    $this->model->delete();
    $this->displayView();
  }

  protected function profile($userId = null) {
    $this->model = new UsersModel();
    if($userId == null || $userId == $_SESSION['user']['id']) {
      $this->model->myProfile();
      $this->displayView('myProfile');
    }
    else {
      if($this->model->profile($userId) === false) {
        $this->displayView("components/404");
      }
      else {
        $this->displayView();
      }
    }
  }

  protected function logout() {
    $_SESSION = [];
    session_destroy();
    header('Location: '.ROOT_URL);
  }

  protected function login() {
    $this->model = new UsersModel();
    $this->displayView($this->model->login());
  }

  protected function register() {
    $this->model = new UsersModel();
    $this->displayView($this->model->register());
  }
}

<?php
class UsersModel extends Model
{
  public function upload_profile_pic() {
    $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    if(isset($_POST["profilePicSubmit"])) {
      if(getimagesize($_FILES["file"]["tmp_name"]) !== false) {
        if ($_FILES["file"]["size"] <= 100000) {
          if($extension != "jpg" && $extension != "png" && $extension != "jpeg") {
            Messages::setMessage('error', 'Only JPG, JPEG & PNG files are allowed.');
            header("Location: ".ROOT_URL."/users/profile");
            exit;
          }
          else {
            $file = "id-".$_SESSION["user"]['id'].".".$extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], "assets/img/uploads/".$file);
            $_SESSION["user"]["profile_pic"] = ROOT_URL."/assets/img/uploads/".$file;

            $query = "UPDATE users
                      SET profile_pic = 1
                      WHERE id = :user_id";
            $this->prepare($query);
            $this->bind(":user_id", $_SESSION["user"]['id']);
            $this->execute();

            header("Location: ".ROOT_URL."/users/profile");
            exit;
          }
        }
        else {
          Messages::setMessage('error', 'Size limit for a file is 100 KB');
          header("Location: ".ROOT_URL."/users/profile");
          exit;
        }
      } else {
        Messages::setMessage('error', 'Invalid file format');
        header("Location: ".ROOT_URL."/users/profile");
        exit;
      }
    }
  }

  public function about() {
    if($data = $this->aboutValidate($_POST)) {
      $query = "UPDATE users
                SET about = :about
                WHERE id = :user_id";
      $this->prepare($query);
      $this->bind(":about", $data["aboutContent"]);
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->execute();
      $_SESSION["user"]["about"] = $data["aboutContent"];
      echo $data["aboutContent"];
    }
    return false;
  }

  protected function aboutValidate($post) {
    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // About text validation
    $data["aboutContent"] = trim($data["aboutContent"]);
    if(strlen($data["aboutContent"]) > 500) {
      Messages::setMessage("error", "Your 'About' description is too long");
    }
    // Check if input is valid
    if(Messages::issetMessage()) {
      return false;
    }
    return $data;
  }

  public function delete() {
    if(isset($_POST["delSubmit"])) {
      $query = "SELECT password
                FROM users
                WHERE id = :user_id";
      $this->prepare($query);
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->execute();
      $password = $this->fetch()["password"];
      if(password_verify($_POST["passwordDel"], $password)) {
        $query = "DELETE FROM users
                  WHERE id = :user_id;
                  DELETE FROM shares
                  WHERE user_id = :user_id";
        $this->prepare($query);
        $this->bind(":user_id", $_SESSION["user"]["id"]);
        $this->execute();
        // Deletes User's profile picture
        $fileName = "id-".$_SESSION["user"]['id'];
        unlink("assets/img/uploads/".$fileName);
        // Log out
        header("Location: ".ROOT_URL."/users/logout");
        exit;
      }
      else {
        Messages::setMessage("error", "Incorrect password");
      }
    }
    header("Location: ".ROOT_URL."/users/profile");
    exit;
  }

  /**
   * Logged User's profile.
   */
  public function myProfile() {
    // Fetch published shares
    $query = "SELECT *
              FROM shares
              WHERE user_id = :user_id
              ORDER BY create_date DESC";
    $this->prepare($query);
    $this->bind(":user_id", $_SESSION["user"]["id"]);
    $this->execute();
    $publishedShares = $this->fetchAll();
    $_SESSION["user"]["publishedShares"] = $publishedShares;
    // On occasion updates published_shares column @ users
    // Clears the column's data from deleted shares id's
    $published_shares = ",";
    foreach($publishedShares as $row) {
      $published_shares .= $row["id"].",";
    }
    $query = "UPDATE users
              SET published_shares = :published_shares
              WHERE id = :user_id";
    $this->prepare($query);
    $this->bind(":published_shares", $published_shares);
    $this->bind(":user_id", $_SESSION["user"]["id"]);
    $this->execute();

    // Gets lilked shares
    $likedSharesArray = explode(",", $_SESSION["user"]["liked_shares"]);
    $likedSharesArray = array_map("intval", $likedSharesArray);
    array_shift($likedSharesArray);
    array_pop($likedSharesArray);
    if(count($likedSharesArray) > 0) {
      $parameterMarkers = (str_repeat("?,", count($likedSharesArray) - 1))."?";
      $query = "SELECT *
                FROM shares
                WHERE id IN ($parameterMarkers)
                ORDER BY create_date DESC";
      $this->prepare($query);
      $this->execute($likedSharesArray);
      $likedShares = $this->fetchAll();
      $_SESSION["user"]["likedShares"] = $likedShares;
      // On occasion updates liked_shares column @ users
      // Clears the column data from deleted shares id's
      $liked_shares = ",";
      foreach($likedShares as $row) {
        $liked_shares .= $row["id"].",";
      }
      $query = "UPDATE users
                SET liked_shares = :liked_shares
                WHERE id = :user_id";
      $this->prepare($query);
      $this->bind(":liked_shares", $liked_shares);
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->execute();
    }
  }

  /**
   * Another user's profile.
   *
   * @param String $userId Database id of the requested user.
   */
  public function profile($userId) {
    // Fetch Some User's data.
    $query = "SELECT *
              FROM users
              WHERE id = :id";
    $this->prepare($query);
    $this->bind(":id", $userId);
    $this->execute();
    $someUser = $this->fetch();
    if($someUser) {
      $_SESSION["someUser"] = $someUser;
      if($someUser["profile_pic"] == 0) {
        // Default profile picture.
        $file = 'default'.$this->getPicutreExtension('default');
        $_SESSION["someUser"]["profile_pic"] = ROOT_URL."/assets/img/uploads/".$file;
      }
      else {
        // Custom profile picture.
        $file = 'id-'.$someUser["id"];
        $file .= $this->getPicutreExtension('id-'.$someUser["id"]);
        $_SESSION["someUser"]["profile_pic"] = ROOT_URL."/assets/img/uploads/".$file;
      }
    }
    else {
      // The requested user does not exist.
      return false;
    }
    // Fetch Some User's posted shares.
    $query = "SELECT *
              FROM shares
              WHERE user_id = :user_id
              ORDER BY create_date DESC";
    $this->prepare($query);
    $this->bind(":user_id", $userId);
    $this->execute();
    $publishedShares = $this->fetchAll();
    $_SESSION["someUser"]["publishedShares"] = $publishedShares;
  }

  /**
   * Authorize User.
   */
  public function login() {
    if(isset($_POST["logSubmit"]) && ($logData = $this->logDataValid())) {
      // $logData = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $query = "SELECT *
                FROM users
                WHERE email = :email";
      $this->prepare($query);
      $this->bind(":email", $logData["email"]);
      $this->execute();
      if($user = $this->fetch()) {
        if(password_verify($logData["password"], $user["password"])) {
          $_SESSION["authorized"] = true;
          $_SESSION["user"]["id"] = $user["id"];
          $_SESSION["user"]["name"] = $user["name"];
          $_SESSION["user"]["email"] = $user["email"];
          $_SESSION["user"]["published_shares"] = $user["published_shares"];
          $_SESSION["user"]["liked_shares"] = $user["liked_shares"];
          $_SESSION["user"]["about"] = $user["about"];
          if($user["profile_pic"] == 0) {
            // Default profile picture
            $file = 'default'.$this->getPicutreExtension('default');
            $_SESSION["user"]["profile_pic"] = ROOT_URL."/assets/img/uploads/".$file;
          }
          else {
            // Custom profile picture
            $file = 'id-'.$user["id"];
            $file .= $this->getPicutreExtension('id-'.$user["id"]);
            $_SESSION["user"]["profile_pic"] = ROOT_URL."/assets/img/uploads/".$file;
          }
          unset($_SESSION["logForm"]);
          header("Location: ".ROOT_URL."/shares/index");
          exit;
        }
      }
      $_SESSION["logForm"]["email"] = $logData["email"];
      Messages::setMessage("error", "Incorrect login and/or password.");
    }
  }

  /**
   * Validates User's login form input.
   */
  protected function logDataValid() {
    $logData = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if($logData["email"] == "" || $logData["password"] == "") {
      Messages::setMessage("error", "Input fields cannot be empty.");
      return false;
    }
    return $logData;
  }

  /**
   * Registers a new User.
   */
  public function register() {
    if(isset($_POST["regSubmit"]) && ($regData = $this->regDataValid())) {
      $regData["password"] = password_hash($regData["password"], PASSWORD_DEFAULT);
      $query = "INSERT INTO users (name, email, password, published_shares, liked_shares)
                VALUES (:name, :email, :password, ',', ',')";
      $this->prepare($query);
      $this->bind(":name", $regData["name"]);
      $this->bind(":email", $regData["email"]);
      $this->bind(":password", $regData["password"]);
      $this->execute();
      Messages::setMessage("success", "Registration successful!");
      unset($_SESSION["regForm"]);
      header("Location: ".ROOT_URL."/users/login");
      exit;
    }
  }

  /**
   * Validates User's registration form input.
   */
  protected function regDataValid() {
    // Removes tags and special characters
    $regData = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // Name validation
    if(strlen($regData["name"]) > 255) {
        $_SESSION["regErrors"]["name"] = "Your name is too long.";
    }
    else if($regData["name"] == "") {
      $_SESSION["regErrors"]["name"] = "Name field cannot be epmty.";
    }
    else if(preg_match("# +#", $regData["name"])) {
      $_SESSION["regErrors"]["name"] = "Whitespaces are not allowed.";
    }
    else {
      $_SESSION["regForm"]["name"] = $regData["name"];
    }
    // Email validation
    if(strlen($regData["email"]) > 255) {
        $_SESSION["regErrors"]["email"] = "Your email is too long.";
    }
    else if($regData["email"] == "") {
      $_SESSION["regErrors"]["email"] = "Email field cannot be empty.";
    }
    else if($this->emailIsTaken($regData["email"])) {
      $_SESSION["regErrors"]["email"] = "Account with that email already exists.";
    }
    else {
      $_SESSION["regForm"]["email"] = $regData["email"];
    }
    // Password validation
    if(strlen($regData["password"]) > 255) {
        $_SESSION["regErrors"]["password"] = "Your password is too long.";
    }
    else if($regData["password"] == "") {
      $_SESSION["regErrors"]["password"] = "Password field cannot be empty.";
    }
    // Checkbox validation
    if(!isset($regData["checkbox"])) {
      $_SESSION["regErrors"]["checkbox"] = "You must accept our terms and conditions.";
    }
    // Check if all input is valid
    if(!empty($_SESSION["regErrors"])) {
      return false;
    }
    return $regData;
  }

  protected function emailIsTaken($email) {
    $query = "SELECT COUNT(*)
              FROM users
              WHERE email = :email";
    $this->prepare($query);
    $this->bind(":email", $email);
    $this->execute();
    return ((int)$this->fetch()["COUNT(*)"] > 0);
  }
}

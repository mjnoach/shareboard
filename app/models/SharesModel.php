<?php
class SharesModel extends Model
{
  public function deleteComment() {
    if(empty($_POST)) {
      header("Location: ".ROOT_URL);
      exit;
    }
    $query = "DELETE FROM comments
              WHERE id = :comment_id";
    $this->prepare($query);
    $this->bind(":comment_id", $_POST['commentId']);
    $this->execute();

    $query = "UPDATE shares
              SET comment_count = comment_count-1
              WHERE id = :share_id";
    $this->prepare($query);
    $this->bind(":share_id", $_POST["shareId"]);
    $this->execute();

    $query = "SELECT comment_count
              FROM shares
              WHERE id = :share_id";
    $this->prepare($query);
    $this->bind(":share_id", $_POST["shareId"]);
    $this->execute();
    $comment_count = $this->fetch()['comment_count'];
    echo $comment_count;
  }

  public function comment() {
    if($data = $this->commentValidate($_POST)) {
      $query = "INSERT INTO comments (user_id, share_id, comment)
                VALUES (:user_id, :share_id, :comment)";
      $this->prepare($query);
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->bind(":share_id", $data["shareId"]);
      $this->bind(":comment", $data["text"]);
      $this->execute();
      $commentId = $this->dbh->lastInsertId();

      $query = "UPDATE shares
                SET comment_count = comment_count+1
                WHERE id = :share_id";
      $this->prepare($query);
      $this->bind(":share_id", $data["shareId"]);
      $this->execute();

      $query = "SELECT comment_count
                FROM shares
                WHERE id = :share_id";
      $this->prepare($query);
      $this->bind(":share_id", $data["shareId"]);
      $this->execute();
      $result = $this->fetch();
      $commentCount = $result["comment_count"];

      $query = "SELECT created_on
                FROM comments
                WHERE id = :comment_id";
      $this->prepare($query);
      $this->bind(":comment_id", $commentId);
      $this->execute();
      $result = $this->fetch();
      $createdOn = date_format(date_create($result["created_on"]), "j M Y, g:i a");

      $data = array(
        "commentId" => $commentId,
        "commentCount" => $commentCount,
        "date" => $createdOn,
        "text" => $data["text"],
        "userName" => $_SESSION["user"]["name"]
      );
      echo json_encode($data);
    }
  }

  protected function commentValidate($post) {
    $post["text"] = htmlentities($post["text"]);
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $post["text"] = trim($post["text"]);
    return $post;
  }

  public function dislike() {
    if(empty($_POST)) {
      header("Location: ".ROOT_URL);
      exit;
    }
    $shareId = $_POST["shareId"];
    $query = "SELECT liked_shares
              FROM users
              WHERE id = :user_id";
    $this->prepare($query);
    $this->bind(":user_id", $_SESSION["user"]["id"]);
    $this->execute();
    $results = array_shift($this->fetchAll());
    $likedShares = str_replace(",".$shareId.",", ",", $results["liked_shares"]);

    $query = "UPDATE users
              SET liked_shares = :liked_shares
              WHERE id = :user_id";
    $this->prepare($query);
    $this->bind(":liked_shares", $likedShares);
    $this->bind(":user_id", $_SESSION["user"]["id"]);
    $this->execute();
    $_SESSION["user"]["liked_shares"] = $likedShares;

    $query = "UPDATE shares
              SET like_count = like_count-1
              WHERE id = :share_id";
    $this->prepare($query);
    $this->bind(":share_id", $shareId);
    $this->execute();
  }

  public function delete() {
    if(empty($_POST)) {
      header("Location: ".ROOT_URL);
      exit;
    }
    $shareId = $_POST["shareId"];
    $query = "DELETE FROM shares
              WHERE id = :share_id";
    $this->prepare($query);
    $this->bind(":share_id", $shareId);
    $this->execute();
    if(strpos($_SHARES["user"]["liked_shares"], ",".$shareId.",")) {
      $this->dislike();
    }

    $query = "DELETE FROM comments
              WHERE share_id = :share_id";
    $this->prepare($query);
    $this->bind(":share_id", $shareId);
    $this->execute();
  }

  public function like() {
    if(empty($_POST)) {
      header("Location: ".ROOT_URL);
      exit;
    }
    $shareId = $_POST["shareId"];
    $isLiked = (boolean) $_POST["isLiked"];
    $likeCount = $_POST["likeCount"];
    $likedShares = $_SESSION["user"]["liked_shares"];

    if(!$isLiked) {
      $likedShares .= $shareId.",";

      $query = "UPDATE users
                SET liked_shares = :liked_shares
                WHERE id = :user_id";
      $this->prepare($query);
      $this->bind(":liked_shares", $likedShares);
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->execute();

      $isLiked = !$isLiked;
      $_SESSION["user"]["liked_shares"] = $likedShares;
    }
    else {
      $likedShares = str_replace((",".$shareId.","), ",", $likedShares);

      $query = "UPDATE users
                SET liked_shares = :liked_shares
                WHERE id = :user_id";
      $this->prepare($query);
      $this->bind(":liked_shares", $likedShares);
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->execute();

      $isLiked = !$isLiked;
      $_SESSION["user"]["liked_shares"] = $likedShares;
    }

    $query = "UPDATE shares
              SET like_count = :like_count
              WHERE id = :share_id";
    $this->prepare($query);
    $this->bind(":like_count", $likeCount);
    $this->bind(":share_id", $shareId);
    $this->execute();

    echo $likeCount;
  }

  public function getUserName($user_id) {
    $query = "SELECT name
              FROM users
              WHERE id = :user_id";
    $this->prepare($query);
    $this->bind(":user_id", $user_id);
    $this->execute();
    $result = $this->fetch();
    return $result["name"];
  }

  public function one($shareId) {
    $query = "SELECT *
              FROM shares
              WHERE id = :share_id";
    $this->prepare($query);
    $this->bind(":share_id", $shareId);
    $this->execute();
    $share = $this->fetch();
    if($share) {
      $_SESSION["share"] = $share;

      $query = "SELECT *
                FROM comments
                WHERE share_id = :share_id
                ORDER BY created_on DESC";
      $this->prepare($query);
      $this->bind(":share_id", $shareId);
      $this->execute();
      $comments = $this->fetchAll();
      $_SESSION["comments"] = $comments;
    }
    else {
      return false;
    }
  }

  public function index($page) {
    $sharesPerPage = 10;
    $lowerBound = ($page - 1) * $sharesPerPage;

    $query = "SELECT COUNT(*)
              FROM shares";
    $this->prepare($query);
    $this->execute();
    $numOfRecords = (int)$this->fetch()["COUNT(*)"];
    $numOfPages = (int)ceil($numOfRecords/$sharesPerPage);

    $query = "SELECT *
              FROM shares
              ORDER BY create_date DESC, id DESC
              LIMIT :sharesPerPage OFFSET :lowerBound";
    $this->prepare($query);
    $this->bindInt(":sharesPerPage", $sharesPerPage);
    $this->bindInt(":lowerBound", $lowerBound);
    $this->execute();
    $sharesList = $this->fetchAll();
    if(count($sharesList) > 0) {
      $_SESSION["shares"]["list"] = $sharesList;
      $_SESSION["shares"]["numOfRecords"] = $numOfRecords;
      $_SESSION["shares"]["numOfPages"] = $numOfPages;
      $_SESSION["shares"]["currentPage"] = $page;
      $_SESSION["shares"]["lowerBound"] = $lowerBound;
      $_SESSION["shares"]["sharesPerPage"] = $sharesPerPage;

      $sharesIds = array();
      foreach($sharesList as $share) {
        array_push($sharesIds, $share["id"]);
      }
      $parameterMarkers = (str_repeat("?,", count($sharesIds) - 1))."?";
      $query = "SELECT *
                FROM comments
                WHERE share_id IN ($parameterMarkers)
                ORDER BY created_on DESC, id DESC";
      $this->prepare($query);
      $this->execute($sharesIds);
      $comments = $this->fetchAll();
      $_SESSION["comments"] = $comments;
    }
    else {
      Messages::setMessage("info", "Be the first to share something!");
    }
  }

  public function add() {
    if($data = $this->addValidate($_POST)) {
      // Inserts new share to the database.
      $query = "INSERT INTO shares (user_id, title, body, like_count, comment_count)
                VALUES (:user_id, :title, :body, 0, 0)";
      $this->prepare($query);
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->bind(":title", $data["addShareTitle"]);
      $this->bind(":body", $data["addShareBody"]);
      $this->execute();
      // Updates User's published_shares column.
      $query = "UPDATE users
                SET published_shares = CONCAT(published_shares, :shareId)
                WHERE id = :user_id";
      $this->prepare($query);
      $this->bind(":shareId", $this->dbh->lastInsertId().",");
      $this->bind(":user_id", $_SESSION["user"]["id"]);
      $this->execute();
      Messages::setMessage("success", "Success! Your post has been added.");
      unset($_SESSION["addShareForm"]);
      header("Location: ".ROOT_URL."/shares/index");
      exit;
    }
  }

  protected function addValidate($post) {
    if(isset($post["addShareSubmit"])) {
      $data = $post;
      // $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Title validation
      $data["addShareTitle"] = strip_tags($data["addShareTitle"]);
      $data["addShareTitle"] = trim($data["addShareTitle"]);
      if(strlen($data["addShareTitle"]) > 255) {
        Messages::setMessage("error", "Title is too long");
      }
      else if($data["addShareTitle"] == "") {
        Messages::setMessage("error", "Title field cannot be empty");
      }
      else {
        $_SESSION["addShareForm"]["title"] = $data["addShareTitle"];
      }

      // Body validation
      $data["addShareBody"] = htmlentities($data["addShareBody"]);
      $data["addShareBody"] = trim($data["addShareBody"]);
      if(strlen($data["addShareBody"]) > 10000) {
        Messages::setMessage("error", "There is a limit of 10 000 characters per post");
      }
      else if($data["addShareBody"] == "") {
        Messages::setMessage("error", "Body of the post cannot be empty");
      }
      else {
        $_SESSION["addShareForm"]["body"] = $data["addShareBody"];
      }

      // Check if all input is valid
      if(!empty($_SESSION["message"])) {
        return false;
      }
      return $data;
    }
  }
}

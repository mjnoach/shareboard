<div id="sharesOneContainer" class="container-fluid">
  <div class="list-group">
    <?php
      $date = date_format(date_create($_SESSION['share']['create_date']), "j M Y, g:i a");
      $isLiked = (strpos($_SESSION['user']['liked_shares'], ','.$_SESSION['share']['id'].',') === false) ? 0 : 1;
    ?>
    <li id="share" class="list-group-item my-5" data-share-id="<?php echo $_SESSION['share']['id']; ?>">

      <div class="share-header">
        <p class="float-right"><small class="shareDate"><?php echo $date; ?></small></p>
        <h5 class="share-title mt-2"><?php echo $_SESSION['share']['title']; ?></h5>
      </div>

      <hr class="my-4">
      <p class="share-body text-justify">
        <?php echo $_SESSION['share']['body']; ?>
      </p>

      <hr class="my-4">
      <div class="share-footer mb-2">
        <div class="shareFooterLeft">
          <button class="bigLikeBtn likeBtn btn btn-outline-primary" data-share-id="<?php echo $_SESSION['share']['id']; ?>" data-is-liked="<?php echo $isLiked; ?>">Like</button>

          <i class="likesCounter icon-heart" style="color: <?php echo $isLiked ? '#007BFF' : ''; ?>" id="heart-icon-share-<?php echo $_SESSION['share']['id']; ?>">
            <div class="like-count d-inline-block" id="like-counter-share-<?php echo $_SESSION['share']['id']; ?>"> <?php echo $_SESSION['share']['like_count']; ?></div>
          </i>

          <i id="comment-icon-share-<?php echo $_SESSION['share']['id']; ?>" class="commentsCounter icon-comment">
            <div class="comment-count d-inline-block" id="comment-counter-share-<?php echo $_SESSION['share']['id']; ?>"> <?php echo $_SESSION['share']['comment_count']; ?></div>
          </i>

          <div class="smallShareFooter">
            <button class="smallLikeBtn likeBtn btn btn-outline-primary" data-share-id="<?php echo $_SESSION['share']['id']; ?>" data-is-liked="<?php echo $isLiked; ?>">Like</button>
          </div>
        </div>

        <div>
          <div class="shareFooterRight">
            <a href="<?php echo ROOT_URL; ?>/users/profile/<?php echo $_SESSION['share']['user_id']; ?>">
              <div class="profile-picture d-inline-block" style="background-image: url(
              <?php
                $file = 'id-'.$_SESSION['share']['user_id'];
                $file .= $this->model->getPicutreExtension($file);
                if(file_exists('assets/img/uploads/'.$file)) {
                  echo ROOT_URL.'/assets/img/uploads/'.$file;
                }
                else echo ROOT_URL.'/assets/img/uploads/default'.$this->model->getPicutreExtension('default');
              ?>)"></div>
            </a>
            <div class="ml-4 pull-right">
              <a href="<?php echo ROOT_URL; ?>/users/profile/<?php echo $_SESSION['share']['user_id']; ?>">
                <p class="mb-0"><?php echo $this->model->getUserName($_SESSION['share']['user_id']); ?></p>
              </a>
              <small class="shareAuthor">Author</small>
            </div>
          </div>
        </div>
      </div>

      <div id="commentPostBox" class="pt-4">
        <textarea id="commentInput" type="text" class="form-control" rows="3" placeholder="Write a comment..." style="resize: none"></textarea>
        <div id="commentMsg" class="invalid-feedback">
          Your comment is too long.
        </div>
        <button id="commentSubmit" class="btn btn-primary my-3 disabled" style="cursor: not-allowed">Post</button>
      </div>

      <div id="commentList" class="list-group">
        <div style="display: none" id="" class="comment">
          <div class="comment-wrapper pull-left p-2 m-2">
            <div class="comment-header">
              <p class="comment-date mt-2 mb-3"></p>
              <i class="icon-cancel-1 mr-2" data-comment-id="" data-share-id="<?php echo $_SESSION['share']['id'] ?>"></i>
            </div>
            <p class="comment-text"></p>
            <p class="comment-user-name blockquote-footer mt-2 mb-0">
              <a class="comment-profile-link" href="<?php echo ROOT_URL; ?>/users/profile/<?php echo $comment['user_id'] ?? "" ?>">
                <?php if (isset($comment['user_id'])) echo $this->model->getUserName($comment['user_id']) ?>
              </a>
            </p>
          </div>
        </div>

        <?php foreach($_SESSION['comments'] as $comment): ?>
        <?php $date = date_format(date_create($comment['created_on']), "j M Y, g:i a"); ?>
        <?php if($comment['share_id'] == $_SESSION['share']['id']): ?>
          <div id="comment-<?php echo $comment['id'] ?>" class="comment pull-left">
            <div class="comment-wrapper pull-left p-2 m-2">
              <div class="comment-header">
                <p class="comment-date mt-2 mb-3"><?php echo $date; ?></p>
                <?php if($comment['user_id'] == $_SESSION['user']['id']): ?>
                  <i class="icon-cancel-1 mr-2" data-comment-id="<?php echo $comment['id'] ?>" data-share-id="<?php echo $comment['share_id'] ?>"></i>
                <?php endif ?>
              </div>
              <p class="comment-text"><?php echo $comment['comment']; ?></p>
              <p class="comment-user-name blockquote-footer mt-2 mb-0">
                <?php $commentName = $this->model->getUserName($comment['user_id']) ?>
                <?php if(strlen($commentName)): ?>
                <a class="comment-profile-link" href="<?php echo ROOT_URL; ?>/users/profile/<?php echo $comment['user_id'] ?? "" ?>"><?php echo $commentName; ?></a>
                <?php else: ?>
                [account deleted]
                <?php endif; ?>
              </p>
            </div>
          </div>
        <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </li>
  </div>
</div>
<?php
unset($_SESSION['share']);
unset($_SESSION['comments']);
?>

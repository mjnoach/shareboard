<?php if($_SESSION['shares']['list']): ?>
  <?php
     $numOfRecords = $_SESSION['shares']['numOfRecords'];
     $numOfPages = $_SESSION['shares']['numOfPages'];
     $currentPage = $_SESSION['shares']['currentPage'];
     $lowerBound = $_SESSION['shares']['lowerBound'];
     $sharesPerPage = $_SESSION['shares']['sharesPerPage'];
  ?>
  <div id="sharesIndexContainer" class="container-fluid">
    <div class="my-5 text-center">
      <a class="bigBtn btn btn-outline-success btn-lg" href="<?php echo ROOT_URL; ?>/shares/add" role="button">Share something</a>
    </div>
    <div class="list-group">
      <?php foreach($_SESSION['shares']['list'] as $share): ?>
        <?php
          $date = date_format(date_create($share['create_date']), "j M Y, g:i a");
          $isLiked = (strpos($_SESSION['user']['liked_shares'], ','.$share['id'].',') === false) ? 0 : 1;
        ?>

        <li class="list-group-item mb-5">

          <div class="share-header">
            <p class="float-right"><small class="shareDate"><?php echo $date; ?></small></p>
            <h5 class="share-title mt-2">
              <a href="<?php echo ROOT_URL; ?>/shares/one/<?php echo $share['id']; ?>"><?php echo $share['title']; ?></a>
            </h5>
          </div>

          <hr class="my-4">
          <p class="share-body text-justify">
            <?php echo $share['body']; ?>
          </p>

          <hr class="my-4">
          <div class="share-footer mb-2">
            <div class="shareFooterLeft">
              <button class="bigLikeBtn likeBtn btn btn-outline-primary" data-share-id="<?php echo $share['id']; ?>" data-is-liked="<?php echo $isLiked; ?>">Like</button>

              <i class="likesCounter icon-heart" style="color: <?php echo $isLiked ? '#007BFF' : ''; ?>" id="heart-icon-share-<?php echo $share['id']; ?>">
                <div class="like-count d-inline-block" id="like-counter-share-<?php echo $share['id']; ?>"> <?php echo $share['like_count']; ?></div>
              </i>

              <button id="index-comments-btn" class="bigCommentsBtn commentsBtn btn btn-outline-secondary" data-toggle="collapse" data-target="#comment-box-<?php echo $share['id']; ?>" aria-expanded="false" aria-controls="comment-box-<?php echo $share['id']; ?>">Comments</button>

              <i id="comment-icon-share-<?php echo $share['id']; ?>" class="commentsCounter icon-comment">
                <div class="comment-count d-inline-block" id="comment-counter-share-<?php echo $share['id']; ?>"> <?php echo $share['comment_count']; ?></div>
              </i>

              <div class="smallShareFooter">
                <button class="smallLikeBtn likeBtn btn btn-outline-primary" data-share-id="<?php echo $share['id']; ?>" data-is-liked="<?php echo $isLiked; ?>">Like</button>
                <button class="smallCommentsBtn commentsBtn btn btn-outline-secondary" data-toggle="collapse" data-target="#comment-box-<?php echo $share['id']; ?>" aria-expanded="false" aria-controls="comment-box-<?php echo $share['id']; ?>">Comments</button>
              </div>
            </div>

            <div>
              <div class="shareFooterRight">
                <a href="<?php echo ROOT_URL; ?>/users/profile/<?php echo $share['user_id']; ?>">
                  <div class="profile-picture d-inline-block" style="background-image: url(
                  <?php
                    $file = 'id-'.$share['user_id'];
                    $file .= $this->model->getPicutreExtension($file);
                    if(file_exists('assets/img/uploads/'.$file)) {
                      echo ROOT_URL.'/assets/img/uploads/'.$file;
                    }
                    else echo ROOT_URL.'/assets/img/uploads/default'.$this->model->getPicutreExtension('default');
                  ?>)"></div>
                </a>
                <div class="ml-4 pull-right">
                  <a href="<?php echo ROOT_URL; ?>/users/profile/<?php echo $share['user_id']; ?>">
                    <p class="mb-0"><?php echo $this->model->getUserName($share['user_id']); ?></p>
                  </a>
                  <small class="shareAuthor">Author</small>
                </div>
              </div>
            </div>
          </div>

          <div id="comment-box-<?php echo $share['id']; ?>" class="commentBox collapse">
            <div id="commentList" class="list-group">
              <?php foreach($_SESSION['comments'] as $comment): ?>
              <?php if($comment['share_id'] == $share['id']): ?>
                <div class="comment pull-left">
                  <div class="comment-wrapper comment-text pull-left p-2 m-2">
                    <p class="comment-date mt-2 mb-3"><?php echo $comment['created_on']; ?></p>
                    <p class="comment-text"><?php echo $comment['comment']; ?></p>
                    <p class="comment-user-name blockquote-footer mt-2 mb-0">
                      <?php $commentName = $this->model->getUserName($comment['user_id']) ?>
                      <?php if(strlen($commentName)): ?>
                      <a class="comment-profile-link" href="<?php echo ROOT_URL; ?>/users/profile/<?php echo $comment['user_id']; ?>"><?php echo $commentName; ?></a>
                      <?php else: ?>
                      [account deleted]
                      <?php endif; ?>
                    </p>
                  </div>
                </div>
              <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>

      <?php if($numOfPages > 1): ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center mb-3">
            <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
              <a class="page-link" href="<?php echo ROOT_URL; ?>/shares/index/<?php echo $currentPage-1; ?>" tabindex="-1">Previous</a>
            </li>
            <?php for($i=1; $i<=$numOfPages; $i++): ?>
              <li class="page-item <?php echo ($currentPage  == $i) ? 'active' : ''; ?>"><a class="page-link" href="<?php echo ROOT_URL ?>/shares/index/<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <li class="page-item <?php echo ($currentPage == $numOfPages) ? 'disabled' : ''; ?>">
              <a class="page-link" href="<?php echo ROOT_URL; ?>/shares/index/<?php echo $currentPage+1; ?>">Next</a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>

      <small class="mb-5" style="margin: auto">Displaying <?php echo ($lowerBound+1).' - ';
      echo ($upperBound = $lowerBound+$sharesPerPage) > $numOfRecords ? $numOfRecords : $upperBound ?> out of <?php echo $numOfRecords; ?></small>

    </div>
  </div>
<?php endif; ?>

<?php
unset($_SESSION['shares']['list']);
unset($_SESSION['comments']);
?>

<div id="profileContainer" class="container-fluid mt-5">

  <!-- LEFT PANEL -->
  <div id="profileLeftPanel">
    <div class="card">
      <div id="profilePic" data-toggle="modal" data-target="#profilePicModal">
        <div class="edit-wrapper">
          <img class="edit-fade" src="<?php echo $_SESSION['user']['profile_pic'] ?>" alt="[profile picture]">
          <i class="icon-camera edit-icon"></i>
        </div>
      </div>
      <div id="profileInfo">
        <h4 id="profileName"><?php echo $_SESSION['user']['name'] ?></h4>
        <div id="profileAbout" data-toggle="modal" data-target="#aboutModal">
          <div class="edit-wrapper">
            <div id="profileAboutText" class="edit-fade">
              <?php echo $_SESSION['user']['about'] ?>
            </div>
            <i class="icon-pencil-1 edit-icon"></i>
          </div>
        </div>

        <div id="profileEmail"><?php echo $_SESSION['user']['email']; ?></div>
        <div id="profileDelete">
          <a href="#" class="card-link danger" data-toggle="modal" data-target="#deleteModal">Delete account</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Upload profile pic -->
  <div id="profilePicModal" class="modal fade">
    <div class="modal-dialog">
      <form id="profilePicForm" class="file-upload" method="post" enctype="multipart/form-data" action="<?php echo ROOT_URL ?>/users/upload_profile_pic">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Upload a new profile picture</h5>
          </div>
          <div class="modal-body">
            <div class="custom-file form-group m-0">
              <input type="file" name="file" class="custom-file-input">
              <span id="fileName" class="custom-file-control form-control-file"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="profilePicSubmit" class="btn btn-outline-primary">Upload</button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close">Dismiss</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal: Update About contents -->
  <div id="aboutModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update your about info</h5>
        </div>
        <div class="modal-body">
          <div class="form-group m-0">
            <textarea id="aboutUpdate" class="form-control" name="aboutUpdate" rows="5" autofocus><?php echo $_SESSION['user']['about']; ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="aboutSubmit" class="btn btn-outline-primary">Update</button>
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Dismiss</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Delete account -->
  <div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete account</h5>
        </div>
        <form action="<?php echo ROOT_URL; ?>/users/delete" method="post">
        <div class="modal-body">
          <p>To confirm, please enter your password</p>
          <div class="form-group m-0">
            <input type="password" name="passwordDel" class="form-control" placeholder="Password">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="delSubmit" class="btn btn-outline-danger">Delete</button>
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Dismiss</button>
        </div>
      </form>
      </div>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div id="profileRightPanel" class="card">
      <div class="card-header pb-0">
        <nav class="nav nav-tabs">
          <a id="publishedShares-tab" class="nav-item nav-link active" data-toggle="tab" href="#publishedShares">My Shares</a>
          <a id="likedShares-tab" class="nav-item nav-link" data-toggle="tab" href="#likedShares">Liked Shares</a>
        </nav>
      </div>
      <div class="card-body">
        <div class="tab-content">
          <div id="publishedShares" class="tab-pane fade show active">

            <!-- Nothing posted yet -->
            <?php if(empty($_SESSION['user']['publishedShares'])): ?>
            <div class="lead text-center my-5">
              You haven't posted anything yet<br>
              <a class="bigBtn btn btn-outline-success btn-lg w-25 mt-5" href="<? echo ROOT_URL; ?>/shares/add" role="button">Share</a>
            </div>

            <!-- List of posted shares -->
            <?php else: ?>
              <?php foreach($_SESSION['user']['publishedShares'] as $item): ?>
              <div id="publishedShare-<?php echo $item['id']; ?>" class="card mb-3 collapse">
                <div class="card-body">
                  <h4 class="card-title">
                    <small>
                      <a href="<?php echo ROOT_URL; ?>/shares/one/<?php echo $item['id']; ?>"><?php echo $item['title']; ?></a>
                    </small>
                  </h4>
                  <p class="card-text">
                    <?php if(strlen($item['body']) > 200) {
                      $preview = explode(' ', substr($item['body'], 0, 200));
                      array_pop($preview);
                      echo implode(' ', $preview).'... '; ?>
                      <a href="<?php echo ROOT_URL; ?>/shares/one/<?php echo $item['id']; ?>"> Read more</a>
                    <?php } else echo $item['body']; ?>
                  </p>
                  <button class="btn btn-outline-danger pull-right delete-share-button" data-share-id="<?php echo $item['id']; ?>">Delete</button>
                </div>
              </div>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <!-- Liked Shares -->
          <div id="likedShares" class="tab-pane fade">

            <!-- Nothing liked yet -->
            <?php if(empty($_SESSION['user']['likedShares'])): ?>
            <p class="lead text-center my-5">
              You haven't liked anything yet<br>
              <a class="bigBtn btn btn-outline-primary btn-lg w-25 mt-5" href="<? echo ROOT_URL; ?>/shares/index" role="button">Explore</a>
            </p>

            <!-- List of liked shares -->
            <?php else: ?>
              <?php foreach($_SESSION['user']['likedShares'] as $item): ?>
              <div id="likedShare-<?php echo $item['id']; ?>" class="card mb-3 collapse">
                <div class="card-body">
                  <h4 class="card-title">
                    <small>
                      <a href="<?php echo ROOT_URL; ?>/shares/one/<?php echo $item['id']; ?>"><?php echo $item['title']; ?></a>
                    </small>
                  </h4>
                  <p class="card-text">
                    <?php if(strlen($item['body']) > 200) {
                      $preview = explode(' ', substr($item['body'], 0, 200));
                      array_pop($preview);
                      echo implode(' ', $preview).'... '; ?>
                      <a href="<?php echo ROOT_URL; ?>/shares/one/<?php echo $item['id']; ?>"> Read more</a>
                    <?php } else echo $item['body']; ?>
                  </p>
                  <button class="btn btn-outline-primary pull-right dislike-share-button" data-share-id="<?php echo $item['id']; ?>">Dislike</button>
                </div>
              </div>
            <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
  </div>
</div>

<?php unset($_SESSION['user']['publishedShares']); ?>
<?php unset($_SESSION['user']['likedShares']); ?>

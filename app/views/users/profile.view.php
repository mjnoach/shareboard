<div id="profileContainer" class="container-fluid mt-5">

  <!-- LEFT PANEL -->
  <div id="profileLeftPanel">
    <div class="card">
      <div id="profilePic">
        <img src="<?php echo $_SESSION['someUser']['profile_pic']; ?>" alt="[profile picture]">
      </div>
      <div id="profileInfo">
        <h4 id="profileName"><?php echo $_SESSION['someUser']['name']; ?></h4>
        <div id="profileAbout">
          <div id="profileAboutText">
            <?php echo $_SESSION['someUser']['about'] ?>
          </div>
        </div>
        <div id="profileEmail"><?php echo $_SESSION['someUser']['email']; ?></div>
      </div>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div id="profileRightPanel" class="card">
      <div class="card-header pb-0">
        <nav class="nav nav-tabs">
          <a id="publishedShares-tab" class="nav-item nav-link active" data-toggle="tab" href="#publishedShares">Published Shares</a>
        </nav>
      </div>
      <div class="card-body">
        <div class="tab-content">
          <div id="publishedShares" class="tab-pane fade show active">

            <!-- Nothing posted yet -->
            <?php if(empty($_SESSION['someUser']['publishedShares'])): ?>
            <div class="lead text-center my-5">
              This user has not posted anything<br>
              <a class="bigBtn btn btn-outline-primary btn-lg w-25 mt-5" href="<? echo ROOT_URL; ?>/shares/index" role="button">Explore</a>
            </div>

            <!-- List of posted shares -->
            <?php else: ?>
              <?php foreach($_SESSION['someUser']['publishedShares'] as $item): ?>
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

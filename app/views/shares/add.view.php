<div id="addShare" class="container mt-5">
  <h3 class="text-muted"><small>Add a new post</small></h3>
  <form action="<?php echo ROOT_URL."/shares/add"; ?>" method="post">
    <div class="form-group">

      <label for="title"></label>
      <input type="text" name="addShareTitle" class="form-control" placeholder="Title" value="<?php echo $_SESSION['addShareForm']['title'] ?? ""; ?>">

      <label for="body"></label>
      <textarea name="addShareBody" class="form-control" rows="10" placeholder="Write something..."
        ><?php echo $_SESSION['addShareForm']['body'] ?? "" ?></textarea>

    </div>
    <button type="submit" name="addShareSubmit" class="bigBtn btn btn-primary mr-2 mb-2" style="cursor: pointer">Post</button>
    <a href="<?= ROOT_URL ?>/shares/index" class="bigBtn btn btn-outline-secondary mb-2">Dismiss</a>
  </form>
</div>

<?php unset($_SESSION['addShareForm']) ?>

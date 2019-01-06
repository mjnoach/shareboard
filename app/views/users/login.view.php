<div class="container mt-5" style="max-width: 400px">
  <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">

    <!-- Email -->
    <div class="form-group">
      <label>Email address</label>
      <input type="email" name="email" class="form-control" placeholder="Enter email"
      value="<?php echo $_SESSION["logForm"]["email"] ?? "" ?>" tabindex="1">
    </div>

    <!-- Password -->
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" class="form-control" placeholder="Password"
      <?php echo isset($_SESSION["logForm"]) ? "autofocus" : "" ?> tabindex="1">
    </div>

    <!-- Submit -->
    <button type="submit" name="logSubmit" class="btn btn-primary mt-3" tabindex="1">Log in</button>
  </form>

  <!-- Test User information -->
  <?php require __DIR__."/../components/testingAccount.view.php"; ?>
</div>

<?php unset($_SESSION["logForm"]); ?>

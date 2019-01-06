<div class="container mt-5" style="max-width: 400px">
  <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">

    <!-- Name -->
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" class="form-control
      <?php echo isset($_SESSION["regErrors"]["name"]) ? "is-invalid" : "" ?>" placeholder="Enter name"
      value="<?php echo $_SESSION["regForm"]["name"] ?? "" ?>" tabindex="1">
      <div class="invalid-feedback"><?php echo $_SESSION["regErrors"]["name"] ?></div>
    </div>

    <!-- Email -->
    <div class="form-group">
      <label>Email address</label>
      <input type="email" name="email" class="form-control
      <?php echo isset($_SESSION["regErrors"]["email"]) ? "is-invalid" : "" ?>" placeholder="Enter email"
      value="<?php echo $_SESSION["regForm"]["email"] ?? "" ?>" tabindex="1">
      <div class="invalid-feedback"><?php echo $_SESSION["regErrors"]["email"] ?></div>
    </div>

    <!-- Password -->
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" class="form-control
      <?php echo isset($_SESSION["regErrors"]["password"]) ? "is-invalid" : "" ?>" placeholder="Password" tabindex="1">
      <div class="invalid-feedback"><?php echo $_SESSION["regErrors"]["password"] ?? "" ?></div>
    </div>

    <!-- Checkbox -->
    <div class="form-group ">
      <input id="regCheckbox" type="checkbox" name="checkbox" class="form-control mt-1 mr-3
      <?php echo isset($_SESSION["regErrors"]["checkbox"]) ? "is-invalid" : "" ?>" tabindex="1"
      style="height: auto; width: auto; float: left;">
      <label class="control-label mb-0" for="regCheckbox">I accept the <a href="#" style="text-decoration: underline;">terms and conditions</a></label>
      <div class="invalid-feedback" style="clear: both"><?php echo $_SESSION["regErrors"]["checkbox"]?></div>
    </div>

    <!-- Submit -->
    <button type="submit" name="regSubmit" class="btn btn-primary mt-3" tabindex="1">Register</button>
  </form>

  <!-- Test User information -->
  <?php require __DIR__."/../components/testingAccount.view.php"; ?>
</div>

<?php
  unset($_SESSION["regErrors"]);
  unset($_SESSION["regForm"]);
?>

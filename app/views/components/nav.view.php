<!DOCTYPE html>
<html>
  <head>
    <title>Shareboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL ?>/assets/fontello/css/fontello.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL ?>/assets/css/style.css">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo ROOT_URL ?>/assets/js/script.js"></script>

    <script type="text/javascript">
      var root_url = "<?php echo ROOT_URL; ?>";
    </script>
  </head>
  <body>

    <nav class="navbar navbar-light bg-light">

      <!-- Nav: left -->
      <div class="nav-left">
        <a class="navbar-brand ml-4 align-middle" href="<?php echo ROOT_URL; ?>">Shareboard</a>
        <a class="navbarItemLeft btn btn-outline-primary ml-4" style="line-height: 80%;"
        href="<?php echo ROOT_URL ?>/shares/index" role="button">Explore</a>
        <a class="navbarItemLeft btn btn-outline-success ml-4" style="line-height: 80%;"
        href="<?php echo ROOT_URL ?>/shares/add" role="button">Share</a>
      </div>

      <!-- Nav: right -->
      <div class="navbar-nav navbar-expand">
        <?php if(isset($_SESSION["authorized"])): ?>
        <span class="navGreeting nav-link disabled mr-5">Hello, <?php echo $_SESSION["user"]["name"] ?></span>
        <?php endif ?>
        <a class="navbarItemRight nav-link active mr-4"
        href="<?php echo ROOT_URL; echo isset($_SESSION["authorized"]) ? "/users/logout" : "/users/login" ?>">
        <?php echo isset($_SESSION["authorized"]) ? "Logout" : "Login"; ?></a>
        <a class="navbarItemRight nav-link active mr-4"
        href="<?php echo ROOT_URL; echo isset($_SESSION["authorized"]) ? "/users/profile" : "/users/register" ?>">
        <?php echo isset($_SESSION["authorized"]) ? "My Profile" : "Register" ?></a>

        <a id="smallMenuToggle" href="#"><span class="smallMenuToggle navbar-toggler-icon mr-3 "></span></a>
      </div>
    </nav>

    <div id="smallMenu">
      <a class="smallMenuItem nav-link active mr-4"
      href="<?php echo ROOT_URL; echo isset($_SESSION["authorized"]) ? "/users/profile" : "/users/register" ?>">
      <?php echo isset($_SESSION["authorized"]) ? "My Profile" : "Register" ?></a>
      <a class="smallMenuItem nav-link active mr-4"
      href="<?php echo ROOT_URL; echo isset($_SESSION["authorized"]) ? "/users/logout" : "/users/login" ?>">
      <?php echo isset($_SESSION["authorized"]) ? "Logout" : "Login"; ?></a>
    </div>

    <?php Messages::printMessage(); ?>

  </body>
</html>

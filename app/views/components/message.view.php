<?php if(isset($_SESSION["message"])): ?>
<div id="message" class="container col-md-6 mt-5" style="max-width: 400px">
  <?php $multiline = strpos($_SESSION["message"]["text"], "<br>") ?>
  <div class="<?php echo $multiline ? 'text-center' : 'text-center' ?> alert <?php echo $_SESSION["message"]["type"]; ?>">
    <?php echo $_SESSION["message"]["text"]; ?>
  </div>
</div>
<?php endif; ?>

<?php
$session = session();
?>
<?php if(!empty($session->get('errors'))) {
  $errors = $session->get('errors');?>
  <?php  if (!empty($errors)) : ?>
    <div class="error">
    	<?php foreach ($errors as $error) : ?>
    	  <p><?php echo $error ?></p>
    	<?php endforeach ?>
    </div>
  <?php  endif ?>
<?php } ?>
<?php $session->remove('errors'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<style><?php include 'indexStyle.css'; ?></style>
</head>
<body>

<head>
  <div class="header">
	  <h2>Media House</h2>
  </div>
</head>

<main>
<div class="content" class="flex-container">
  	<?php if ($session->get('success')) : ?>
      <div class="error success" >
      	<h3>
          <?php
          	echo session()->get('success');
          	$session->remove('success');
          ?>
      	</h3>
      </div>
  	<?php endif ?>
    <!-- logged in user information -->
    <?php  if (session()->get('username')) : ?>
    	<p>Welcome <strong><?php echo session()->get('username'); ?></strong></p>
      <p> <a href="/media" style="color: blue;">Media Page</a> </p>
      <p> <a href="/upload" style="color: blue;">Upload</a> </p>
    	<p> <a href="/logout?logout=1" style="color: red;">Logout</a> </p>
    <?php endif ?>
    <?php if (!$session->get('username')) : ?>
      	<p> <a href="/login" style="color: #FFFEE9;">Login</a> </p>
        <p> <a href="/register" style="color: #FFFEE9;">Register</a> </p>
    <?php endif ?>
</div>
</main>

<footer>

</footer>

</body>
</html>

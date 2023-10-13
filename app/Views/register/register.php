<?php
  $session = session();
  $errors = array()
 ?>
 <?php if(!empty($session->get('errors'))) {
   $errors = $session->get('errors');?>
 <?php $session->remove('errors'); }?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration System</title>
  <style><?php include 'styles.css'; ?></style>
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>

  <form method="post" action="register/register">
  	<?php include('errors.php'); ?>
    <label>No Special Characters In Username Or Password</label>
    <label></label>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1" minlength="6">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2" minlength="6">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login">Sign in</a>
  	</p>
  </form>
</body>
</html>

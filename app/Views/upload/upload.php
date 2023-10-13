<!DOCTYPE html>.
<?php helper('html'); ?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <?php echo link_tag('upload.css')?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Upload Form</title>
</head>

<body style="background-color: #4E3524;">
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">cs3337Project</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active" style="padding-top:1em;">
            <p> <a style="color: #a94442; font-weight: bold; padding-right: 1em;" href="/">Menu</a> </p>
          </li>
          <li class="nav-item" style="padding-top:1em;">
            <p> <a style="color: #a94442; font-weight: bold;" href="/logout?logout=1">logout</a> </p>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <main
    style="background-color: #ECB984; padding: 10em; min-height: 750px; margin-right:200px; margin-left:200px; margin-bottom:50px; border-radius:100px; border: 1px solid black;">
    <div
      style="background-color: #A8A676; text-align:center;  border: 1px solid black;">
      <div class="jumbotron" style = "background-color: #A8A676;">
        <h1 class="display-4">What would you like to upload?</h1>
        <hr class="my-4">
        <?php foreach ($errors as $error): ?>
        <li><?= esc($error) ?></li>
        <?php endforeach ?>
        <?= form_open_multipart('upload/upload') ?>
        <form class="form">
      <p style="font-weight:bold; font-size:20px">Please upload a file!</p>
      <input type="file" name="userfile" size="20">
      <br><br>
      <input type="submit" value="upload">
    </form>
        </p>
      </div>
    </div>
  </main>
</body>
</center>
</body>
</html>

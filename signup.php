<?php
  include_once('lib/functions.php');
  require_once('lib/config.php');
  $dashboard = new Dashboard(DBHOST,DBNAME,DBUSER,DBPASSWD);
  $conn= $dashboard->connect();
  $dashboard->cleansessions();
  session_start();
  ob_start();
  $dashboard->signup($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registo</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
      <form class="form-signin" role="form" method="post" >
        <h2 class="form-signin-heading">Registo</h2>
        <input type="text" class="form-control" placeholder="Email" name="username" required autofocus>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <input type="password" class="form-control" placeholder="Confirmar password" name="conf_password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Registar</button>
      </form>
      <?php $dashboard->err_msg(); ?>
    </div>
  </body>
</html>

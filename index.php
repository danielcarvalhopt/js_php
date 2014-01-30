<?php
  include_once('lib/simple_html_dom.php');
  include_once('lib/functions.php');
  require_once('lib/config.php');
  $dashboard = new Dashboard(DBHOST,DBNAME,DBUSER,DBPASSWD);
  $conn= $dashboard->connect();
  $dashboard->authcheck();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Index</title>

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

    <h2>Hey <?php echo $_SESSION['username'];?></h2><a href="login.php">[Logout]</a>
    <h3>Inserir ficheiro</h3>
    <?php $dashboard->clientfile($conn); ?>
    <form  method="post" enctype="multipart/form-data">
      <label for="file">Ficheiro:</label>
      <input type="file" name="file" id="file"><br>
      <input type="submit" name="submit" value="submit">
</form>
    <h3>Inserir manualmente</h3>
    <form role="form" method="post" action="<?php $dashboard->clientform($conn); ?>">
      <div class="row">
        <div class="col-xs-2">
          <input type="text" class="form-control" name="name" placeholder="Nome">
        </div>
        <div class="col-xs-3">
          <input type="text" class="form-control" name="phone" placeholder="Telemóvel">
        </div>
        <div class="col-xs-4">
          <input type="email" class="form-control" name="email" placeholder="Email">
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-4">
          <input type="text" class="form-control" name="address" placeholder="Morada">
        </div>
        <div class="col-xs-2">
          <input type="text" class="form-control" name="postal" placeholder="Código Postal">
        </div>
        <div class="col-xs-3">
          <input type="text" class="form-control" name="town" placeholder="Localidade">
        </div>
      </div>
      <hr>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <hr>
    <h3>Lista CLientes</h3>

    <table class="table table-striped">
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telemóvel</th>
        <th>Morada</th>
        <th>Cod Postal</th>
        <th>Localidade</th>
      </tr>
      <?php $dashboard->listaClientes($conn); ?>

    </table>


    </div>
  </body>
</html>


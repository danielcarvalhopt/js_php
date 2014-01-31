<?php
  require_once('lib/ParseHtml.php');
  require_once('lib/model_importacao.php');
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
    <script src="assets/js/bootstrap.js" type="text/javascript"></script>

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
    <a href="insereVisita.php"> [ Inserir Visita ]</a>
    <a href="insereDemo.php"> [ Inserir Demo ]</a>
    <a href="export.php"> [ Exportar CSV ]</a>

    <hr>
    <h3>Lista CLientes</h3>

    <form method="post">
      <input type="text" name="str">
      <select name="search">
        <option value="0">Nome</option>
        <option value="1">Código Postal</option>
        <option value="2">Telemóvel</option>
        <option value="3">Email</option>
      </select>
      <button type="submit" name="submit" value="submit">Procurar</button>
    </form>

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
      <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telemóvel</th>
        <th>Morada</th>
        <th>Cod Postal</th>
        <th>Localidade</th>
        <th>Opções</th>
      </tr>
      <?php $dashboard->listaClientes($conn); ?>
    </table>


    </div>
  </body>
</html>


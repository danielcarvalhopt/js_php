<?php
  ob_start();
  require_once('lib/ParseHtml.php');
  require_once('lib/model_importacao.php');
  include_once('lib/simple_html_dom.php');
  include_once('lib/functions.php');
  require_once('lib/config.php');

  $dashboard = new Dashboard(DBHOST,DBNAME,DBUSER,DBPASSWD);
  $conn= $dashboard->connect();
  $dashboard->authcheck();
  $cliente = $dashboard->listaCliente($conn);
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

    <h2>Hey <?php echo $_SESSION['username'];?></h2><a href="login.php">[Logout]</a><a href="index.php">[Voltar]</a>
    <h3>Ficha de Cliente</h3>

    <p>ID: <?php echo $cliente['id'];?></p>
    <p>Agente: <?php echo $cliente['Agente'];?></p>
    <p>Numero: <?php echo $cliente['Numero'];?></p>
    <p>Data1: <?php echo $cliente['Data1'];?></p>
    <p>Dia1: <?php echo $cliente['Dia1'];?></p>
    <p>Hora1: <?php echo $cliente['Hora1'];?></p>
    <p>Nome: <?php echo $cliente['Nome'];?></p>
    <p>Profissao: <?php echo $cliente['Profissao'];?></p>
    <p>Dnasc: <?php echo $cliente['Dnasc'];?></p>
    <p>Nome2: <?php echo $cliente['Nome2'];?></p>
    <p>EstCivil: <?php echo $cliente['EstCivil'];?></p>
    <p>Telemovel: <?php echo $cliente['Telemovel'];?></p>
    <p>OutTelef: <?php echo $cliente['OutTelef'];?></p>
    <p>Morada: <?php echo $cliente['Morada'];?></p>
    <p>CodPostal: <?php echo $cliente['CodPostal'];?></p>
    <p>Localidade: <?php echo $cliente['Localidade'];?></p>
    <p>Email: <?php echo $cliente['Email'];?></p>
    <p>Observacao: <?php echo $cliente['Observacao'];?></p>
    <p>TipoArquivo: <?php echo $cliente['TipoArquivo'];?></p>
    <p>DemoOrigem: <?php echo $cliente['DemoOrigem'];?></p>
    <p>Sugestao: <?php echo $cliente['Sugestao'];?></p>
    <p>SugestaoTipo: <?php echo $cliente['SugestaoTipo'];?></p>


    </div>
  </body>
</html>


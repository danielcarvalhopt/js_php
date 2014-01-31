<?php
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

    <title>Insere Visita</title>

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

    <h2>Hey <?php echo $_SESSION['username'];?></h2><a href="login.php">[Logout]</a><a href="index.php">[Voltar]</a>
    <h3>Inserir Visita</h3>
    <?php $dashboard->insereVisita($conn); ?>
      <form role="form" method="post">
        <div class="insere">
          <input type="text" class="form-control" placeholder="Agente" name="agente" required autofocus>
          <input type="text" class="form-control" placeholder="Numero" name="numero" required>
          <input type="text" class="form-control" placeholder="Data1" name="data1" >
          <input type="text" class="form-control" placeholder="Dia1" name="dia1" >
          <input type="text" class="form-control" placeholder="Hora1" name="hora1" >
          <input type="text" class="form-control" placeholder="Nome" name="nome" required>
          <input type="text" class="form-control" placeholder="Profissao" name="profissao" >
          <input type="text" class="form-control" placeholder="DataNascimento" name="datanascimento" >
          <input type="text" class="form-control" placeholder="Nome2" name="nome2" >
          <input type="text" class="form-control" placeholder="Profissao2" name="profissao2" >
          <input type="text" class="form-control" placeholder="Dnasc2" name="dnasc2" >
          <input type="text" class="form-control" placeholder="EstCivil" name="estcivil" >
          <input type="text" class="form-control" placeholder="Telemovel" name="telemovel" >
          <input type="text" class="form-control" placeholder="OutTelef" name="outTelef" >
          <input type="text" class="form-control" placeholder="Morada" name="morada" >
          <input type="text" class="form-control" placeholder="CodPostal" name="codpostal" >
          <input type="text" class="form-control" placeholder="Localidade" name="localidade" >
          <input type="text" class="form-control" placeholder="Email" name="email" >
          <input type="text" class="form-control" placeholder="observacao" name="observacao" >
          <input type="text" class="form-control" placeholder="MarcadoPor" name="marcadopor">
          <input type="text" class="form-control" placeholder="MarcacaoNum" name="marcacaonum">
          <input type="text" class="form-control" placeholder="MarcacaoData" name="marcacaodata">
          <input type="text" class="form-control" placeholder="Contato" name="contato">
          <input type="text" class="form-control" placeholder="RB" name="rb">
          <input type="text" class="form-control" placeholder="PN" name="pn">
          <input type="text" class="form-control" placeholder="AQN" name="aqn">
          <input type="text" class="form-control" placeholder="AtendimentoAnterior" name="atendimentoanterior">
          <input type="text" class="form-control" placeholder="AdiadoCancelado" name="adiadocancelado">
          <input type="text" class="form-control" placeholder="AdiadoCanceladoPQ" name="adiadocanceladopq">
          <input type="text" class="form-control" placeholder="ServicoAgente" name="servicoagente">
          <input type="text" class="form-control" placeholder="ServicoAgenteNum" name="servicoagentenum">
          <input type="text" class="form-control" placeholder="AcompanhamentoAgente" name="acompanhamentoagente">
          <input type="text" class="form-control" placeholder="AcompanhamentoAgenteNum" name="acompanhamentoagentenum">
          <input type="text" class="form-control" placeholder="Premio" name="premio">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Guardar</button>
      </form>


    </div>
  </body>
</html>


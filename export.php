<?php
  require_once('lib/ParseHtml.php');
  require_once('lib/model_importacao.php');
  include_once('lib/simple_html_dom.php');
  include_once('lib/functions.php');
  require_once('lib/config.php');

  $dashboard = new Dashboard(DBHOST,DBNAME,DBUSER,DBPASSWD);
  $conn= $dashboard->connect();
  $dashboard->authcheck();
  $dashboard->exporta($conn);
?>

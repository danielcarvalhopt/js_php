<?php


class Dashboard {

  private $hostname;
  private $dbname;
  private $username;
  private $password;

// Contrutores

  public function __construct($host,$dbname,$user,$pw){
    $this->hostname=$host;
    $this->dbname=$dbname;
    $this->username=$user;
    $this->password=$pw;
  }


//  Conexão

  public function connect() {
    $conn = new mysqli($this->hostname,$this->username,$this->password,$this->dbname) or die("Falhou a conexão à base de dados!");
    mysql_query("set names 'utf8'");
    if ($conn->connect_errno) {
      printf("Connect failed: %s\n", $mysqli->connect_error);
    }

    return $conn;
  }


// Utilizadores



  public function authcheck(){
    if(!isset($_SESSION)){session_start();}
    if(isset($_SESSION['username'])){}
    else {session_destroy(); header("location:login.php");exit();}
  }


  public function err_msg(){
    if(isset($_POST['err'])){
      if($_POST['err'] == "password"){echo "Passwords não coincidem!";}
      if($_POST['err'] == "account"){echo "Já existe uma conta com esse email!";}
      if($_POST['err'] == "login"){echo "Utilizador ou password errados!";}
    }
  }

  public function signup($conn){
    if(isset($_REQUEST['username']) && isset($_REQUEST['password']) && $_REQUEST['password']!=null && $_REQUEST['username']!=null){
      $user=mysqli_real_escape_string($conn, $_REQUEST['username']);
      $pw=md5(mysqli_real_escape_string($conn, $_REQUEST['password']));
      $conf=md5(mysqli_real_escape_string($conn, $_REQUEST['conf_password']));

      $res = $conn->query("SELECT * from users where username='$user'");
      if ($res->num_rows > 0){
        $_POST['err'] = "account";
      }
      if ($pw != $conf){
        $_POST['err'] = "password";
      }
      elseif ($res->num_rows <= 0) {
        $res = $conn->query("INSERT into `users` (username, password) values ('$user', '$pw')");
        $row = $conn->query("SELECT id from users where username='$user'");
        $id = $row->fetch_array(MYSQLI_ASSOC);
        $_SESSION['id']= $id["id"];
        $_SESSION['username'] = "$user";
        header("location:index.php");
        ob_flush();
        exit();
      }
    }
  }

  public function signin($conn){
    if(isset($_POST['username']) && isset($_POST['password']) && $_POST['password']!=null && $_POST['username']!=null){
      $user=mysqli_real_escape_string($conn, $_REQUEST['username']);
      $pw=md5(mysqli_real_escape_string($conn, $_REQUEST['password']));
      $res = $conn->query("SELECT * from users where username='$user' and password='$pw'");
      if ($res->num_rows > 0){
        session_start();
        $row = $conn->query("SELECT id from users where username='$user'");
        $id = $row->fetch_array(MYSQLI_ASSOC);
        $_SESSION['id']= $id["id"];
        $_SESSION['username'] = "$user";
        header("location:index.php");
        exit();
      }
      else{
        $_POST['err']="login";
      }
    }
  }

  public function cleansessions(){
    session_start();
    if(!isset($_POST['username'])){session_unset();}
    session_destroy();
  }


// Forms


  public function clientform($conn){
    if(isset($_POST['name'])){
      $name = isset($_POST['name'])?$_POST['name']:"";
      $phone = isset($_POST['phone'])?$_POST['phone']:"";
      $email = isset($_POST['email'])?$_POST['email']:"";
      $address = isset($_POST['address'])?$_POST['address']:"";
      $postal = isset($_POST['postal'])?$_POST['postal']:"";
      $town = isset($_POST['town'])?$_POST['town']:"";
      $conn->query("INSERT into `clients` (user_id, name, mobile, address, postal_code, town, email) values (".$_SESSION['id'].", '$name','$phone','$address','$postal','$town','$email')");
      unset($_POST);
    }
  }


  public function insereDemo($conn){
    if(isset($_POST['nome'])){
      $agente = isset($_POST['agente'])?$_POST['agente']:"";
      $numero = isset($_POST['numero'])?$_POST['numero']:"";
      $data1 = isset($_POST['data1'])?$_POST['data1']:"";
      $dia1 = isset($_POST['dia1'])?$_POST['dia1']:"";
      $hora1 = isset($_POST['hora1'])?$_POST['hora1']:"";
      $nome = isset($_POST['nome'])?$_POST['nome']:"";
      $profissao = isset($_POST['profissao'])?$_POST['profissao']:"";
      $datanascimento = isset($_POST['datanascimento'])?$_POST['datanascimento']:"";
      $nome2 = isset($_POST['nome2'])?$_POST['nome2']:"";
      $profissao2 = isset($_POST['profissao2'])?$_POST['profissao2']:"";
      $dnasc2 = isset($_POST['dnasc2'])?$_POST['dnasc2']:"";
      $estcivil = isset($_POST['estcivil'])?$_POST['estcivil']:"";
      $telemovel = isset($_POST['telemovel'])?$_POST['telemovel']:"";
      $outTelef = isset($_POST['outTelef'])?$_POST['outtelef']:"";
      $morada = isset($_POST['morada'])?$_POST['morada']:"";
      $codpostal = isset($_POST['codpostal'])?$_POST['codpostal']:"";
      $localidade = isset($_POST['localidade'])?$_POST['localidade']:"";
      $email = isset($_POST['email'])?$_POST['email']:"";
      $observacao = isset($_POST['observacao'])?$_POST['observacao']:"";
      $demoorigem = isset($_POST['demoorigem'])?$_POST['demoorigem']:"";
      $sugestao = isset($_POST['sugestao'])?$_POST['sugestao']:"";
      $sugestaoTipo = isset($_POST['sugestaoTipo'])?$_POST['sugestaoTipo']:"";

      $query = "Insert into clientes (user_id, Agente, Numero, Data1, Dia1,
                Hora1, Nome, Profissao, Dnasc, Nome2, Profissao2, Dnasc2, EstCivil,
                Telemovel, OutTelef, Morada, CodPostal, Localidade, Email, Observacao,
                TipoArquivo, DemoOrigem, Sugestao, SugestaoTipo) values (".$_SESSION["id"].",'$agente','$numero',
                '$data1','$dia1','$hora1','$nome','$profissao','$datanascimento','$nome2','$profissao2','$dnasc2',
                '$estcivil','$telemovel','$outTelef','$morada','$codpostal','$localidade','$email','$observacao',
                'D','$demoorigem','$sugestao','$sugestaoTipo')";
      $conn->query($query);
    }
    if(isset($_POST))unset($_POST);
  }


  public function insereVisita($conn){
    if(isset($_POST['nome'])){
      $agente = isset($_POST['agente'])?$_POST['agente']:"";
      $numero = isset($_POST['numero'])?$_POST['numero']:"";
      $data1 = isset($_POST['data1'])?$_POST['data1']:"";
      $dia1 = isset($_POST['dia1'])?$_POST['dia1']:"";
      $hora1 = isset($_POST['hora1'])?$_POST['hora1']:"";
      $nome = isset($_POST['nome'])?$_POST['nome']:"";
      $profissao = isset($_POST['profissao'])?$_POST['profissao']:"";
      $datanascimento = isset($_POST['datanascimento'])?$_POST['datanascimento']:"";
      $nome2 = isset($_POST['nome2'])?$_POST['nome2']:"";
      $profissao2 = isset($_POST['profissao2'])?$_POST['profissao2']:"";
      $dnasc2 = isset($_POST['dnasc2'])?$_POST['dnasc2']:"";
      $estcivil = isset($_POST['estcivil'])?$_POST['estcivil']:"";
      $telemovel = isset($_POST['telemovel'])?$_POST['telemovel']:"";
      $outTelef = isset($_POST['outTelef'])?$_POST['outTelef']:"";
      $morada = isset($_POST['morada'])?$_POST['morada']:"";
      $codpostal = isset($_POST['codpostal'])?$_POST['codpostal']:"";
      $localidade = isset($_POST['localidade'])?$_POST['localidade']:"";
      $email = isset($_POST['email'])?$_POST['email']:"";
      $observacao = isset($_POST['observacao'])?$_POST['observacao']:"";
      $marcadopor = isset($_POST['marcadopor'])?$_POST['marcadopor']:"";
      $marcacaonum = isset($_POST['marcacaonum'])?$_POST['marcacaonum']:"";
      $marcacaodata = isset($_POST['marcacaodata'])?$_POST['marcacaodata']:"";
      $contato = isset($_POST['contato'])?$_POST['contato']:"";
      $rb = isset($_POST['rb'])?$_POST['rb']:"";
      $pn = isset($_POST['pn'])?$_POST['pn']:"";
      $aqn = isset($_POST['aqn'])?$_POST['aqn']:"";
      $atendimentoanterior = isset($_POST['atendimentoanterior'])?$_POST['atendimentoanterior']:"";
      $adiadocancelado = isset($_POST['adiadocancelado'])?$_POST['adiadocancelado']:"";
      $adiadocanceladopq = isset($_POST['adiadocanceladopq'])?$_POST['adiadocanceladopq']:"";
      $servicoagente = isset($_POST['servicoagente'])?$_POST['servicoagente']:"";
      $servicoagentenum = isset($_POST['servicoagentenum'])?$_POST['servicoagentenum']:"";
      $acompanhamentoagente = isset($_POST['servicoagente'])?$_POST['servicoagente']:"";
      $acompanhamentoagentenum = isset($_POST['servicoagentenum'])?$_POST['servicoagentenum']:"";
      $premio = isset($_POST['premio'])?$_POST['premio']:"";


      $query = "Insert into clientes (user_id, Agente, Numero, Data1, Dia1,
                Hora1, Nome, Profissao, Dnasc, Nome2, Profissao2, Dnasc2, EstCivil,
                Telemovel, OutTelef, Morada, CodPostal, Localidade, Email, Observacao,
                TipoArquivo,MarcadoPor,MarcacaoNum,MarcacaoData,Contato,RB,PN,AQN,
                AtendimentoAnterior,AdiadoCancelado,AdiadoCanceladoPQ,ServicoAgente,ServicoAgenteNum,
                AcompanhamentoAgente,AcompanhamentoAgenteNum,Premio) values (".$_SESSION["id"].",'$agente','$numero',
                '$data1','$dia1','$hora1','$nome','$profissao','$datanascimento','$nome2','$profissao2','$dnasc2',
                '$estcivil','$telemovel','$outTelef','$morada','$codpostal','$localidade','$email','$observacao',
                'V','$marcadopor','$marcacaonum','$marcacaodata','$contato','$rb','$pn','$aqn','$atendimentoanterior',
                '$adiadocancelado','$adiadocanceladopq','$servicoagente','$servicoagentenum','$acompanhamentoagente',
                '$acompanhamentoagentenum','$premio')";
      $res = $conn->query($query);
    }
    if(isset($_POST))unset($_POST);
  }




  public function listaClientes($conn){
    if(isset($_POST['str'])){
      switch ($_POST['search']) {
         case 0:
              $query = "Select * from clientes where Nome LIKE '%".$_POST['str']."%'";
              $res = $conn->query($query);
               break;
         case 1:
              $query = "Select * from clientes where CodPostal LIKE '%".$_POST['str']."%'";
              $res = $conn->query($query);
               break;
         case 2:
               $query = "Select * from clientes where Telemovel LIKE '%".$_POST['str']."%' or OutTelef LIKE '%".$_POST['str']."%'";
               $res = $conn->query($query);
               break;
         case 3:
               $query = "Select * from clientes where Email LIKE '%".$_POST['str']."%'";
               $res = $conn->query($query);
               break;
      }
    }
    else {$res = $conn->query("SELECT * FROM clientes where user_id =".$_SESSION['id']);}
    for($i=0; $i<($res->num_rows); $i++){
      $row = $res->fetch_array(MYSQLI_ASSOC);
      echo "<tr>
              <td>".$row["id"]."</td>
              <td>".$row["TipoArquivo"]."</td>
              <td>".$row["Nome"]."</td>
              <td>".$row["Email"]."</td>
              <td>".$row["Telemovel"]."</td>
              <td>".$row["Morada"]."</td>
              <td>".$row["CodPostal"]."</td>
              <td>".$row["Localidade"]."</td>
              <td><a href='client".$row["TipoArquivo"].".php?id=".$row["id"]."'>Consultar</a></td>
            </tr>";
      unset($_POST);
    }
  }

  public function listaCliente($conn){
    $res = $conn->query("SELECT * FROM clientes where id =".$_GET['id']);
    $row = $res->fetch_array(MYSQLI_ASSOC);
    if($row['user_id']==$_SESSION['id']){
      return $row;}
    else{
      header("location:index.php");
      ob_end_flush();
      exit();
    }
  }

  public function exporta($conn){
    $res = $conn->query("SELECT * FROM clientes where user_id =".$_SESSION['id']);
    for($i=0; $i<($res->num_rows); $i++){
      $row = $res->fetch_array(MYSQLI_ASSOC);
      $str="";
      foreach ($row as $v) {
        $str.="'$v',";
      }
      $str = trim($str);
      $str = rtrim($str, ",");
      $str = preg_replace( "/\<br\>/", " ", $str );
      echo $str."<br/>";
    }
  }


  public function get_elements_sibling_content($re, $html)
  {
    $tds = $html->find('table td');

    foreach($tds as $td)
    {
      preg_match($re, $td->innertext, $output_array);
      if(count($output_array) > 0 && count($td->children) == 0)
      {
        $string = $td->next_sibling()->plaintext;
        $string = trim(preg_replace('/\s+/', ' ', $string));
        $string = preg_replace("/&nbsp;/", '', $string);
        return $string;
      }
    }
  }

  public function get_data($html){
    $name = $this->get_elements_sibling_content("/1.+Nome&nbsp;\z/", $html);
    $mobile = $this->get_elements_sibling_content("/Telem.vel&nbsp;\z/", $html);
    $address = $this->get_elements_sibling_content("/Morada&nbsp;\z/", $html);
    $postal_code = $this->get_elements_sibling_content("/C.digo postal&nbsp;\z/", $html);
    $town = $this->get_elements_sibling_content("/Localidade&nbsp;\z/", $html);
    $email = $this->get_elements_sibling_content("/Email:&nbsp;\z/", $html);

    return array(
                  'name' => $name,
            'mobile' => $mobile,
            'address' => $address,
            'postal_code' => $postal_code,
            'town' => $town,
            'email' => $email);
  }

  public function store_data_in_database($conn, $data){

    $queryString = "INSERT INTO clients (user_id, name, mobile, address, postal_code, town, email) VALUES (";
    $queryString .= "'" .$_SESSION['id']. "', ";
    $queryString .= "'" . $data['name'] . "', ";
    $queryString .= "'" . $data['mobile'] . "', ";
    $queryString .= "'" . $data['address'] . "', ";
    $queryString .= "'" . $data['postal_code'] . "', ";
    $queryString .= "'" . $data['town'] . "', ";
    $queryString .= "'" . $data['email'] . "') ";
    // echo $queryString;
    if(!$conn->query($queryString))
    {
      echo "Insert into databse failed.";
    }
      else
    {
      echo "Insert into database successful.";
    }

  }


  public function clientfile($conn){
    if(isset($_FILES['file'])){
      if ($_FILES["file"]["error"] > 0){
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
      }
      else{
        $strHtml = file_get_contents($_FILES["file"]["tmp_name"]);

        $parse = new ParseHtml($strHtml);
        $parse->Extrair_dados();

        $banco = new Model_Importacao($conn);
        $banco->inserir($parse->ObjDataClient);

      }
    }
  }
}




?>

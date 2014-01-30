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


  public function listaClientes($conn){
    $res = $conn->query("SELECT * FROM clients where user_id =".$_SESSION['id']);
    for($i=0; $i<$res->num_rows; $i++){
      $row = $res->fetch_array(MYSQLI_ASSOC);
      echo "<tr>
              <td>".$row["id"]."</td>
              <td>".$row["name"]."</td>
              <td>".$row["email"]."</td>
              <td>".$row["mobile"]."</td>
              <td>".$row["address"]."</td>
              <td>".$row["postal_code"]."</td>
              <td>".$row["town"]."</td>
            </tr>";
      unset($_POST);
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
    if ($_FILES["file"]["error"] > 0)
      {
      echo "Error: " . $_FILES["file"]["error"] . "<br>";
      }
    else
      {
      $html = new simple_html_dom();
      $html->load_file($_FILES["file"]["tmp_name"]);
      $data = $this->get_data($html);

      $this->store_data_in_database($conn, $data);

      }
    }
  }



}




?>

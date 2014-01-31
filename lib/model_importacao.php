<?php


   class Model_Importacao{

    private $conn;




    function __construct($conn)
    {
      $this->conn = $conn;

    }



    public function inserir($dados)
    {
      $STR = "";
      $CAMPO = "";
      $VALOR = "";
      $i =1 ;
      foreach ($dados as $key => $value) {

          $value = str_replace('&nbsp', "", $value);

          $CAMPO .= trim($key).',';
          $VALOR .= "'".trim($value) ."',";
        //if($i == 10)   break  ;
            $i++;
      }


      $CAMPO  = substr($CAMPO, 0 ,-1);
      $VALOR  = substr($VALOR, 0 ,-1);

      $STR = "INSERT INTO clientes (user_id, ".$CAMPO.") VALUES (".$_SESSION['id'].",".$VALOR.");";




           //$this->MySql->query($STR)  ;
        $this->conn->query($STR) ;




    }

    public function select($where=null)
    {

      $STR = empty($where) ? "SELECT * FROM CLIENTE" : "SELECT * FROM CLIENTE" . addslashes($where);

      $SELECT =  $this->conn->query($STR);


      return  $SELECT ;
    }


   }
?>

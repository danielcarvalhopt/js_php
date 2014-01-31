<?php

  require_once 'simple_html_dom.php';
  require_once 'ObjDadosCliente.php';

class ParseHtml
{


  private $Table;
  private $HTML;
  private $dv1;
  private $dv2 ;
  public $ObjDataClient ;



  function __construct($HtmlText){

      $this->ObjDataClient = new ObjDadosCliente();

      $this->HTML = str_get_html($HtmlText);

      $this->validaDemoVisita($HtmlText);

      $this->div1 = $this->HTML->getElementById('dv1')->find('table');
      $this->div2 = $this->HTML->getElementById('dv2')->find('table');




      $this->Table =  $this->HTML->getElementById('dv1')->find('table');
      //$this->Table =  $this->HTML->getElementById('dv1')->find('table');
      //echo $this->HTML->getElementById('dv1');
      $this->PegaDados2($this->div2);
    }



    private function PegaDados2($DadosDiv)
    {

      switch ($this->ObjDataClient->TipoArquivo) {

        case 'V':  // Quando o arquivo for do tipo Visita


          // Get Marcado feita Por
            $ParametroMarcado = '/<td>(.*?)<\/td>/';
            $this->ObjDataClient->MarcadoPor =   preg_match($ParametroMarcado,$this->div2[2], $MarcadoPor) ?  $MarcadoPor[1] : "-";

          // Get Numero marcação - Posição 2 no indice
            $ParametroMarcacaoNum = '/<td.*?class=.*?neg1.*?>n.*?<td>(.*?)<\/td>/';
            $this->ObjDataClient->MarcacaoNum =   preg_match($ParametroMarcacaoNum ,$this->div2[2], $MarcacaoNum) ?  $MarcacaoNum[1] : "-";

          // Get data da marcação - Posição 3 no indice
            $ParametroMarcacaoData = '/Data.*?<td>(.*?)<\/td>/';
            $this->ObjDataClient->MarcacaoData =   preg_match($ParametroMarcacaoData ,$this->div2[3], $MarcacaoData) ?  $MarcacaoData[1] : "-";

          /*******
           *   Posição 4 no indice
          ******/

          // Get Contato
            $ParametroContato = '/<td.*?class=neg1>Contrato.*?<td>().*?)<\/td>/';
            $this->ObjDataClient->Contato  =   preg_match($ParametroMarcado,$this->div2[4], $Contato ) ?  $Contato [1] : "-";


          // Get RB
            $ParametroRB= '/<b>RB:<\/b>(.*?)<b>PN:<\/b>/';
            $this->ObjDataClient->RB =   preg_match($ParametroRB,$this->div2[4], $RB) ?  $RB[1] : "-";

           // Get PN
            $ParametroPN = '/<b>PN:<\/b>(.*?)<br/';
            $this->ObjDataClient->PN  =   preg_match($ParametroPN  ,$this->div2[4], $PN) ?  $PN[1] : "-";
          // Get AQN
            $ParametroAQN = '/<b>AQM:<\/b>(.*?)<\/td>/';
            $this->ObjDataClient->AQN =   preg_match($ParametroAQN  ,$this->div2[4], $AQN) ?  $AQN[1] : "-";

          /*******
           *   Posição 5 no indice
          ******/

          // Get Visita anterior
            $ParametroAtendimentoAnterior = '/.*?visita anterior.*?<td>(.*?)<\/td>/';
            $this->ObjDataClient->AtendimentoAnterior =   preg_match($ParametroAtendimentoAnterior  ,$this->div2[5], $AtendimentoAnterior) ?  $AtendimentoAnterior[1] : "-";


          /*************************
           *   Posição 6 e 7 no indice
           *    Verifica se a visita foi Adicada ou Cancelada
           *    sendo  0 = Adiada, 1 = Cancelada. Nulo por padrão
          ***********************/

            $this->ObjDataClient->AtendimentoAnterior ;
            $Input = str_get_html($this->div2[6])->find('input');

            foreach ($Input as $key => $value) {

               if(preg_match("/checked/", $value)){
                $this->ObjDataClient->AdiadoCancelado = $key = 0 ? "Adiado" : "Cancelado" ;
                $this->ObjDataClient->AdiadoCanceladoPQ = preg_match('/<td*.?width="30em">(.*?)<\/td>/',$this->div2[7], $PQ) ? $PQ[1] : "-";

               }
            }


          /*******
          *  Posição 9 no indice
          *   Serviço feito por agente:
          ******/

            $this->ObjDataClient->ServicoAgente   = preg_match('/<td class=.*?BordoSub.*?>(.*?)<\/td>/', $this->div2[9], $Servico) ? $Servico[1] : "-";
            $this->ObjDataClient->ServicoAgenteNum  = preg_match('/<td.*?BordoSub.*?26em.*?>(.*?)<\/td>/', $this->div2[9], $ServicoNum) ? $ServicoNum[1] : "-";

          /*******
          *  Posição 11 no indice
          *   Acompanhamento por agente:
          ******/

            $this->ObjDataClient->AcompanhamentoAgente    = preg_match('/cellpadding=0.*?<tr>.*?<td>(.*?)<\/td>/', $this->div2[11], $Acompanhamento) ? $Acompanhamento[1] : "-";
            $this->ObjDataClient->AcompanhamentoAgenteNum   = preg_match('/<td.width=.26em.>(.*?)<\/td>/', $this->div2[11], $AcompanhamentoNum) ? $AcompanhamentoNum[1] : "-";

          /*******
          *  Posição 1 no indice
          *   Premio
          ******/

            $this->ObjDataClient->Premio  = preg_match('/<td.width=.15em.>(.*?)<\/td>/', $this->div2[12], $Premio) ? $Premio[1] : "-";


          break;


        case 'D': // Quando o arquivo for do tipo Demonstração

          /*******
          *  Posição 1 no indice
          *   Demionstração de Origem
          ******/

            $this->ObjDataClient->DemoOrigem  = preg_match('/<td>(.*?)<\/td>/', $this->div2[1], $DemoOrigem) ? $DemoOrigem[1] : "-";

          /*******
          *  Posição 2 no indice
          *   Quem deu o nome
          ******/

            $this->ObjDataClient->Sugestao  = preg_match('/<td>(.*?)<\/td>/', $this->div2[2], $Sugestao) ? $Sugestao[1] : "-";


          /*******
          *  Posição 3 no indice
          *   Quem deu o nome; Tipo do C
          ******/
             $this->ObjDataClient->SugestaoTipo = $this->SugestaoTipo($this->div2[3]) ;


          break;


        default:

          break;
      }




    }




  function Extrair_dados(){

  /**************************************/
  /* Primeiro Bloco dados do Agente*/
  /**************************************/

  /* Posição 1,2  no vetor com o HTML  */

     // Get Agent name

     $ParametroAgente = '/<td.*?class="neg1r">Agente<\/td>.*?<td>(.*?)<\/td>/';
     $this->ObjDataClient->Agente =   preg_match($ParametroAgente,$this->Table[1], $matches) ?  $matches[1] : "-";



  // Get Agent Numero
     $ParametroAgenteNumero = ('/<td.*?width=.*?15em.*?>(.*?)<\/td>/');
     $this->ObjDataClient->Numero =  preg_match($ParametroAgenteNumero,$this->Table[1], $Numero) ?  $Numero[1] : "-";


  // Get Data1
     $ParametroData = '/<td.*?class="neg1r">Data&nbsp;<\/td>.*?<td>(.*?)<\/td>/';
     $this->ObjDataClient->Data1 =   preg_match($ParametroData,$this->Table[2], $Data1) ?  $Data1[1] : "-";


  //  Get Dia1

       $ParametroDia1 = '/<td.*?class="neg1r">Dia&nbsp;<\/td>.*?<td>(.*?)<\/td>/';
     $this->ObjDataClient->Dia1 =   preg_match($ParametroDia1,$this->Table[2], $Dia1) ?  $Dia1[1] : "-";

  //  Get Hora1

       $ParametroHora1 = '/<td.*?class="neg1r">Hora.*?<td>(.*?)<\/td>/';
     $this->ObjDataClient->Hora1 =   preg_match($ParametroHora1,$this->Table[2], $Hora1) ?  $Hora1[1] : "-";



  /**************************************/
  /* Segundo Bloco com NOME e PROFISSÃO */
  /**************************************/

  /* Posição 3 no vetor com o HTML  */
  //   echo  $this->Table[3] ;
     $strHtml = $this->Table[3] ;

     $Html_tr =  str_get_html($strHtml)->find('td');

     $this->ObjDataClient->Nome     = (string) str_get_html($strHtml)->createTextNode($Html_tr[1]);
     $this->ObjDataClient->Profissao  = (string) str_get_html($strHtml)->createTextNode($Html_tr[3]);
     $this->ObjDataClient->Dnasc    = (string) str_get_html($strHtml)->createTextNode($Html_tr[6]);
     $this->ObjDataClient->Nome2    = (string) str_get_html($strHtml)->createTextNode($Html_tr[8]);
     $this->ObjDataClient->Profissao2   = (string) str_get_html($strHtml)->createTextNode($Html_tr[10]);
     $this->ObjDataClient->Dnasc2   = (string) str_get_html($strHtml)->createTextNode($Html_tr[13]);


  /***********************************************/
  /* Terceiro Bloco com Est. Civil, Tel e Morada */
  /***********************************************/

  /* Posição 4 no vetor com o HTML  */

  //  Get Estado Civil


     $ParametroCivil = '/<td.*?class=BordoSub>(.*?)<\/td>/';
     $this->ObjDataClient->EstCivil=   preg_match($ParametroCivil,$this->Table[4], $Civil) ?  $Civil[1] : "-";

  //  Get Telemovel


     $ParametroTelemovel = '/<td.*?class="neg1">Telem.*?<\/td>.*?<td.*?>(.*?)<\/td>/';
     $this->ObjDataClient->Telemovel =   preg_match($ParametroTelemovel,$this->Table[4], $Telemovel) ?  $Telemovel[1] : "-";

  // Get Out. Telef

     $ParametroOutTelef = '/<td.*?class="neg1">Out.*?colspan=4>(.*?)<\/td>/';
     $this->ObjDataClient->OutTelef =   preg_match($ParametroOutTelef,$this->Table[4], $OutTelef) ?  $OutTelef[1] : "-";


  //  Get Morada

     $ParametroMorada = '/<td.*?class="neg1">Morada.*?colspan=4>(.*?)<\/td>/';
     $this->ObjDataClient->Morada =   preg_match($ParametroMorada,$this->Table[4], $Morada) ?  $Morada[1] : "-";


  /***********************************************/
  /* Quarto Bloco com Cod. Postal e Localidade*/
  /***********************************************/

  /* Posição 5 no vetor com o HTML  */

  // Get Codigo Postal

     $ParametroCPostal = '/<td.*?class="neg1">.*?posta.*?<td>(.*?)<\/td>/';
     $this->ObjDataClient->CodPostal=   preg_match($ParametroCPostal,$this->Table[5], $CPostal) ?  $CPostal[1] : "-";

  // Get Codigo Postal

     $ParametroLocalidade = '/<td.*?width=.*?127em.*?>(.*?)<\/td>/';
     $this->ObjDataClient->Localidade =   preg_match($ParametroLocalidade,$this->Table[5], $Localidade) ?  $Localidade[1] : "-";


  /***********************************************/
  /* Quarto Bloco com Cod. Postal e Localidade*/
  /***********************************************/

  /* Posição 6 no vetor com o HTML  */

  // Get Email

     $ParametroEmail = '/<td.*?width=.*?35em.*?.*?class=.*?BordoSub.*?>(.*?)<\/td>/';
     $this->ObjDataClient->Email  =   preg_match($ParametroEmail,$this->Table[6], $Email) ?  $Email[1] : "-";



  //***********************************************/
  /*   Quarto Bloco com Observaçao */
  /*   neste bloco sera extraido diretamente sem
   *   ser utilizado a classe 'simple_html_dom.php',
   *   pois o campo esta fora das tag html.
   *   Todo o html esta na variavel $this->HTML
  /***********************************************/

  // Get Ogservaçao

    $ParametroObservacao = '/<b>Observa.*?<\/b>(.*?)<\/td>/';
    $this->ObjDataClient->Observacao =   preg_match($ParametroObservacao,$this->HTML, $Obs) ? $Obs[1] : "-";     // Uso da Função 'trim' para liebrar espaçõs em branco

  }

  /* Funçao para verificar dipo de atendimento */
  function validaDemoVisita($DadosHtml){


    $div = str_get_html($DadosHtml);

    //Quando conter a tag DIV com ID 'dv3' este será o aquivo do tipo D = Demonstração
    // caso não comtenha a tad sera o arquivo de Visita

    $dv3  = $div->getElementById('dv3');
    if(empty($dv3)) {
        $this->ObjDataClient->TipoArquivo = 'V';
      }else{
        $this->ObjDataClient->TipoArquivo = 'D';
      }

  }



  private function SugestaoTipo($Dados)
  {
    $SugestaoTipo = str_get_html($Dados)->find('input');
    $SugTipo = null;
    $StrSugTipo = "";

    foreach ($SugestaoTipo as $key => $value) {
       if(preg_match("/checked/", $value)){
        $SugTipo =  $key ;
       }
    }

    switch ($SugTipo) {
      case 0:
          $StrSugTipo = "Cliente";
        break;

      case 1:
          $StrSugTipo = "Não Cliente";
        break;
      case 2:
          $StrSugTipo = "Agente";
        break;

      default:
          $StrSugTipo = null ;
        break;
    }

    return (string) $StrSugTipo;
  }

}




<?php
  if(!isset($_SESSION)){ @session_start();}
  require_once("../configuration/connection.php");
  class Control{
    private $_oLinkId;
    private $_sServidor;
    private $_sNombreBD;
    private $_sUsuario;
    private $_sClave;
    private $_sMensaje="";
    private $query;
    private $identificador;
    public  $nroregistros=0;
    private $recordset=false;
    private $array;
    private static $_oSelf = NULL;
  //_Evitamos el clonaje del objeto
    private function __clone(){
      trigger_error('Esta clase no puede clonarse', E_USER_ERROR);
    }
  //_Constructor
    private function __construct(){
      $_oConfig = Configuration::getConfiguration();
      $this->_sServidor = $_oConfig->get("dbServer");
      $this->_sNombreBD = $_oConfig->get("dbBase");
      $this->_sUsuario = $_oConfig->get("dbUser");
      $this->_sClave = $_oConfig->get("dbPwd");
      $this->_sMensaje = "";
      $this->connection();
      }
  //_Para evaluar si la conexion esta abierta
      public static function getInstance(){
          if( !self::$_oSelf instanceof self ){
              self::$_oSelf = new self();
          }
          return self::$_oSelf;
      }
  //_Para conectarse a la BASE DE DATOS
      private function connection(){
        $oMssqlConnect = @mysqli_connect($this->_sServidor, $this->_sUsuario, $this->_sClave, $this->_sNombreBD);
        if(mysqli_connect_errno()){
          $this->_sMensaje = "ERROR: No se puede conectar a la base de datos..! ".$this->_sNombreBD;
          throw new Exception($this->_sMensaje);
          die;
        }
        $this->_oLinkId = $oMssqlConnect;
        return true;
      }
  //_Para obtener el ID de conexion
      public function getLinkId(){ return $this->_oLinkId; }
  //_Para obtener el mensaje de la conexion
      public function getMessage(){ return $this->_sMensaje; }
  //_Para obtener a QUERY a ejecutar
      public function getQuery(){ return $this->query; }
  //_Para ejecutar una sentencia SQL
    public function runQuery($consul=""){
      $rs = 0;
      if(trim($consul)<>""){
        $this->query = $consul;
        $this->identificador = $this->getLinkId();
        $this->recordset = @mysqli_query($this->identificador,$this->query);
        if($this->recordset==true){
          $this->nroregistros = @mysqli_num_rows($this->recordset);
          if($this->nroregistros > 0){
            $rs = $this->recordset;
          }
        }
      }else{
        $this->nroregistros = 0;
      }
      return $rs;
    }
  //_Para obtener el numero de registros de una consulta	
    public function getTotalRecords($consul=""){
      $this->nroregistros = 0;
      if(trim($consul)<>""){
        $this->query = $consul;
        $this->identificador = $this->getLinkId();
        $this->recordset = @mysqli_query($this->identificador,$this->query);
        if($this->recordset<>false){ $this->nroregistros = @mysqli_num_rows($this->recordset); }
      }
      return($this->nroregistros);
    }
  //_Para el Mantenimiento de un registro (Agregar, Editar, Eliminar)
    public function runMaintance($consul=""){
      if(trim($consul)<>""){
        $this->query = $consul;
        $this->identificador = $this->getLinkId();
        $this->recordset = @mysqli_query($this->identificador,$this->query);
        $this->id_inserted = @mysqli_insert_id($this->identificador);
        if(!$this->recordset){
          $rs = false;
        }else{
          $rs = true;
        }
        @mysqli_free_result($this->recordset);
      }else{ $rs = false; }
      return $rs;
    }
  //_Para filtrar el metodo de presentacion de los resultados
      public function getCursor($stmt){
        if(is_object($stmt)){ $this->array=@mysqli_fetch_assoc($stmt); }
        return $this->array;
      }
  }
?>
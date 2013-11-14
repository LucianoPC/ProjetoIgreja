<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConexaoComBanco
 *
 * @author luciano
 */
class ConexaoComBanco {
    
    private $ERRO_INICIAR_CONEXAO = "Nao foi possivel estabelecer a conexao
                                com o banco de dados. Informe o Administrador.";
    private $DB_NAME="projetoigreja";
    private $USUARIO="root";
    private $PASSWORD="root";
    private $HOST = "localhost";
    
    private $conexao;
    
    public function __construct() {
        
    }
        
    public function iniciarConexao(){
        $this->conexao = mysql_connect($this->HOST,$this->USUARIO,
                                       $this->PASSWORD);
        $banco = mysql_select_db($this->DB_NAME,$this->conexao);
                
        if ( (!$this->conexao) || (!$banco) ) {
            throw new Exception($this->ERRO_INICIAR_CONEXAO);
        }
    }
    
    public function finalizarConexao(){
        mysql_close($this->conexao);
    }
    
    public function __destruct() {
        $this->finalizarConexao();
    }
}

?>

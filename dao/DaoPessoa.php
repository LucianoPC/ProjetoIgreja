<?php

use Exception;

$pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

require_once $pathRaiz . '/dao/ConexaoComBanco.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoPessoa
 *
 * @author luciano
 */
class DaoPessoa {
    
    private $ERRO = "Erro na comunicação com o Banco de Dados. Informe o Administrador.";
    private $ERRO_CADASTRAR = "Nao foi possivel cadastrar a pessoa.
                              Informe o Administrador.";

    private $conexaoComBanco;
    
    public function __construct() {
        $this->conexaoComBanco = new ConexaoComBanco();
    }
    
    public function cadastrar($pessoa) {
        $query = $this->getQueryCadastro($pessoa);
        $this->conexaoComBanco->executarQuery($query, $this->ERRO_CADASTRAR);
    }
    
    public function getListaConsultaNome($nome, $ordenarPor = "nome") {
        $query = $this->getQueryListaConsultaNome($nome, $ordenarPor);
        $resultadoQuery = $this->conexaoComBanco->executarQuery($query, $this->ERRO);
        
        $lista = $this->getLista($resultadoQuery);
        
        return $lista;
    }
    
    public function getListaPessoas($ordenarPor = "nome") {
        $query = $this->getQueryListaPessoas($ordenarPor);
        $resultadoQuery = $this->conexaoComBanco->executarQuery($query, $this->ERRO);
        
        $lista = $this->getLista($resultadoQuery);
        
        return $lista;
    }
    
    private function getLista($resultadoQuery) {
        $lista = array();
        
        for ($i = 0; $i < mysql_num_rows($resultadoQuery); $i++){
            $nome = mysql_result($resultadoQuery , $i, "nome");
            $cidade = mysql_result($resultadoQuery , $i, "cidade");
            $estado = mysql_result($resultadoQuery , $i, "estado");
            $cep = mysql_result($resultadoQuery , $i, "cep");
            $telefone1 = mysql_result($resultadoQuery , $i, "telefone1");
            $telefone2 = mysql_result($resultadoQuery , $i, "telefone2");
            $telefone3 = mysql_result($resultadoQuery , $i, "telefone3");
            $email = mysql_result($resultadoQuery , $i, "email");
            $estadocivil = mysql_result($resultadoQuery , $i, "estadocivil");
                        
            $pessoa = new Pessoa($nome, $cidade, $estado, $cep, $telefone1, 
                    $telefone2, $telefone3, $email, $estadocivil);
            
            array_push($lista, $pessoa);
        }
        
        return $lista;
    }


    private function getQueryCadastro($pessoa){
        $query = "INSERT INTO `t_pessoa` VALUES (";
        $query .= "'" . $pessoa->getNome() . "', ";
        $query .= "'" . $pessoa->getCidade() . "', ";
        $query .= "'" . $pessoa->getEstado() . "', ";
        $query .= "'" . $pessoa->getCep() . "', ";
        $query .= "'" . $pessoa->getTelefone1() . "', ";
        $query .= "'" . $pessoa->getTelefone2() . "', ";
        $query .= "'" . $pessoa->getTelefone3() . "', ";
        $query .= "'" . $pessoa->getEmail() . "', ";
        $query .= "'" . $pessoa->getEstadocivil() . "')";

        return $query;
    }
    
    private function getQueryListaPessoas($ordenarPor = "nome"){
        $query = "SELECT * FROM `t_pessoa` ";
        $query .= "ORDER BY " . $ordenarPor . " ASC";
        
        return $query;
    }
    
    private function getQueryListaConsultaNome($nome, $ordenarPor) {
        $query = "SELECT * FROM `t_pessoa` ";
        $query .= "WHERE `nome` LIKE '%" . $nome . "%' ";
        $query .= "ORDER BY " . $ordenarPor . " ASC";
        
        return $query;
    }
}

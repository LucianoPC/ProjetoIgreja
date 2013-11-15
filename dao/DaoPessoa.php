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
    
    private $conexaoComBanco;
    
    public function __construct() {
        $this->conexaoComBanco = new ConexaoComBanco();
    }
    
    public function cadastrar($pessoa) {
        $query = $this->getQueryCadastro($pessoa);
        $this->conexaoComBanco->executarQuery($query, $this->ERRO_CADASTRAR);
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
    
}

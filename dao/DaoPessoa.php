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
        $query = $this->getQueryCadastro($usuario);
        $this->executarQuery($query, $this->ERRO_CADASTRAR);
    }
}

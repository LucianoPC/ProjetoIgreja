<?php

use Exception;

$pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

require_once $pathRaiz . '/model/Pessoa.php';
require_once $pathRaiz . '/dao/DaoPessoa.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlePessoa
 *
 * @author luciano
 */
class ControlePessoa {
    
    private $daoPessoa;
    
    public function __construct() {
        $this->daoPessoa = new DaoPessoa();
    }
    
    public function cadastrar($nome, $cidade, $estado, $cep, $telefone1, $telefone2, $telefone3, $email, $estadocivil) {
        $pessoa = new Pessoa($nome, $cidade, $estado, $cep, $telefone1, $telefone2, $telefone3, $email, $estadocivil);
        $this->daoPessoa->cadastrar($pessoa);
    }
    
}

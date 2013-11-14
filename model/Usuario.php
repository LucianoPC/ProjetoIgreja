<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author luciano
 */
class Usuario {
    
    private $login;
    private $senha;
    private $primeiroAcesso;
    
    public function __construct($login, $senha, $primeiroAcesso = 0) {
        $this->login = $login;
        $this->senha = $senha;
        $this->primeiroAcesso = $primeiroAcesso;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }
    
    public function isPrimeiroAcesso() {
        return $this->primeiroAcesso;
    }

    public function setPrimeiroAcesso($primeiroAcesso) {
        $this->primeiroAcesso = $primeiroAcesso;
    }


}

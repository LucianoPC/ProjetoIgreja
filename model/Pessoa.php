<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pessoa
 *
 * @author luciano
 */
class Pessoa {
    private $nome;
    private $cidade;
    private $estado;
    private $cep;
    private $telefone1;
    private $telefone2;
    private $telefone3;
    private $email;
    private $estadocivil;
    
    function __construct($nome, $cidade, $estado, $cep, $telefone1, $telefone2, $telefone3, $email, $estadocivil) {
        $this->nome = $nome;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
        $this->telefone1 = $telefone1;
        $this->telefone2 = $telefone2;
        $this->telefone3 = $telefone3;
        $this->email = $email;
        $this->estadocivil = $estadocivil;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getTelefone1() {
        return $this->telefone1;
    }

    public function getTelefone2() {
        return $this->telefone2;
    }

    public function getTelefone3() {
        return $this->telefone3;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getEstadocivil() {
        return $this->estadocivil;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setTelefone1($telefone1) {
        $this->telefone1 = $telefone1;
    }

    public function setTelefone2($telefone2) {
        $this->telefone2 = $telefone2;
    }

    public function setTelefone3($telefone3) {
        $this->telefone3 = $telefone3;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setEstadocivil($estadocivil) {
        $this->estadocivil = $estadocivil;
    }


}

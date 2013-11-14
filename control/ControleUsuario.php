<?php

use Exception;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControleUsuario
 *
 * @author luciano
 */
class ControleUsuario {
    
    private $daoUsuario;
    
    public function __construct() {
        $this->includes();
        $this->daoUsuario = new DaoUsuario();
    }
    
    public function includes(){
        $pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
        
        require_once $pathRoot . '/model/Usuario.php';
        require_once $pathRoot . '/dao/DaoUsuario.php';
    }
    
    public function cadastrar($usuario){
        $this->daoUsuario->cadastrar($usuario);
    }
    
    public function alterarSenha($usuario, $novaSenha){
        $this->daoUsuario->alterarSenha($usuario, $novaSenha);
    }
        
    public function fazerLogin($login, $senha){
        $usuario = new Usuario($login, $senha);
        $this->fazerLoginUsuario($usuario);
    }
    
    private function fazerLoginUsuario($usuario){
        if ( !$this->daoUsuario->existeLoginSenha($usuario)){
            throw new Exception("Usuario nao cadastrado");
        }
        
        setcookie("login", $usuario->getLogin());
        setcookie("senha", $usuario->getLogin());
    }
    
    public function isPrimeiroAcesso($login){
        $usuario = $this->getUsuario($login);
        return $usuario->isPrimeiroAcesso();
    }
    
    public function verificarSeEstaLogado($usuario){
        if (!$this->daoUsuario->existeLoginSenha($usuario)){
           throw new Exception("Voce nao esta logado no sistema"); 
        }
    }

    private function getUsuario($login){
        $listaUsuarios = $this->getListaUsuarios();
        foreach ($listaUsuarios as $usuario) {
            if ($usuario->getLogin() == $login) {
                return $usuario;
            }
        }
        
        throw new Exception("Usuario nao cadastrado");
    }
    
    public function getListaUsuarios(){
        return $this->daoUsuario->getListaUsuarios();
    }
    
    public function __destruct() {
        $this->daoUsuario = null;
    }
    
    
}
?>
<?php

use Exception;

$pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

require_once $pathRaiz . '/model/Usuario.php';
require_once $pathRaiz . '/dao/DaoUsuario.php';

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
        $this->daoUsuario = new DaoUsuario();
    }
    
    public function cadastrar($usuario){
        $this->daoUsuario->cadastrar($usuario);
    }
    
    public function alterarSenha($login, $antigaSenha, $novaSenha){        
        $usuario = $this->getUsuario($login);
        if($usuario->getSenha() != $antigaSenha){
            throw new Exception("Senha Invalida!");
        }
        
        $this->daoUsuario->alterarSenha($usuario, $novaSenha);
        $usuario->setSenha($novaSenha);
        $this->setUsuarioLogado($usuario);
        
        if($this->isPrimeiroAcesso($login)){
            $this->fazerPrimeiroAcesso($login, $novaSenha);
        }
    }
        
    public function fazerLogin($login, $senha){
        $usuario = new Usuario($login, $senha);
        $this->fazerLoginUsuario($usuario);
    }
    
    private function fazerPrimeiroAcesso($login, $senha){
        $usuario = $this->getUsuario($login);
        if($usuario->getSenha() != $senha){
            throw new Exception("Usuario nao cadastrado");
        }
        
        $this->daoUsuario->fazerPrimeiroAcesso($usuario);
    }
    
    public function getUsuarioLogado(){
        $login = $_COOKIE["login"];
        $senha = $_COOKIE["senha"];
                
        $usuario = $this->getUsuario($login);
        
        if($usuario->getSenha() != $senha){
            throw new Exception("VVVVoce nao esta cadastrado no sistema");
        }
        
        return $usuario;
    }
    
    private function setUsuarioLogado($usuario){
        setcookie("login", $usuario->getLogin());
        setcookie("senha", $usuario->getSenha());
    }
    
    private function fazerLoginUsuario($usuario){
        if ( !$this->daoUsuario->existeLoginSenha($usuario)){
            throw new Exception("Usuario nao cadastrado, ou senha incorreta.");
        }
        
        $this->setUsuarioLogado($usuario);
    }
    
    public function isPrimeiroAcesso($login){
        $usuario = $this->getUsuario($login);
        return $usuario->isPrimeiroAcesso();
    }
    
    public function verificarSeEstaLogado(){
        $usuario = $this->getUsuarioLogado();
        
        if (!$this->daoUsuario->existeLoginSenha($usuario)){
           throw new Exception("Voce nao esta logado no sistema"); 
        }
        
        if ($usuario) {
            return true;
        } else {
            return false;
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
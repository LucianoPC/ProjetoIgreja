<?php

use Exception;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoUsuario
 *
 * @author luciano
 */
class DaoUsuario {
    
    private $ERRO_CADASTRAR = "Nao foi possivel cadastrar o usuario.
                               Informe o Administrador.";
    private $ERRO = "Nao foi possivel se comunicar com o Banco de Dados.
                     Informe o Administrador.";
    private $ERRO_USUARIO_INEXISTENTE = "Usuario nao existe";
    private $ERRO_USUARIO_EXISTENTE = "Usuario ja existe";
    private $ERRO_ALTERAR_SENHA = "Nao foi possivel alterar a senha";
    
    private $conexaoComBanco;
    
    public function __construct() {
        $this->includes();
        $this->conexaoComBanco = new ConexaoComBanco();
    }
    
    public function includes(){
        include_once 'ConexaoComBanco.php';
    }
    
    public function cadastrar($usuario){
        if ($this->existeLogin($usuario)) {
            throw new Exception($this->ERRO_USUARIO_EXISTENTE);
        }
        
        $query = $this->getQueryCadastro($usuario);
        $this->executarQuery($query, $this->ERRO_CADASTRAR);
    }
    
    public function alterarSenha($usuario, $novaSenha){
        if (!$this->existeLogin($usuario)) {
            throw new Exception($this->ERRO_USUARIO_INEXISTENTE);
        }
        
        $query = $this->getQueryAlterarSenha($usuario, $novaSenha);
        $this->executarQuery($query, $this->ERRO_ALTERAR_SENHA);
    }

    public function existeLoginSenha($usuario){
        if ( ($this->existeLogin($usuario)) && ($this->existeSenha($usuario)) ){
            return true;
        }else{
            return false;
        }
    }

    
    public function existeLogin($usuario){
        $listaUsuarios = $this->getListaUsuarios();
        
        foreach ($listaUsuarios as $u) {
            if ($u->getLogin() == $usuario->getLogin()) {
                return true;
            }
        }
        
        return false;
    }
    
    public function existeSenha($usuario){
        $listaUsuarios = $this->getListaUsuarios();
        
        foreach ($listaUsuarios as $u) {
            if ($u->getSenha() == $usuario->getSenha()) {
                return true;
            }
        }
        return false;
    }
    
    public function getListaUsuarios(){
        $query = $this->getQueryListaUsuarios();
        $resultadoQuery = $this->executarQuery($query);
        
        if (!$resultadoQuery) {
            throw new Exception($this->ERRO);
        }
        
        $lista = array();
        
        for ($i = 0; $i < mysql_num_rows($resultadoQuery); $i++){
            $login = mysql_result($resultadoQuery , $i, "login");
            $senha = mysql_result($resultadoQuery , $i, "senha");
            $primeiroAcesso = mysql_result($resultadoQuery , $i, "primeiroAcesso");
            
            if($primeiroAcesso == 1){
                $primeiroAcesso = true;
            }else{
                $primeiroAcesso = false;
            }
            
            $usuario = new Usuario($login, $senha, $primeiroAcesso);
            array_push($lista, $usuario);
        }
        
        return $lista;
    }
    
    private function executarQuery($query, $mensagemErro){
        $this->conexaoComBanco->iniciarConexao();
        $resultadoQuery = mysql_query($query);
        $this->conexaoComBanco->finalizarConexao();
        
        if (!$resultadoQuery) {
            throw new Exception($mensagemErro);
        }
        
        return $resultadoQuery;
    }
    
    private function getQueryCadastro($usuario){
        $query = "INSERT INTO `t_usuario` VALUES (";
        $query .= "'" . $usuario->getLogin() . "', ";
        $query .= "'" . $usuario->getSenha() . "', ";
        $query .= "'1')";

        return $query;
    }
    
    private function getQueryListaUsuarios(){
        $query = "SELECT * FROM `t_usuario`";
        
        return $query;
    }
    
    private function getQueryAlterarSenha($usuario, $novaSenha){
        $query = "UPDATE `t_usuario` SET ";
        $query .= "`senha` = '" . $novaSenha . "' ";
        $query .= "WHERE login = '" . $usuario->getLogin() . "'";

        return $query;
    }
    
}
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
 * Description of DaoUsuario
 *
 * @author luciano
 */
class DaoUsuario {
    
    private $ERRO_CADASTRAR = "Nao foi possivel cadastrar o usuario.
                               Informe o Administrador.";
    private $ERRO = "Erro na comunicação com o Banco de Dados. Informe o Administrador.";
    private $ERRO_USUARIO_INEXISTENTE = "Usuario nao existe";
    private $ERRO_USUARIO_EXISTENTE = "Usuario ja existe";
    private $ERRO_ALTERAR_SENHA = "Nao foi possivel alterar a senha";
    
    private $conexaoComBanco;
    
    public function __construct() {
        $this->conexaoComBanco = new ConexaoComBanco();
    }    
    
    public function cadastrar($usuario){
        if ($this->existeLogin($usuario)) {
            throw new Exception($this->ERRO_USUARIO_EXISTENTE);
        }
        
        $query = $this->getQueryCadastro($usuario);
        
        $this->conexaoComBanco->executarQuery($query, $this->ERRO_CADASTRAR);
    }
    
    public function alterarSenha($usuario, $novaSenha){        
        if (!$this->existeLoginSenha($usuario)) {
            throw new Exception($this->ERRO_USUARIO_INEXISTENTE);
        }
        
        $query = $this->getQueryAlterarSenha($usuario, $novaSenha);
        $this->conexaoComBanco->executarQuery($query, $this->ERRO_ALTERAR_SENHA);
    }
    
    public function fazerPrimeiroAcesso($usuario){
        if (!$this->existeLoginSenha($usuario)) {
            throw new Exception($this->ERRO_USUARIO_INEXISTENTE);
        }
        
        $query = $this->getQueryFazerPrimeiroAcesso($usuario);
        $this->conexaoComBanco->executarQuery($query, $this->ERRO);
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
        $resultadoQuery = $this->conexaoComBanco->executarQuery($query, $this->ERRO);
        
        $lista = array();
        
        for ($i = 0; $i < mysql_num_rows($resultadoQuery); $i++){
            $login = mysql_result($resultadoQuery , $i, "login");
            $senha = mysql_result($resultadoQuery , $i, "senha");
            $primeiroAcesso = mysql_result($resultadoQuery , $i, "primeiroAcesso");
                        
            $usuario = new Usuario($login, $senha, $primeiroAcesso);
            
            array_push($lista, $usuario);
        }
        
        return $lista;
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
    
    private function getQueryFazerPrimeiroAcesso($usuario){
        $query = "UPDATE `t_usuario` SET ";
        $query .= "`primeiroAcesso` = '0' ";
        $query .= "WHERE login = '" . $usuario->getLogin() . "'";
        
        return $query;
    }
    
    //UPDATE  `projetoigreja`.`t_usuario` SET  `primeiroAcesso` =  '0' WHERE  `t_usuario`.`login` =  'luciano_prestes';

}
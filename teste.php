<?php
ob_start();
session_start();

include 'dao/ConexaoComBanco.php';
include 'dao/DaoUsuario.php';
include 'model/Usuario.php';

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            
            $login = "Luciano";
            $senha = "123";
            $usuario = new Usuario($login, $senha);
            
            echo "Usuario Instanciado <br> <br>";
            echo "Login: " . $usuario->getLogin() . "<br>";
            echo "Senha: " . $usuario->getSenha() . "<br>";
            
            $daoUsuario = new DaoUsuario();
            echo "<br>DaoUsuario Instanciado <br>";
            
            try{
                $daoUsuario->cadastrar($usuario);
                echo "Usuario Cadastrado";
            } catch (Exception $e){
                echo "<br>" . $e->getMessage() . "<br>";
            }
            
            try{
                $daoUsuario->alterarSenha($usuario, "987");
                echo "Senha Alterada";
            } catch (Exception $e){
                echo "<br>" . $e->getMessage() . "<br>";
            }
            
            try{
                $lista = $daoUsuario->getListaUsuriarios();
                echo "<br><br>Lista de Usuarios Carregada <br>";
                $sizeLista = count($lista);
                echo "Imprimindo usuarios: <br>";

                for($i = 0; $i < $sizeLista; $i++){
                    echo "<br> i = " . $i . "<br>";
                    echo "Login: " . $lista[$i]->getLogin() . "<br>";
                    echo "Senha: " . $lista[$i]->getSenha() . "<br>";
                }
            } catch (Exception $e){
                echo "<br>" . $e->getMessage() . "<br>";
            }
            
        ?>
    </body>
</html>

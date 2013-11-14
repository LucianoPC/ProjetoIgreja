<?php
ob_start();
session_start();


require_once './control/ControleUsuario.php';
require_once 'model/Usuario.php';

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
            
            $login = "luciano_prestes";
            $senha = "123";
            $usuario = new Usuario($login, $senha);
            
            echo "Usuario Instanciado <br> <br>";
            echo "Login: " . $usuario->getLogin() . "<br>";
            echo "Senha: " . $usuario->getSenha() . "<br>";
            
            
            try{
                $controleUsuario = new ControleUsuario();
                echo "<br>ControleUsuario Instanciado <br>";
            } catch (Exception $e){
                echo "<br>" . $e->getMessage() . "<br>";
            }
            
            
            try{
                $controleUsuario->cadastrar($usuario);
                echo "Usuario Cadastrado";
            } catch (Exception $e){
                echo "<br>" . $e->getMessage() . "<br>";
            }
            
            
            try{
                $controleUsuario->alterarSenha($usuario, "453");
                echo "Senha Alterada";
            } catch (Exception $e){
                echo "<br>" . $e->getMessage() . "<br>";
            }
            
            
            
            try{
                $lista = $controleUsuario->getListaUsuarios();
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
            
            $resultadoMD5 = md5("luciano_prestes");
            echo "<br><br>";
            echo "resultadoMD5: " . $resultadoMD5;
            
        ?>
    </body>
</html>

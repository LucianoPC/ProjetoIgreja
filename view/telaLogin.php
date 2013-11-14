<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    $pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

    require_once $pathRaiz . '/control/ControleUsuario.php';
    require_once $pathRaiz . '/model/Alerta.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
                
        <form action="" method="POST">
            <table>
                <tr>
                    <td> Login: </td>
                    <td> <input type="text" name="login" maxlength="45" size="15"/> </td> 
                </tr>
                <tr>
                    <td> Senha: </td>
                    <td> <input type="password" name="senha" maxlength="20" size="15" /> </td> 
                </tr>
                <tr>
                    <td> </td>
                    <td> <p align="right"> <input type="submit" value="Entrar" name="entrar" /> </p> </td>
                </tr>
            </table>
        </form>
        
        <?php
            function fazerLogin()
            {
                try{
                    $controleUsuario = new ControleUsuario();
                    
                    $controleUsuario->fazerLogin($_POST['login'], $_POST['senha']);         
                                        
                    if ($controleUsuario->isPrimeiroAcesso($_COOKIE['login'])) {
                        $pathRaiz = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
                        header('Location: ' . $pathRaiz . '/view/telaAlterarSenha.php');
                    }
                    
                } catch (Exception $ex) {
                    Alerta::alertar($ex->getMessage());
                }
            }
            if(isset($_POST['entrar']))
            {
                $_POST['senha'] = md5($_POST['senha']);
                fazerLogin();
            } 
        ?>
        
    </body>
</html>

<?php
    ob_start();
    session_start();

    $pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

    require_once $pathRaiz . '/control/ControleUsuario.php';
    require_once $pathRaiz . '/model/Alerta.php';
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
            try {
                $controleUsuario = new ControleUsuario();
                
                try {
                    $controleUsuario->verificarSeEstaLogado();
                } catch (Exception $ex) {
                    $pathRaiz = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
                    header('Location: ' . $pathRaiz . '/view/telaLogin.php');
                }
                
                if ($controleUsuario->isPrimeiroAcesso($_COOKIE['login'])) {
                    echo "<br>Esse é o seu primeiro acesso, altere sua senha. <br> <br>";
                }
            
            } catch (Exception $e) {
                Alerta::alertar($e->getMessage());
            }            
        ?>
        
        <form action="" method="POST">
            <table>
                <tr>
                    <td> Login: </td>
                    <td> <?php echo $_COOKIE['login'];?> </td> 
                    </tr>
                <tr>
                    <td> Senha: </td>
                    <td> <input type="password" name="senha" maxlength="20" size="15" /> </td> 
                </tr>
                <tr>
                    <td> Nova Senha: </td>
                    <td> <input type="password" name="novaSenha" maxlength="20" size="15" /> </td> 
                </tr>
                <tr>
                    <td> Confirmar Senha: </td>
                    <td> <input type="password" name="confirmarSenha" maxlength="20" size="15" /> </td> 
                </tr>
                <tr>
                    <td> <p align="left"> <input type="submit" value="Voltar" name="voltar" /> </td>
                    <td> <p align="right"> <input type="submit" value="Confirmar" name="confirmar" /> </p> </td>
                </tr>
            </table>
        </form>
        
        <?php
            function alterarSenha()
            {
                try{
                    $controleUsuario = new ControleUsuario();
                    
                    if($_POST['novaSenha'] != $_POST['confirmarSenha']) {
                        throw new Exception("Confirmação da nova senha está"
                                          . " diferente da nova senha");
                    }
                    
                    $controleUsuario->alterarSenha($_COOKIE['login'], $_POST['senha'], $_POST['novaSenha']);
                    
                    Alerta::alertar("Senha alterada com sucesso!");
                    
                } catch (Exception $ex) {
                    Alerta::alertar($ex->getMessage());
                }
            }
            
            if(isset($_POST['voltar']))
            {
                $pathRaiz = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
                header('Location: ' . $pathRaiz . '/view/telaMenuPrincipal.php');
            }
            
            if(isset($_POST['confirmar']))
            {
                $_POST['senha'] = md5($_POST['senha']);                
                $_POST['novaSenha'] = md5($_POST['novaSenha']);
                $_POST['confirmarSenha'] = md5($_POST['confirmarSenha']);
                
                alterarSenha();
            } 
        ?>
        
    </body>
</html>

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
                $pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
                
                require_once $pathRaiz . '/control/ControleUsuario.php';
                        
                try{
                    $controleUsuario = new ControleUsuario();
                    
                    $controleUsuario->fazerLogin($_POST['login'], $_POST['senha']);
                    
                    echo '  <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
                                alert ("Login realizado com sucesso!");
                            </SCRIPT>';
                    
                } catch (Exception $ex) {
                    echo '  <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
                                alert ("Usuario nao cadastrado, ou a senha esta incorreta.");
                            </SCRIPT>';
                }
            }
            if(isset($_POST['entrar']))
            {
               fazerLogin();
            } 
        ?>
        
    </body>
</html>

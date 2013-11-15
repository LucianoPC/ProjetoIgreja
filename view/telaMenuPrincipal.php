<?php
    ob_start();
    session_start();

    $pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

    require_once $pathRaiz . '/control/ControleUsuario.php';
    require_once $pathRaiz . '/model/Alerta.php';
    
    $_SESSION['pathRaiz'] = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
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
                    header('Location: ' . $_SESSION['pathRaiz'] . '/view/telaLogin.php');
                }
                
            } catch (Exception $e) {
                Alerta::alertar($e->getMessage());
            }            
        ?>
        
        
        <h2> Menu Principal <br> </h2>
        
        <p> Usuario: <?php echo $_COOKIE['login']?> </p>
        
        <br>
        
        <p> Opções: </p>
        <p> <a href=" <?php echo $_SESSION['pathRaiz'] . "/view/telaAlterarSenha.php" ?>"> Alterar Senha </a> </p>
        <p> <a href=" <?php echo $_SESSION['pathRaiz'] . "/view/telaCadastrarPessoa.php" ?>"> Cadastrar Pessoa </a> </p>
        <p> <a href=" <?php echo $_SESSION['pathRaiz'] . "/view/telaConsultarPessoas.php" ?>"> Consultar Pessoa </a> </p>
        
        <br>
        
        <form action="" method="POST">
            <input type="submit" value="Sair" name="sair" />
        </form>
        
        <?php
            if (isset($_POST['sair'])) {
                try {
                    $controleUsuario = new ControleUsuario();
                    $controleUsuario->sair();
                    
                    $pathRaiz = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
                    header('Location: ' . $pathRaiz . '/view/telaLogin.php');
                    
                } catch (Exception $e) {
                    Alerta::alertar($e->getMessage());
                }  
            }
        ?>
    </body>
</html>

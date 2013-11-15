<?php
    ob_start();
    session_start();

    $pathRaiz = $_SERVER['DOCUMENT_ROOT']. substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));

    require_once $pathRaiz . '/control/ControleUsuario.php';
    require_once $pathRaiz . '/control/ControlePessoa.php';
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
        
        <h2> Consultar Pessoa <br> </h2>
        
        <form action="" method="POST">
            
            <table>
                <tr>
                    <td> Ordenar por: </td>
                    <td> <input type="radio" name="tipoConsulta" value="nome" <?php if($_POST['tipoConsulta'] == "nome" || !isset($_POST['tipoConsulta'])){echo 'checked';} ?> > Nome </td>
                    <td> <input type="radio" name="tipoConsulta" value="cidade" <?php if($_POST['tipoConsulta'] == "cidade"){echo 'checked';} ?> > Cidade </td> 
                    <td> <input type="radio" name="tipoConsulta" value="estado" <?php if($_POST['tipoConsulta'] == "estado"){echo 'checked';} ?> > Estado </td> 
                    <td> <input type="radio" name="tipoConsulta" value="cep" <?php if($_POST['tipoConsulta'] == "cep"){echo 'checked';} ?> > CEP </td> 
                    <td> <input type="radio" name="tipoConsulta" value="telefone1" <?php if($_POST['tipoConsulta'] == "telefone1"){echo 'checked';} ?> > Telefone 1 </td> 
                    <td> <input type="radio" name="tipoConsulta" value="telefone2" <?php if($_POST['tipoConsulta'] == "telefone2"){echo 'checked';} ?> > Telefone 2 </td> 
                    <td> <input type="radio" name="tipoConsulta" value="telefone3" <?php if($_POST['tipoConsulta'] == "telefone3"){echo 'checked';} ?> > Telefone 3 </td> 
                    <td> <input type="radio" name="tipoConsulta" value="email" <?php if($_POST['tipoConsulta'] == "email"){echo 'checked';} ?> > E-mail </td> 
                    <td> <input type="radio" name="tipoConsulta" value="estadocivil" <?php if($_POST['tipoConsulta'] == "estadocivil"){echo 'checked';} ?> > Estado Civil </td> 
                </tr>
            </table>
            
            <table>
                <tr>
                    <td> Consulta: </td>
                    <td> <input type="text" name="consulta" maxlength="50" size="15" value="<?php echo $_POST['nome']?>" /> </td>   
                </tr>                
                <tr>
                    <td> <p align="left"> <input type="submit" value="Consultar" name="btnConsultar" /> </p> </td>
                    <td> <p align="right"> <input type="submit" value="Voltar" name="voltar" /> </p> </td>
                </tr>
            </table>
        </form>
        
        <?php
            if (isset($_POST['voltar'])) {
                $pathRaiz = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
                header('Location: ' . $pathRaiz . '/view/telaMenuPrincipal.php');
            }
                        
            if (isset($_POST['btnConsultar'])) {
                
                try {
                    $controlePessoa = new ControlePessoa();
                    $_POST['resultado'] = array();

                    if (trim($_POST['consulta']) == "") {
                        $_POST['resultado'] = $controlePessoa->getListaPessoas($_POST['tipoConsulta']);
                    } else {
                        $_POST['resultado'] = $controlePessoa->getListaConsultaNome($_POST['consulta'], $_POST['tipoConsulta']);     
                    }
                    
                    
                } catch (Exception $ex) {
                    Alerta::alertar($ex->getMessage());
                }
                
            }
        ?>
        
        <table border="1">
            <tr>
                <td> Nome </td>
                <td> Cidade </td>
                <td> Estado </td>
                <td> Cep </td>
                <td> Telefone 1 </td>
                <td> Telefone 2 </td>
                <td> Telefone 3 </td>
                <td> Email </td>
                <td> Estado Civil </td>
            </tr>
            <?php
                $lista = $_POST['resultado'];
                $tamanhoLista = count($lista);
                for ($i = 0; $i < $tamanhoLista; $i++) {
                    echo '  <tr>
                                <td>' . $lista[$i]->getNome() . ' </td>
                                <td>' . $lista[$i]->getCidade() . ' </td>
                                <td>' . $lista[$i]->getEstado() . ' </td>
                                <td>' . $lista[$i]->getCep() . ' </td>
                                <td>' . $lista[$i]->getTelefone1() . ' </td>
                                <td>' . $lista[$i]->getTelefone2() . ' </td>
                                <td>' . $lista[$i]->getTelefone3() . ' </td>
                                <td>' . $lista[$i]->getEmail() . ' </td>
                                <td>' . $lista[$i]->getEstadocivil() . ' </td>
                            </tr>';
                }
            ?>
        </table>
        
    </body>
</html>

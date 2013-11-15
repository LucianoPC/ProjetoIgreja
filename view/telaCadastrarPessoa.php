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
        
        <?php
            if (isset($_POST['limpar'])) {
                $_POST['nome'] = "";
                $_POST['cidade'] = "";
                $_POST['estado'] = "";
                $_POST['cep'] = "";
                $_POST['telefone1'] = "";
                $_POST['telefone2'] = "";
                $_POST['telefone3'] = "";
                $_POST['email'] = "";
                $_POST['estadoCivil'] = "";
            }
            
            if(isset($_POST['voltar']))
            {
                $pathRaiz = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
                header('Location: ' . $pathRaiz . '/view/telaMenuPrincipal.php');
            }
            
            if (isset($_POST['cadastrar'])) {
                try {
                    $controlePessoa = new ControlePessoa();
                    
                    $controlePessoa->cadastrar($_POST['nome'], $_POST['cidade'],
                            $_POST['estado'], $_POST['cep'], $_POST['telefone1'], 
                            $_POST['telefone2'], $_POST['telefone3'], 
                            $_POST['email'], $_POST['estadoCivil']);
                    
                    Alerta::alertar("Pessoa cadastrada com sucesso!");
                    
                } catch (Exception $ex) {
                    Alerta::alertar($ex->getMessage());
                }
            } 
        ?>
        
        <h2> Cadastrar Pessoa <br> </h2>
        
        <form action="" method="POST">
            <table>
                <tr>
                    <td> Nome: </td>
                    <td> <input type="text" name="nome" maxlength="50" size="15" value="<?php echo $_POST['nome']?>" /> </td> 
                </tr>
                <tr>
                    <td> Cidade: </td>
                    <td> <input type="text" name="cidade" maxlength="50" size="15" value="<?php echo $_POST['cidade']?>" /> </td> 
                </tr>
                <tr>
                    <td> Estado: </td>
                    <td>
                        <select size="1" name="estado">
                            <option></option>
                            <option>AC</option>
                            <option>AL</option>
                            <option>AP</option>
                            <option>AM</option>
                            <option>BA</option>
                            <option>CE</option>
                            <option>DF</option>
                            <option>ES</option>
                            <option>GO</option>
                            <option>MA</option>
                            <option>MT</option>
                            <option>MS</option>
                            <option>MG</option>
                            <option>PA</option>
                            <option>PB</option>
                            <option>PR</option>
                            <option>PE</option>
                            <option>PI</option>
                            <option>RN</option>
                            <option>RS</option>
                            <option>RJ</option>
                            <option>RO</option>
                            <option>RR</option>
                            <option>SC</option>
                            <option>SP</option>
                            <option>SE</option>
                            <option>TO</option>
                        </select> 
                    </td> 
                </tr>
                <tr>
                    <td> CEP: </td>
                    <td> <input type="text" name="cep" maxlength="15" size="15" value="<?php echo $_POST['cep']?>" /> </td>
                </tr>
                <tr>
                    <td> Telefone 1: </td>
                    <td> <input type="text" name="telefone1" maxlength="25" size="15" value="<?php echo $_POST['telefone1']?>" /> </td>
                </tr>
                <tr>
                    <td> Telefone 2: </td>
                    <td> <input type="text" name="telefone2" maxlength="25" size="15" value="<?php echo $_POST['telefone2']?>" /> </td>
                </tr>
                <tr>
                    <td> Telefone 3: </td>
                    <td> <input type="text" name="telefone3" maxlength="25" size="15" value="<?php echo $_POST['telefone3']?>" /> </td>
                </tr>
                <tr>
                    <td> E-mail: </td>
                    <td> <input type="text" name="email" maxlength="255" size="15" value="<?php echo $_POST['email']?>" /> </td>
                </tr>
                <tr>
                    <td> Estado Civil: </td>
                    <td>
                        <select size="1" name="estadoCivil">
                            <option> </option>
                            <option>Solteiro</option>
                            <option>Casado</option>
                        </select> 
                    </td> 
                </tr>
                <tr>
                    <td> </td>
                    <td> <p align="right"> <input type="submit" value="Cadastrar" name="cadastrar" /> </p> </td>
                </tr>
                <tr>
                    <td> <p align="left"> <input type="submit" value="Voltar" name="voltar" /> </td>
                    <td> <p align="right"> <input type="submit" value="Limpar" name="limpar" /> </p> </td>
                </tr>
                
                
            </table>
        </form>
        
        
    </body>
</html>

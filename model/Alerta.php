<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alerta
 *
 * @author luciano
 */
class Alerta {
    
    static function alertar($mensagem){
        echo '  <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
                    alert ("' . $mensagem . ' ");
                </SCRIPT>';
    }
    
}

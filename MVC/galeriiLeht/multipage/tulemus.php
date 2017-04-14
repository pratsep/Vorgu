<?php
    require_once('head.html');

    if(!empty($_GET)){
        $messages = array();
        if(!empty($_GET["pilt"])) {
            $messages[] = "Valisid pildi number {$_GET["pilt"]}";
        }
    } else {
        $messages[] = "Valikut pole tehtud";
    }
    echo '<h3>Valiku tulemus</h3>';
    if(!empty($messages)){
        foreach($messages as $message){
            echo $message;
            echo '<br/>';
        }
    }
    require_once('foot.html');
?>
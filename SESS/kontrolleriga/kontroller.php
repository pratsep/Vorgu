<?php
    session_start();
    require_once('head.html');
    $pildid = array (
        array("src" => "pildid/nameless1.jpg", "alt" => "nimetu 1"),
        array("src" => "pildid/nameless2.jpg", "alt" => "nimetu 2"),
        array("src" => "pildid/nameless3.jpg", "alt" => "nimetu 3"),
        array("src" => "pildid/nameless4.jpg", "alt" => "nimetu 4"),
        array("src" => "pildid/nameless5.jpg", "alt" => "nimetu 5"),
        array("src" => "pildid/nameless6.jpg", "alt" => "nimetu 6")
    );
    if(!empty($_GET)){
        $page = htmlspecialchars($_GET['page']);
    }
    else{
        $page = "pealeht";
    }
    switch($page){
        case "pealeht":
            include("pealeht.html");
            break;
        case "galerii":
            include("galerii.html");
            break;
        case "vote":
            if(!isset($_SESSION['voted_for'])){
                include ("vote.html");
            } else {
                include ("tulemus.html");
            }
            break;
        case "endSession":
            $_SESSION = array();
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-42000, '/');
            }
            session_destroy();
            include ("pealeht.html");
        case "tulemus":
            include("tulemus.html");
            break;
        default:
            include("pealeht.html");
            break;
    }
    require_once("foot.html");
?>
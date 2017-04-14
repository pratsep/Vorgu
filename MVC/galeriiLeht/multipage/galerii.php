<?php
    require_once('head.html');

    $pildid = array (
        array("src" => "pildid/nameless1.jpg", "alt" => "nimetu 1"),
        array("src" => "pildid/nameless2.jpg", "alt" => "nimetu 2"),
        array("src" => "pildid/nameless3.jpg", "alt" => "nimetu 3"),
        array("src" => "pildid/nameless4.jpg", "alt" => "nimetu 4"),
        array("src" => "pildid/nameless5.jpg", "alt" => "nimetu 5"),
        array("src" => "pildid/nameless6.jpg", "alt" => "nimetu 6")
    );
	echo '<h3>Fotod</h3>';
	echo '<div id="gallery">';
    foreach ($pildid as $pilt){
        echo '<img src="'.$pilt['src'].'" alt="'.$pilt['alt'].'" />';
    }
	echo '</div>';

    require_once('foot.html');
?>
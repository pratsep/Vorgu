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
	echo '<h3>Vali oma lemmik :)</h3>';
	echo '<form action="tulemus.php" method="GET">';
	$mitu = 1;
    foreach ($pildid as $pilt){
        echo '<p>';
        echo '<label for="p'.$mitu.'">';
        echo '<img src="'.$pilt["src"].'" alt="'.$pilt["alt"].'" height="100" />';
        echo '</label>';
        echo '<input type="radio" value="'.$mitu.'" id="p'.$mitu.'" name="pilt"/>';
        echo '</p>';
        $mitu=$mitu+1;
    }
		echo '<br/>';
		echo '<input type="submit" value="Valin!"/>';
	    echo '</form>';
    require_once('foot.html');
?>
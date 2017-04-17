<?php
$tekst="";
if (isset($_POST['tekst']) && $_POST['tekst']!="") {
    $tekst=htmlspecialchars($_POST['tekst']);
}
$taustavarv="#fff";
if (isset($_POST['taustavarv']) && $_POST['taustavarv']!="") {
    $taustavarv=htmlspecialchars($_POST['taustavarv']);
}
$tekstivarv="#000000";
if (isset($_POST['tekstivarv']) && $_POST['tekstivarv']!="") {
    $tekstivarv=htmlspecialchars($_POST['tekstivarv']);
}
$piirjoonepaksus="0";
if (isset($_POST['piirjoonepaksus']) && $_POST['piirjoonepaksus']!="") {
    $piirjoonepaksus=htmlspecialchars($_POST['piirjoonepaksus']);
}
$piirjoonestiil="solid";
if (isset($_POST['piirjoonestiil']) && $_POST['piirjoonestiil']!="") {
    $piirjoonestiil=htmlspecialchars($_POST['piirjoonestiil']);
}
$piirjoonevarv="#000000";
if (isset($_POST['piirjoonevarv']) && $_POST['piirjoonevarv']!="") {
    $piirjoonevarv=htmlspecialchars($_POST['piirjoonevarv']);
}
$piirjoonenurk="0";
if (isset($_POST['piirjoonenurk']) && $_POST['piirjoonenurk']!="") {
    $piirjoonenurk=htmlspecialchars($_POST['piirjoonenurk']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Valik</title>
    <style type="text/css">
        .output {
            padding:5px;
            margin:3px;
            width: 300px;
            height: 200px;
            background-color: <?php echo $taustavarv; ?>;
            border-width: <?php echo $piirjoonepaksus; ?>px;
            border-style: <?php echo $piirjoonestiil; ?>;
            border-color: <?php echo $piirjoonevarv; ?>;
            border-radius: <?php echo $piirjoonenurk; ?>px;

        }
        #piirjoon {
            padding:5px;
            margin:3px;
            width: 300px;
            height: 100px;
            border: solid black 1px;
        }
        #mudru {
            color: <?php echo $tekstivarv; ?>;
        }
    </style>
</head>
<body>
    <div class="output">
        <p id="mudru"><?php echo $tekst; ?></p>
    </div>
    <form method="post">
        Sisesta tekst</br>
        <input type="text" name="tekst" value="<?php echo $tekst ?>"></br>
        Vali taustavärvus</br>
        <input type="color" name="taustavarv" value="<?php echo $taustavarv ?>"></br>
        Vali teksti värvus</br>
        <input type="color" name="tekstivarv" value="<?php echo $tekstivarv ?>"></br>
        Piirjoon</br>
        <div id="piirjoon">
            <input type="number" name="piirjoonepaksus" min="1" max="5" value="<?php echo $piirjoonepaksus ?>">Vali piirjoone paksus(1-5px)</br>
            <select name="piirjoonestiil">
                <option value="solid" <?php if($piirjoonestiil == "solid") echo "selected"; ?>>Solid</option>
                <option value="dotted" <?php if($piirjoonestiil == "dotted") echo "selected"; ?>>Dotted</option>
                <option value="dashed" <?php if($piirjoonestiil == "dashed") echo "selected"; ?>>Dashed</option>
                <option value="double" <?php if($piirjoonestiil == "double") echo "selected"; ?>>Double</option>
            </select>Piirjoone stiil</br>
            <input type="color" name="piirjoonevarv" value="<?php echo $piirjoonevarv ?>">Piirjoone värvus</br>
            <input type="number" name="piirjoonenurk" min="0" max="20" value="<?php echo $piirjoonenurk ?>">Piirjoone nurga raadius(0-20px)</br>
        </div>
        <input type="submit" value="Postita">
    </form>
</body>
</html>

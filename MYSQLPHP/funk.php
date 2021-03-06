<?php

function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){
    global $connection;
    $errors = array();
    if(isset($_SESSION['user'])){
        header('Location: ?page=loomad');
        exit();
    }
    else{
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST['user']) && !empty($_POST['pass'])){
                $username = mysqli_real_escape_string($connection, $_POST['user']);
                $password = mysqli_real_escape_string($connection, $_POST['pass']);
                $query = "SELECT * FROM pratsep_kylastajad WHERE username = '$username' AND passw = SHA1('$password')";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result)>0){
                    $_SESSION['user'] = htmlspecialchars($row['username']);
                    $_SESSION['roll'] = htmlspecialchars($row['roll']);
                    header("Location: ?page=loomad");
                }
                else{
                    $errors[] = "Vale kasutaja või parool";
                }
            }
            else{
                $errors[] = "Kõik väljad tuleb ära täita";
            }
        }
    }

	include_once('views/login.html');
}

function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}
function muuda(){
    global  $connection;
    if (!isset($_SESSION["user"]) || $_SESSION["roll"] != "admin") {
        header("Location: ?page=login");
        exit();
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET["id"] != ""){
            $id = mysqli_real_escape_string($connection, $_GET["id"]);
            $loom = hangi_loom($id);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['id'] != ""){
            if ($_POST["nimi"] == "") {
                $errors[] = "Nimi on puudu!";
            } elseif ($_POST["puur"] == ""){
                $errors[] = "Puur on puudu!";
            } else {
                $id = mysqli_real_escape_string($connection, $_POST["id"]);
                $loom = hangi_loom($id);
                $nimi = mysqli_real_escape_string($connection, $_POST["nimi"]);
                $puur = mysqli_real_escape_string($connection, $_POST["puur"]);
                if (upload("liik")) {
                    $liik = mysqli_real_escape_string($connection, upload("liik"));
                } else {
                    $liik = $loom['liik'];
                }
                $sql = "UPDATE pratsep_loomaaed SET nimi = '$nimi', puur = '$puur', liik = '$liik' WHERE id = '$id'";
                $result = mysqli_query($connection, $sql);
                header("Location: ?page=loomad");
            }
        }
        else {
            header("Location: ?page=loomad");
        }
    }
    include_once('views/editvorm.html');
}
function hangi_loom($id){
    global $connection;
    $query = "SELECT * FROM pratsep_loomaaed WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result)>0) {
        $loom = mysqli_fetch_assoc($result);
        return $loom;
    } else {
        header("Location: ?page=loomad");
    }
}
function kuva_puurid(){
    $puurid = array();
    //$suva = array();
    global $connection;
    if(empty($_SESSION["user"])){
        header("Location: ?page=login");
    } else {
        $query_1 = "SELECT DISTINCT puur FROM pratsep_loomaaed";
        $result_1 = mysqli_query($connection, $query_1);

        while ($row_1 = mysqli_fetch_assoc($result_1)) {
            //$suva[] = $row_1;
            $query_2 = "SELECT * FROM pratsep_loomaaed WHERE puur=" . $row_1['puur'];
            $result_2 = mysqli_query($connection, $query_2);
            while ($row_2 = mysqli_fetch_assoc($result_2)) {
                $puurid[$row_1['puur']][] = $row_2;
            }
        }
    }

    //echo "<pre>";
    //print_r($puurid);
    //echo "</pre>";
    include_once('views/puurid.html');
}

function lisa(){
    global $connection;
    $errors = array();
    if(!isset($_SESSION['user'])){
        header('Location: ?page=login');
        exit();
    } elseif($_SESSION["roll"] != "admin") {
        header("Location: ?page=loomad");
    } else {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST['nimi']) && !empty($_POST['puur']) && upload('liik') != ""){
                $username = mysqli_real_escape_string($connection, $_POST["nimi"]);
                $cage = mysqli_real_escape_string($connection, $_POST["puur"]);
                $species = mysqli_real_escape_string($connection, upload("liik"));
                $query = "INSERT INTO pratsep_loomaaed(nimi, puur, liik) VALUES ('$username', '$cage', '$species')";
                $loom = mysqli_query($connection, $query);
                if (mysqli_insert_id($connection)) {
                    header("Location: ?page=loomad");
                } else {
                    header("Location: ?page=loomavorm");
                }
            }
            else{
                if(empty($_POST["nimi"])) {
                    $errors[] = "Täitke nime väli";
                }
                if(empty($_POST["puur"])) {
                    $errors[] = "Täitke puuri väli";
                }
                if(upload('liik') == ""){
                    $errors[] = "Pildi lisamine ebõnnestus";
                }
            }
        }
    }
	
	include_once('views/loomavorm.html');
	
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>
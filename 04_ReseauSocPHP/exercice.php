<?php
session_start();
//$_SESSION["first_name"] = "Megh";

if (isset($_GET["first_name"])){
echo "bonjour " . $_GET["first_name"] . "!";
} elseif (isset($_SESSION["first_name"])){
    echo "Bonjour " . $_SESSION["first_name"] . "!";
} elseif (isset($_POST["first_name"]) & ($_POST["first_name"]) != ""){
    echo "Bonjour " . $_POST["first_name"] . "!";
    unset($_SESSION["first_name"]);
    $_SESSION["first_name"] = $_POST["first_name"];
} else {
    echo "Bonjour anonyme !";
}
?>

<form action="exercice.php" method="post">
    <p>Votre nom : <input type="text" name="first_name" /></p>
    <p><input type="submit" value="OK"></p>
    <button tpe = "reset" value "reset">reset button</button>
</form>

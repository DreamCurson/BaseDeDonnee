<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPlante'])) {
    $_SESSION['planteSelectionnee'] = $_POST['idPlante'];
}
header('Location: ../../dreamplante.php');
exit;
?>

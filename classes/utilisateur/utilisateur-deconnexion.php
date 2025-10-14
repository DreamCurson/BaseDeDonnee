<?php
session_start();

$_SESSION = [];

// Enlève toute les informations enregistrer dans la session
session_destroy();

header('Location: ../../index.php');
exit;
?>

<?php 
session_unset();
session_destroy();

header('Location: /Workspace/PongChamp/Web/3.0/index.php');
?>
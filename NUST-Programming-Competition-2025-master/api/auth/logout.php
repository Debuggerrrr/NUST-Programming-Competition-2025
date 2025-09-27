<?php
session_start();
session_unset();
session_destroy();
// Redirect back to site root index
header('Location: /NUST-Programming-Competition-2025-master/index.php');
exit();
?>

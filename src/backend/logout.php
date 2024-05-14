<?php
require '../includes/config.inc.php';
unset($_SESSION['username']);
header("Location: ../index.php");
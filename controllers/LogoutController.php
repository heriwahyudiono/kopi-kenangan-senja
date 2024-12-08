<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_destroy();
    session_unset();
    header("Location: ../index.php");
    exit;
}

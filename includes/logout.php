<?php session_start() ?>
<?php

unset($_SESSION['username']);
unset($_SESSION['firstname']);
unset($_SESSION['lastname']);
unset($_SESSION['role']);

header("Location: ../");
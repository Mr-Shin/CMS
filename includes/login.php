<?php
include "db.php";
session_start();
include "../admin/functions.php";
if (isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $user = mysqli_real_escape_string($connection,$user);
    $pass = mysqli_real_escape_string($connection,$pass);
    $q = "SELECT * FROM users WHERE username = '{$user}'";
    $res = mysqli_query($connection,$q);
    $_SESSION['username'] = $user;
    if (mysqli_num_rows($res)>0){
        while ($row = mysqli_fetch_assoc($res)){
            if (password_verify($pass,$row['password'])){
                $_SESSION['username'] = $row['username'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['role'] = $row['role'];
                header("Location: ../admin");

            }
            else{
                $_SESSION['wrong'] = "Wrong Password";
               header("Location: ../index.php");
            }

        }
    }
    else{
        header("Location: ../index.php");
    }
}
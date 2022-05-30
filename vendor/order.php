<?php
    session_start();
    require_once 'connect.php';

    $d = $_POST['ylkvmom'];
    $someObject = json_decode($d);
    $decodeonce=json_decode($someObject);


    foreach ($decodeonce as $i){

    };

    header('Location: ../form-lesson/thank-you.php');
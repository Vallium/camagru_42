<?php
    include('database.php');


    $schema = 'camagru';
    try {
        $pdo = new PDO($DB_DSN_SETUP, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

//        -- -----------------------------------------------------
//        -- Schema camagru
//        -- -----------------------------------------------------
        $req = "DROP SCHEMA IF EXISTS $schema";
        $pdo->exec($req);
        $req = "CREATE SCHEMA IF NOT EXISTS $schema DEFAULT CHARACTER SET utf8";
        $pdo->exec($req);

//        -- -----------------------------------------------------
//        -- Table camagru.users
//        -- -----------------------------------------------------
        require '../model/UserModel.php';
        \model\UserModel::createTable($pdo, $schema);

//        -- -----------------------------------------------------
//        -- Table camagru.images
//        -- -----------------------------------------------------
        require '../model/ImageModel.php';
        \model\ImageModel::createTable($pdo, $schema);


    } catch (PDOException $e) {
        echo 'Connection failed: '.$e->getMessage();
    }
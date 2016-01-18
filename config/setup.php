<?php
    include('database.php');


    $schema = 'camagru';

    try {
        // $pdo = new PDO($DB_DSN_SETUP, $DB_USER, $DB_PASSWORD);
        $pdo = new PDO('mysql:host=localhost;port=3306', 'root', 'root');

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
        require '../models/UserModel.php';
        \model\UserModel::createTable($pdo, $schema);

//        -- -----------------------------------------------------
//        -- Table camagru.images
//        -- -----------------------------------------------------
        require '../models/ImageModel.php';
        \model\ImageModel::createTable($pdo, $schema);

//        -- -----------------------------------------------------
//        -- Table camagru.likes
//        -- -----------------------------------------------------
        require '../models/LikeModel.php';
        \model\LikeModel::createTable($pdo, $schema);

//        -- -----------------------------------------------------
//        -- Table camagru.comments
//        -- -----------------------------------------------------
        require '../models/CommentModel.php';
        \model\CommentModel::createTable($pdo, $schema);

    } catch (PDOException $e) {
        echo 'Connection failed: '.$e->getMessage();
    }

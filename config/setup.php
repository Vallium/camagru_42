<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    include('database.php');

    $schema = 'camagru';

    echo 'Initialisation of Camagru website';

    try {
        $pdo = new PDO($DB_DSN_SETUP, $DB_USER, $DB_PASSWORD);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//        -- -----------------------------------------------------
//        -- Schema camagru
//        -- -----------------------------------------------------
        $req = "DROP SCHEMA IF EXISTS $schema";
        $pdo->exec($req);
        $req = "CREATE SCHEMA IF NOT EXISTS $schema DEFAULT CHARACTER SET utf8";
        $pdo->exec($req);

        $root = dirname(__DIR__);

        require $root.'/core/Model.php';
//        -- -----------------------------------------------------
//        -- Table camagru.users
//        -- -----------------------------------------------------
        require $root.'/models/UserModel.php';
        \model\UserModel::createTable($pdo, $schema);

//        -- -----------------------------------------------------
//        -- Table camagru.images
//        -- -----------------------------------------------------
        require $root.'/models/ImageModel.php';
        \model\ImageModel::createTable($pdo, $schema);

//        -- -----------------------------------------------------
//        -- Table camagru.likes
//        -- -----------------------------------------------------
        require $root.'/models/LikeModel.php';
        \model\LikeModel::createTable($pdo, $schema);

//        -- -----------------------------------------------------
//        -- Table camagru.comments
//        -- -----------------------------------------------------
        require $root.'/models/CommentModel.php';
        \model\CommentModel::createTable($pdo, $schema);

        echo 'Database initialized with success';

        $files = glob($root.'/web/img/uploads/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }

        echo 'All uploaded files have been deleted with success';

    } catch (PDOException $e) {
        echo 'Connection failed: '.$e->getMessage();
    }
?>
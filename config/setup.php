<?php
    include(__DIR__.'/database.php');

    echo 'You will reset all database and delete all pictures uploaded,'.PHP_EOL;
    echo 'This action is irreversible'.PHP_EOL;
    echo 'Are you sure you want to do this ?! (yes/no)  ';

    flush();
    ob_flush();

    $confirmation  =  trim( fgets( STDIN ) );

    if ($confirmation !== 'yes' && $confirmation !== 'y')
        exit (0);

    echo 'Initialisation of Camagru website'.PHP_EOL;

    try {
        $pdo = new PDO($DB_DSN_SETUP, $DB_USER, $DB_PASSWORD);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
        print 'Connection failed: '.$e->getMessage().PHP_EOL;
        die();
    }

    try {
//        -- -----------------------------------------------------
//        -- Schema camagru
//        -- -----------------------------------------------------
        $req = "DROP SCHEMA IF EXISTS $DB_SCHEMA";
        $pdo->exec($req);
        $req = "CREATE SCHEMA IF NOT EXISTS $DB_SCHEMA DEFAULT CHARACTER SET utf8";
        $pdo->exec($req);
        $req = 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0';
        $pdo->exec($req);
        $req = 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0';
        $pdo->exec($req);
        $req = "SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES'";
        $pdo->exec($req);

        $root = dirname(__DIR__);

        require $root . '/core/Model.php';
//        -- -----------------------------------------------------
//        -- Table camagru.users
//        -- -----------------------------------------------------
        require $root . '/models/UserModel.php';
        \model\UserModel::createTable($pdo, $DB_SCHEMA);

//        -- -----------------------------------------------------
//        -- Table camagru.images
//        -- -----------------------------------------------------
        require $root . '/models/ImageModel.php';
        \model\ImageModel::createTable($pdo, $DB_SCHEMA);

//        -- -----------------------------------------------------
//        -- Table camagru.likes
//        -- -----------------------------------------------------
        require $root . '/models/LikeModel.php';
        \model\LikeModel::createTable($pdo, $DB_SCHEMA);

//        -- -----------------------------------------------------
//        -- Table camagru.comments
//        -- -----------------------------------------------------
        require $root . '/models/CommentModel.php';
        \model\CommentModel::createTable($pdo, $DB_SCHEMA);

        $req = 'SET SQL_MODE=@OLD_SQL_MODE';
        $pdo->exec($req);
        $req = 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS';
        $pdo->exec($req);
        $req = 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS';
        $pdo->exec($req);

    } catch (\PDOException $e) {
        print 'Error in database initialisation'.$e->getMessage().PHP_EOL;
        die();
    }

    echo 'Database initialized with success'.PHP_EOL;

    $files = glob($root.'/web/img/uploads/*'); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file))
            unlink($file); // delete file
    }

    echo 'All uploaded files have been deleted with success'.PHP_EOL;
    echo 'Website deployed with success'.PHP_EOL;
?>
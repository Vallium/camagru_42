<h1>Hello world</h1>
<?php
    include('database.php');

    $schema = 'camagru';
    try {
        $pdo = new PDO($DB_DSN_SETUP, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

//        -- -----------------------------------------------------
//        -- Schema mydb
//        -- -----------------------------------------------------
        $req = "DROP SCHEMA IF EXISTS $schema";
        $pdo->exec($req);
        $req = "CREATE SCHEMA IF NOT EXISTS $schema DEFAULT CHARACTER SET utf8";
        $pdo->exec($req);

//        -- -----------------------------------------------------
//        -- Table `camagru`.`users`
//        -- -----------------------------------------------------
        $req = "DROP TABLE IF EXISTS $schema.users";
        $pdo->exec($req);

        $req = "CREATE TABLE IF NOT EXISTS $schema.users(
                      id INT NOT NULL AUTO_INCREMENT,
                      username VARCHAR(45) NULL,
                      password VARCHAR(255) NULL,
                      email VARCHAR(255) NULL,
                      is_admin TINYINT(1) NULL DEFAULT 0,
                      PRIMARY KEY (id),
                      UNIQUE INDEX username_UNIQUE (username ASC),
                      UNIQUE INDEX email_UNIQUE (email ASC))";
        $pdo->exec($req);

    } catch (PDOException $e) {
        echo 'Connection failed: '.$e->getMessage();
    }
?>
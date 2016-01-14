<?php
namespace model;

class UserModel
{
    private $db;

//    public function findById($id)
//    {
//        $req = 'SELECT * FORM users WHERE id='.(int)$id;
//        $r = $this->db->query($req);
//        return $r->fetchColumn();
//    }

    static function createTable(\PDO $db, $schema = "camagru")
    {
        //Drop
        $req = "DROP TABLE IF EXISTS $schema.users";
        $db->exec($req);

        //Create
        $req = "CREATE TABLE IF NOT EXISTS $schema.users(
                      id INT NOT NULL AUTO_INCREMENT,
                      username VARCHAR(45) NULL,
                      password VARCHAR(255) NULL,
                      email VARCHAR(255) NULL,
                      is_admin TINYINT(1) NULL DEFAULT 0,
                      PRIMARY KEY (id),
                      UNIQUE INDEX username_UNIQUE (username ASC),
                      UNIQUE INDEX email_UNIQUE (email ASC))";
        return $db->exec($req);
    }
}
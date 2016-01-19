<?php
namespace model;

class UserModel extends Model
{
//    private $db;

    protected $table = 'users';

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

    /**
     * @param $obj \item\User
     */
    protected function create(\item\User $obj)
    {
        $req = "INSERT INTO users (username, password, email) VALUE (:username, :password, :email)";

        $this->dbConnexion();
        try {
            $r = $this->db->prepare($req);
            $r->bindValue(':username', $obj->getUsername(), \PDO::PARAM_STR);
            $r->bindValue(':password', $obj->getPassword(), \PDO::PARAM_STR);
            $r->bindValue(':email', $obj->getEmail(), \PDO::PARAM_STR);
            $r->execute();
        } catch (PDOException $e){
            print 'Erreur !:'.$e->getMessage().'<br />';
        }
    }



//    static function add(\PDO $db)
}
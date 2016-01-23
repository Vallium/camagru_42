<?php
namespace model;

class UserModel extends Model
{
    protected $table = 'users';

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
                      created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
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
        $req = "INSERT INTO $this->table (username, password, email) VALUE (:username, :password, :email)";

        $this->dbConnexion();
        try {
            $r = $this->db->prepare($req);
            $r->bindValue(':username', $obj->getUsername(), \PDO::PARAM_STR);
            $r->bindValue(':password', $obj->getPassword(), \PDO::PARAM_STR);
            $r->bindValue(':email', $obj->getEmail(), \PDO::PARAM_STR);
            $r->execute();
        } catch (\PDOException $e){
            print 'Erreur !:'.$e->getMessage().'<br />';
        }
        
    }

    public function find($username) {
        $req = "SELECT * FROM $this->table WHERE username='$username'";

        $this->dbConnexion();
        try {
            $user = $this->db->query($req)->fetch();
        } catch (\PDOException $e) {
            print 'Erreur !:'.$e->getMessage().'<br />';
        }
        if (isset($user))
            return ($user);
        return ('no user with this username');
    }

    public function findById($user_id) {
        $req = "SELECT * FROM $this->table WHERE id='$user_id'";

        $this->dbConnexion();
        try {
            $user = $this->db->query($req)->fetch();
        } catch (\PDOException $e) {
            print 'Erreur !:'.$e->getMessage().'<br />';
        }
        if (isset($user))
            return ($user);
        return ('no user with this id');
    }
}
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
                      is_activated TINYINT(1) NULL DEFAULT 0,
                      security_hash VARCHAR(255) NULL,
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
        $req = "INSERT INTO $this->table (username, password, email, security_hash) VALUE (:username, :password, :email, :security_hash)";

        $this->dbConnexion();
        try {
            $r = $this->db->prepare($req);
            $r->bindValue(':username', $obj->getUsername(), \PDO::PARAM_STR);
            $r->bindValue(':password', $obj->getPassword(), \PDO::PARAM_STR);
            $r->bindValue(':email', $obj->getEmail(), \PDO::PARAM_STR);
            $r->bindValue(':security_hash', $obj->getSecurityHash(), \PDO::PARAM_STR);
            $r->execute();
        } catch (\PDOException $e){
            print 'Erreur !:'.$e->getMessage().'<br />';
        }
        
    }

    /**
     * @param $obj \item\User
     */
    protected function update(\item\User $obj)
    {
        $req = "UPDATE $this->table SET password=:password, is_activated=:is_activated, security_hash=:security_hash WHERE id=:id";

        $a = $obj->getPassword();
        $b = $obj->getIsActivated();
        $c = $obj->getSecurityHash();
        $d = $obj->getId();

        $this->dbConnexion();
        try {
            $up = $this->db->prepare($req);
            $up->bindParam(':password', $a, \PDO::PARAM_STR);
            $up->bindParam(':is_activated', $b, \PDO::PARAM_BOOL);
            $up->bindParam(':security_hash', $c, \PDO::PARAM_STR);
            $up->bindParam(':id', $d, \PDO::PARAM_INT);
            $up->execute();
            $this->dbKill();
        } catch (\PDOException $e) {
            print 'Erreur !:'.$e->getMessage().'<br />';
        }
    }

    public function getById($user_id)
    {
        $req = array(
            'where' => "id=$user_id",
        );

        return $this->get($req);
    }

    public function getByUsername($username)
    {
        $req = array(
            'where' => "username='$username'",
        );

        return $this->get($req);
    }

    public function getByEmail($email)
    {
        $req = array(
            'where' => "email='$email'",
        );

        return $this->get($req, TRUE);
    }
}
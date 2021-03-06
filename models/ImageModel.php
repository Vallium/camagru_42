<?php
namespace model;

class ImageModel extends Model
{
    protected $table = 'images';

    static function createTable(\PDO $db, $schema = "camagru")
    {
        //Drop
        $req = "DROP TABLE IF EXISTS $schema.images";
        $db->exec($req);

        //Create
        $req = "CREATE TABLE IF NOT EXISTS $schema.images (
                    id INT NOT NULL AUTO_INCREMENT,
                    created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                    users_id INT NOT NULL,
                    PRIMARY KEY (id),
                    INDEX fk_images_users_idx (users_id ASC),
                    CONSTRAINT fk_images_users
                    FOREIGN KEY (users_id)
                    REFERENCES $schema.users (id)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)";
        return $db->exec($req);
    }

    /**
     * @param $obj \item\Img
     */
    protected function create(\item\Img $img)
    {
        $req = "INSERT INTO $this->table (users_id) VALUE (:users_id)";

        $this->dbConnexion();
        try {
            $r = $this->db->prepare($req);
            $r->bindValue(':users_id', $img->getUsersId(), \PDO::PARAM_INT);
            $r->execute();
        } catch (\PDOException $e){
            print 'Erreur !:'.$e->getMessage().'<br />';
            die();
        }

    }

    public function getImageById($id)
    {
        $req = array(
            'where' => 'id='.$id
        );

        return $this->get($req);
    }

    public function loadMore($offset = 0, $limit = 0)
    {
        $req = array(
            'order'     => 'created_at DESC',
            'limit'     => $limit,
            'offset'    => $offset
        );
        
        return $this->get($req);
    }

    public function getPics($actual_page, $nb_to_load)
    {
        $req = array (
            'order' => 'created_at DESC',
            'limit' => $nb_to_load,
            'offset' => $nb_to_load * ($actual_page - 1)
        );

        return $this->get($req);
    }

    public function getLast($nb)
    {
        $req = array(
            'order' => 'created_at DESC',
            'limit' => $nb
        );

        return $this->get($req);
    }

    public function getLastByUserId($user_id)
    {
        $req = array(
            'where' => 'users_id='.$user_id,
            'order' => 'created_at DESC'
        );

        return $this->get($req);
    }

    public function deleteImage($id)
    {
        $this->delete($id);
    }

}

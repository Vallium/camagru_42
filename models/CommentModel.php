<?php
namespace model;

class CommentModel extends Model
{
    protected $table = 'comments';

    static function createTable(\PDO $db, $schema = "camagru")
    {
        //Drop
        $req = "DROP TABLE IF EXISTS $schema.comments";
        $db->exec($req);

        //Create
        $req = "CREATE TABLE IF NOT EXISTS $schema.comments (
                    id INT NOT NULL AUTO_INCREMENT,
                    content TEXT NULL,
                    created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                    images_id INT NOT NULL,
                    users_id INT NOT NULL,
                    PRIMARY KEY (id),
                    INDEX fk_comments_images1_idx (images_id ASC),
                    INDEX fk_comments_users1_idx (users_id ASC),
                    CONSTRAINT fk_comments_images1
                    FOREIGN KEY (images_id)
                    REFERENCES $schema.images (id)
                    ON DELETE CASCADE
                    ON UPDATE NO ACTION,
                    CONSTRAINT fk_comments_users1
                    FOREIGN KEY (users_id)
                    REFERENCES $schema.users (id)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)";
        return $db->exec($req);
    }

    /**
     * @param $obj \item\Comment
     */
    protected function create(\item\Comment $com)
    {
        $req = "INSERT INTO $this->table (content, images_id, users_id) VALUE (:content, :images_id, :users_id)";

        $this->dbConnexion();
        try {
            $r = $this->db->prepare($req);
            $r->bindValue(':content', $com->getContent(), \PDO::PARAM_STR);
            $r->bindValue(':images_id', $com->getImagesId(), \PDO::PARAM_INT);
            $r->bindValue(':users_id', $com->getUsersId(), \PDO::PARAM_INT);
            $r->execute();
        } catch (\PDOException $e){
            print 'Erreur !:'.$e->getMessage().'<br />';
        }

    }

    public function getById($id)
    {
        $req = array(
            'where' => 'id='.$id
        );

        return $this->get($req);
    }

    public function getCommentsByImageId($id)
    {
        $req = array(
            'where' => 'images_id='.$id
        );

        return $this->get($req);
    }

    public function getLastComments($imgId)
    {
        $req = array(
            'where' => 'images_id='.$imgId,
            'order' => 'created_at ASC'
        );

        return $this->get($req);
    }
}

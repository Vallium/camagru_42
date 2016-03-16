<?php
namespace model;

class LikeModel extends Model
{
    protected $table = 'likes';

    static function createTable(\PDO $db, $schema = "camagru")
    {
        //Drop
        $req = "DROP TABLE IF EXISTS $schema.likes";
        $db->exec($req);

        //Create
        $req = "CREATE TABLE IF NOT EXISTS $schema.likes (
                    id INT NOT NULL AUTO_INCREMENT,
                    images_id INT NOT NULL,
                    users_id INT NOT NULL,
                    PRIMARY KEY (id),
                    INDEX fk_notes_images1_idx (images_id ASC),
                    INDEX fk_notes_users1_idx (users_id ASC),
                    CONSTRAINT fk_notes_images1
                    FOREIGN KEY (images_id)
                    REFERENCES $schema.images (id)
                    ON DELETE CASCADE
                    ON UPDATE NO ACTION,
                    CONSTRAINT fk_notes_users1
                    FOREIGN KEY (users_id)
                    REFERENCES $schema.users (id)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)";
        return $db->exec($req);
    }

    public function countLikesByImageId($id)
    {
        $req = array(
            'select' => 'count(*) as count',
            'where' => 'images_id='.$id
        );

        return $this->get($req);
    }
}
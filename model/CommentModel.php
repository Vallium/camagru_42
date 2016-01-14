<?php
namespace model;

class CommentModel
{
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
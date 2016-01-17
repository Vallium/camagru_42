<?php
namespace model;

class ImageModel
{
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
}
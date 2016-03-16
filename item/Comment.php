<?php
namespace item;

class Comment
{
    private $id,
        $content,
        $images_id,
        $users_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getImagesId()
    {
        return $this->images_id;
    }

    /**
     * @param mixed $images_id
     */
    public function setImagesId($images_id)
    {
        $this->images_id = $images_id;
    }

    /**
     * @return mixed
     */
    public function getUsersId()
    {
        return $this->users_id;
    }

    /**
     * @param mixed $users_id
     */
    public function setUsersId($users_id)
    {
        $this->users_id = $users_id;
    }
}
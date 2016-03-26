<?php
namespace item;

class User
{
    private $id,
            $username,
            $password,
            $email,
            $is_admin,
            $is_activated,
            $security_hash;

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param mixed $is_admin
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    /**
     * @return mixed
     */
    public function getIsActivated()
    {
        return $this->is_activated;
    }

    /**
     * @param mixed $is_activated
     */
    public function setIsActivated($is_activated)
    {
        $this->is_activated = $is_activated;
    }

    /**
     * @return mixed
     */
    public function getSecurityHash()
    {
        return $this->security_hash;
    }

    /**
     * @param mixed $security_hash
     */
    public function setSecurityHash($security_hash)
    {
        $this->security_hash = $security_hash;
    }
}
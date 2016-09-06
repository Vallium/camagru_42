<?php
namespace model;

abstract class Model
{
    protected $db;
    protected $table;

    //Connexion BDD et Deconnexion
    protected function  dbConnexion()
    {
        require(ROOT.'config'.DS.'database.php');
        try {
            $this->db = new \PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e){
            print 'Erreur !:'.$e->getMessage().'<br />';
            die();
        }
    }

    protected function dbKill()
    {
        $this->db = NULL;
    }

    public function save($obj)
    {
        if ($obj->getId())
            $this->update($obj);
        else
            $this->create($obj);
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function getDb() { return $this->db; }

//    abstract public function update();
//    abstract protected function create(\item\User $obj);
//    abstract public function find($username);

    /**
     * @param $param = Array avec toute possibilite de requete SQL (Select, Where, Group, having, order, limit, offset)
     * @return PDO::FET_ASSOC;
     */
    protected function get($param, $only_one = FALSE)
    {
        if (empty($this->table))
            return ("Erreur");
        $request = "SELECT * FROM $this->table ";
        if (isset($param['select']) && !empty($param['select']))
            $request = 'SELECT '.$param['select'].' FROM '. $this->table;
        if (isset($param['where']) && !empty($param['where']))
            $request .= ' WHERE '.$param['where'];
        if (isset($param['group']) && !empty($param['group']))
            $request .= ' GROUP BY '.$param['group'];
        if (isset($param['having']) && !empty($param['having']))
            $request .= ' HAVING '.$param['having'];
        if (isset($param['order']) && !empty($param['order']))
            $request .= ' ORDER BY '.$param['order'];
        if (isset($param['limit']) && !empty($param['limit']))
            $request .= ' LIMIT '. $param['limit'];
        if (isset($param['offset']) && !empty($param['offset']))
            $request .= ' OFFSET '. $param['offset'];

        $this->dbConnexion();
        try
        {
            $return = $this->db->prepare($request);
            $return->execute();
            $return->setFetchMode(\PDO::FETCH_OBJ);
            $this->dbKill();
            if ($only_one)
                return ($return->fetch());
            return ($return->fetchAll());
        } catch (\PDOException $e) {
            print 'Erreur !:'.$e->getMessage().'<br />';
            die();
        }
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM $this->table";

        $this->dbConnexion();
        try
        {
            $ret =  $this->db->query($sql);
            $ret = $ret->fetch(\PDO::FETCH_NUM);

            return $ret[0];
        } catch (\PDOException $e) {
            print 'Erreur !:'.$e->getMessage().'<br />';
            die();
        }
    }

    protected function delete($id)
    {
        if (empty($this->table))
            return ("Erreur");
        $this->dbConnexion();
//        if (is_int($id))
//        {
        try{
            $req = $this->db->prepare("DELETE FROM $this->table WHERE id=$id");
            $req->execute();
        }
        catch (\PDOException $e)
        {
            print 'Erreur !:'.$e->getMessage().'<br />';
            die();
        }
//        }
        $this->dbKill();
    }
}

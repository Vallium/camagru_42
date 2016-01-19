<?php
namespace model;

abstract class Model
{
    protected $db;
//    protected $table;

    function    __construct()
    {
        $this->dbConnexion();
    }

    function    __destruct()
    {
        $this->dbKill();
    }

    //Connexion BDD et Deconnexion
    protected function  dbConnexion()
    {
        require(ROOT.'config/database.php');
        try {
            $this->db = new \PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        }
        catch (PDOException $e){
            print 'Erreur !:'.$e->getMessage().'<br />';
        }
    }

    protected function dbKill()
    {
        $this->db = NULL;
    }

    /**
     * Sauvegarde ou Update dans la table
     * @param $data = Array Assoc
     */
//    protected function  save($data)
//    {
//        if (empty($this->table))
//            return ("Erreur");
//        $this->dbConnexion();
//        if (isset($data['id']) && !empty($data['id']))
//        {
//            $request = "UPDATE $this->table SET ";
//            $id = $data['id'];
//            unset($data['id']);
//            foreach ($data as $k => $v)
//                $request .= "$k=$v ";
//            $request .= " WHERE id=$id";
//        }
//        else
//        {
//            unset($data['id']);
//            $request ="INSERT INTO $this->table VALUES (";
//            $numData = count($data);
//            $i = 0;
//            foreach ($data as $k => $v) {
//                $request .= "$v";
//                if (++$i < $numData)
//                    $request .= ", ";
//            }
//            $request .= ")";
//        }
//
//        $request = $this->db->prepare($request);
//        $request->execute();
//        $this->dbKill();
//    }
//
//    /**
//     * @param $param = Array avec toute possibilite de requete SQL (Select, Where, Group, having, order, limit, offset)
//     * @return PDO::FET_ASSOC;
//     */
//    protected function get($param)
//    {
//        if (empty($this->table))
//            return ("Erreur");
//        $request = "SELECT * FROM $this->table ";
//        if (isset($param['select']) && !empty($param['select']))
//            $request = 'SELECT '.$param['select'].' FROM '. $this->table;
//        if (isset($param['where']) && !empty($param['where']))
//            $request .= ' WHERE '.$param['where'];
//        if (isset($param['group']) && !empty($param['group']))
//            $request .= ' GROUP BY '.$param['group'];
//        if (isset($param['having']) && !empty($param['having']))
//            $request .= ' HAVING '.$param['having'];
//        if (isset($param['order']) && !empty($param['order']))
//            $request .= ' ORDER BY '.$param['order'];
//        if (isset($param['limit']) && !empty($param['limit']))
//            $request .= ' LIMIT '. $param['limit'];
//        if (isset($param['offset']) && !empty($param['offset']))
//            $request .= ' OFFSET '. $param['offset'];
//
//        $this->dbConnexion();
//        $return = $this->db->prepare($request);
//        $return->execute();
//        $return->setFetchMode(PDO::FETCH_OBJ);
//        $this->dbKill();
//        return ($return->fetchAll());
//    }
//
//    protected function  delete($id)
//    {
//        if (empty($this->table))
//            return ("Erreur");
//        $this->dbConnexion();
//        if (is_int($id))
//        {
//            $this->db->exec("DELETE FROM $this->table WHERE id=$id");
//        }
//        $this->dbKill();
//    }
}
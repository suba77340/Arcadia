<?php

namespace App\Models;

class RoleModel extends Model
{
    protected $id;
    protected $titre;

    public function __construct()
    {

        $this->table = 'role';
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    public function create()
    {
        $sql = 'INSERT INTO ' . $this->table . '(titre) VALUES (?)';
        $this->requete($sql, [$this['titre']]);
        return $this->lastInsertId();
    }
    public function update($id)
    {
        $sql = 'UPDATE ' . $this->table . 'SET titre = ? WHERE id = ?';
        return $this->requete($sql, [$this['titre'], [$id]]);
    }
    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        return $this->requete($sql, [$id]);
    }
}

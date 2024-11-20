<?php

namespace App\Models;

class AvisModel extends Model
{
    protected $id;
    protected $pseudo;
    protected $commentaire;
    protected $visibilite;
    protected $id_users;

    public function __construct()
    {
        $this->table = 'avis';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function getVisibilite()
    {
        return $this->visibilite;
    }

    public function getIdUsers()
    {
        return $this->id_users;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function setVisibilite($visibilite)
    {
        $this->visibilite = $visibilite;
        return $this;
    }

    public function setIdUsers($id_users)
    {
        $this->id_users = $id_users;
        return $this;
    }

    public function create()
    {
        $sql = 'INSERT INTO ' . $this->table . ' (pseudo, commentaire, id_users, visibilite) VALUES (?, ?, ?, 0)';
        return $this->requete($sql, [$this->pseudo, $this->commentaire, $this->id_users]);
    }

    public function validate($id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET visibilite = 1 WHERE id = ?';
        return $this->requete($sql, [$id]);
    }

    public function findAllValid()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table . ' WHERE visibilite = 1');
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findUnvalidated()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table . ' WHERE visibilite = 0');
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        return $this->requete($sql, [$id]);
    }
}

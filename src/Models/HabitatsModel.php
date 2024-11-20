<?php

namespace App\Models;

class HabitatsModel extends Model
{
    protected $id;
    protected $nom;
    protected $descriptif;
    protected $commentaire;
    protected $photo;
    protected $id_users;

    public function __construct()
    {
        $this->table = 'habitats';
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

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescriptif()
    {
        return $this->descriptif;
    }

    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;
        return $this;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getIdUsers()
    {
        return $this->id_users;
    }

    public function setIdUsers($id_users)
    {
        $this->id_users = $id_users;
        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function create()
    {
        $sql = 'INSERT INTO ' . $this->table . ' (nom, descriptif, commentaire, photo) VALUES (?, ?, ?, ?)';
        return $this->requete($sql, [$this->nom, $this->descriptif, $this->commentaire, $this->photo]);
    }

    public function update($id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET nom = ?, descriptif = ?, commentaire = ?, photo = ? WHERE id = ?';
        $this->requete($sql, [$this->nom, $this->descriptif, $this->commentaire, $this->photo, $id]);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        return $this->requete($sql, [$id]);
    }
    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function findById($id)
    {
        $query = $this->requete('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateCommentaire($id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET commentaire = ?, id_users = ? WHERE id = ?';

        if ($this->requete($sql, [$this->commentaire, $this->id_users, $id])) {
            return true;
        } else {
            error_log("Erreur lors de l'ajout du commentaire");
            return false;
        }
    }

    public function getCommentaires()
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE commentaire IS NOT NULL';
        return $this->requete($sql)->fetchAll();
    }
}

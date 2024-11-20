<?php

namespace App\Models;

class ServicesModel extends Model
{
    protected $id;
    protected $nom;
    protected $descriptif;
    protected $image;

    public function __construct()
    {
        $this->table = 'services';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getDescriptif()
    {
        return $this->descriptif;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;
        return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function find($id)
    {
        $query = $this->requete('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $sql = 'INSERT INTO ' . $this->table . ' (nom, descriptif, image) VALUES (?, ?, ?)';
        return $this->requete($sql, [$this->nom, $this->descriptif, $this->image]);
    }

    public function update($id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET nom = ?, descriptif = ?, image = ? WHERE id = ?';
        return $this->requete($sql, [$this->nom, $this->descriptif, $this->image, $id]);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        return $this->requete($sql, [$id]);
    }
}

<?php

namespace App\Models;

class AnimauxModel extends Model
{
    protected $id;
    protected $nom;
    protected $etat;
    protected $race;
    protected $image;
    protected $id_habitats;
    protected $compteurModel;

    public function __construct()
    {

        $this->table = 'animaux';
        $this->compteurModel = new CompteurModel();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function getRace()
    {
        return $this->race;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getId_Habitats()
    {
        return $this->id_habitats;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    public function setRace($race)
    {
        $this->race = $race;
        return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function setId_Habitats($id_habitats)
    {
        $this->id_habitats = $id_habitats;
        return $this;
    }

    public function logConsultation()
    {
        if (!isset($this->id)) {
            echo "Erreur : ID de l'animal non défini." . PHP_EOL;
            return;
        }

        $this->compteurModel->logConsultation($this->id, $this->nom);
    }

    public function getConsultations()
    {
        return $this->compteurModel->getConsultations($this->id);
    }

    //Methode pr trouver animal par ID
    public function find($id)
    {
        $query = $this->requete('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }
    //creer nouvel animal
    public function create()
    {
        $sql = 'INSERT INTO ' . $this->table . ' (nom, etat, race, image,id_habitats) VALUES (?, ?, ?, ?,?)';
        return $this->requete($sql, [$this->nom, $this->etat, $this->race, $this->image, $this->id_habitats]);
    }
    //maj animal existant
    public function update($id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET nom = ?, etat = ?, race = ?, image = ? WHERE id = ?';
        return $this->requete($sql, [$this->nom, $this->etat, $this->race, $this->image, $id]);
    }


    public function delete($id)
    {
        // Supprimer d'abord les entrées liées dans rapport_vet
        $sql = 'DELETE FROM rapport_vet WHERE id_animal = ?';
        $this->requete($sql, [$id]);

        // Ensuite, supprimer les entrées dans nourrissage
        $sql = 'DELETE FROM nourrissage WHERE id_animal = ?';
        $this->requete($sql, [$id]);

        // Finalement, supprimer l'animal
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        return $this->requete($sql, [$id]);
    }

    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function validate()
    {
        if (empty($this->nom) || empty($this->etat) || empty($this->race)) {
            return false;
        }
        return true;
    }

    public function findByHabitat(int $id_habitats)
    {
        // Prépare la requête SQL
        $sql = 'SELECT * FROM animaux WHERE id_habitats = ?';
        $query = $this->requete($sql, [$id_habitats]);
        // Récupère les résultats
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function Compteur($id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET compteur = compteur + 1 WHERE id = ?';
        return $this->requete($sql, [$id]);
    }
}

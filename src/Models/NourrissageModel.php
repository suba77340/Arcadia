<?php

namespace App\Models;

class NourrissageModel extends Model
{
    protected $id;
    protected $id_users;
    protected $id_animal;
    protected $type_nourriture;
    protected $quantite;
    protected $date_repas;
    protected $heure_repas;

    public function __construct()
    {
        $this->table = 'nourrissage';
    }

    public function getId() {
        return $this->id;
    }

    public function getIdUsers() {
        return $this->id_users;
    }

    public function getIdAnimal() {
        return $this->id_animal;
    }

    public function getTypeNourriture() {
        return $this->type_nourriture;
    }

    public function getQuantite() {
        return $this->quantite;
    }

    public function getDateRepas() {
        return $this->date_repas;
    }

    public function getHeureRepas() {
        return $this->heure_repas;
    }



    public function setIdAnimal($id_animal) {
        $this->id_animal = $id_animal;
        return $this;
    }

    public function setTypeNourriture($type_nourriture) {
        $this->type_nourriture = $type_nourriture;
        return $this;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }

    public function setDateRepas($date_repas) {
        $this->date_repas = $date_repas;
        return $this;
    }

    public function setHeureRepas($heure_repas) {
        $this->heure_repas = $heure_repas;
        return $this;
    }

    public function setIdUsers(int $id_users){
        $this->id_users = $id_users;
        return $this;
    }

    public function nourrissage() {
        $sql = 'INSERT INTO ' . $this->table . ' (id_users, id_animal, type_nourriture, quantite, date_repas, heure_repas) VALUES (?, ?, ?, ?, ?, ?)';
        
        if ($this->requete($sql, [$this->id_users, $this->id_animal, $this->type_nourriture, $this->quantite, $this->date_repas, $this->heure_repas])) {
            return true;
        } else {
            error_log("Erreur lors de l'insertion dans la table nourrissage."); 
            return false;
        }
    }

    public function findAll()
{
    $query = $this->requete('SELECT * FROM ' . $this->table);
    return $query->fetchAll(\PDO::FETCH_ASSOC); 
}

public function find($id)
{
    $query = $this->requete('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
    return $query->fetch(\PDO::FETCH_OBJ);  
}

public function findWithAnimalNames()
{
    $sql = 'SELECT nourrissage.*, animaux.nom as animal_nom FROM ' . $this->table . ' 
            JOIN animaux ON nourrissage.id_animal = animaux.id';
    $query = $this->requete($sql);
    return $query->fetchAll(\PDO::FETCH_ASSOC);
}

    
}

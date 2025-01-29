<?php

namespace App\Models;

class RapportVetModel extends Model
{
    protected $id;
    protected $id_users;
    protected $id_animal;
    protected $la_date;
    protected $rapport;

    public function __construct()
    {
        $this->table = 'rapport_vet';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUsers()
    {
        return $this->id_users;
    }

    public function getIdAnimal()
    {
        return $this->id_animal;
    }

    public function getLaDate()
    {
        return $this->la_date;
    }

    public function getRapport()
    {
        return $this->rapport;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setIdUsers($id_users)
    {
        $this->id_users = $id_users;
        return $this;
    }

    public function setIdAnimal($id_animal)
    {
        $this->id_animal = $id_animal;
        return $this;
    }

    public function setLaDate($la_date)
    {
        $this->la_date = $la_date;
        return $this;
    }

    public function setRapport($rapport)
    {
        $this->rapport = $rapport;
        return $this;
    }


    public function create()
    {
        $sql = 'INSERT INTO ' . $this->table . ' (id_users, id_animal, la_date, rapport) VALUES (?, ?, ?, ?)';
        return $this->requete($sql, [$this->id_users, $this->id_animal, $this->la_date, $this->rapport]);
    }

    public function find($id)
    {
        $query = $this->requete('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$id]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET id_users = ?, id_animal = ?, la_date = ?, rapport = ? WHERE id = ?';
        return $this->requete($sql, [$this->id_users, $this->id_animal, $this->la_date, $this->rapport, $id]);
    }

    public function findByFiltre($filtres)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE 1=1";
        $params = [];

        if (!empty($filtres['animal_id'])) {
            $sql .= " AND id_animal = ?";
            $params[] = $filtres['animal_id'];
        }

        if (!empty($filtres['date_start']) && !empty($filtres['date_end'])) {
            $sql .= " AND la_date BETWEEN ? AND ?";
            $params[] = $filtres['date_start'];
            $params[] = $filtres['date_end'];
        }

        $query = $this->requete($sql, $params);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}

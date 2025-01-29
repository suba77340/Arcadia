<?php

namespace App\Models;

use App\Config\Db;

class Model extends Db
{
    // table de BDD
    protected $table;
    //instance Db
    private $db;

    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];
        // boucle pour eclater tableau
        foreach ($criteres as $champ => $valeur) {
            // select * from animaux where race = ?
            // bindValue (race,valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }
        $liste_champs = implode('AND', $champs);
        // execute la requete
        return $this->requete('SELECT * FROM ' . $this->table . 'WHERE' . $liste_champs, $valeurs)->fetchAll();
    }

    public function find(int $id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE id = $id ")->fetch();
    }

    public function create()
    {
        $champs = [];
        $inter = [];
        $valeurs = [];
        // on boucle pour eclater le tableau 
        foreach ($this as $champ => $valeur) {
            // INSERT INTO animaux ( titres, etat) VALUES (?,?)
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }
        // transforme tableau "champs" en une chaine de caratctere
        $liste_champs = implode(',', $champs);
        $liste_inter = implode(',', $inter);
        // execute la requete
        return $this->requete('INSERT INTO ' . $this->table . '(' . $liste_champs . ') VALUES(' . $liste_inter . ')', $valeurs);
    }


    public function update(int $id)
    {
        $champs = [];
        $valeurs = []; {   // boucle pour eclater le tableau
            foreach ($this as $champ => $valeur) {
                // update animaux set titre = ?, etat = ?, where id =?
                if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                    $champs[] = "$champ = ?";
                    $valeurs[] = $valeur;
                }
            }
            $valeurs[] = $id;
            // transforme le champs en une chaine de caracteres
            $liste_champs = implode(',', $champs);
            //execute la requete
            return $this->requete('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id = ?', $valeurs);
        }
    }

    public function delete(int $id)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function requete(string $sql, array $attributs = null)
    {
        // recupere instance Db
        $this->db = Db::getInstance();
        // verifie si on a des attributs
        if ($attributs !== null) {
            //requete preparee
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            //requete simple
            return $this->db->query($sql);
        }
    }

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            //recupere nom du setter correspondant à la clé(key)
            // titre->setTitre
            $setter = 'set' . ucfirst($key);
            //on verifie si setter existe
            if (method_exists($this, $setter)) {
                // appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }
}

<?php

namespace App\Models;

class UsersModel extends Model
{
    protected $id;
    protected $email;
    protected $password;
    protected $nom;
    protected $prenom;
    protected $id_role;

    public function __construct()
    {
        $this->table = "users";
    }
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM $this->table WHERE email= ?", [$email])->fetch();
    }
    public function create()
    {
        $this->password = password_hash($this->password, PASSWORD_ARGON2I);

        $sql = "INSERT INTO {$this->table} (email, password, nom, prenom) VALUES (?, ?, ?, ?)";
        return $this->requete($sql, [$this->email, $this->password, $this->nom, $this->prenom]);
    }

    public function setSession()
    {
        $_SESSION['users'] = [
            'id' => $this->id,
            'email' => $this->email,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'role' => $this->id_role
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getId_Role()
    {
        return $this->id_role;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }
    public function setId_Role($id_role)
    {
        $this->id_role = $id_role;
        return $this;
    }
}

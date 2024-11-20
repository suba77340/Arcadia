<?php

namespace App\Models;

use MongoDB\Client;

class ContactModel
{
    private $collection;

    public function __construct()
    {
        $client = new Client("mongodb+srv://employe:Subathira777@cluster0.jqfmr.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
        $this->collection = $client->zoo->contacts;
    }

    public function createContact($titre, $description, $email)
    {
        $contact = [
            'titre' => $titre,
            'description' => $description,
            'email' => $email,
            'date' => new \MongoDB\BSON\UTCDateTime()
        ];
        return $this->collection->insertOne($contact);
    }

    public function findAllContact() 
    { 
        return $this->collection->find()->toArray(); 
    }

    public function testConnection()
    {
        try {
            $this->collection->countDocuments();
            echo "La connexion à MongoDB Atlas est réussie.";
        } catch (Exception $e) {
            echo "Erreur de connexion à MongoDB Atlas : " . $e->getMessage();
        }
    }
}



<?php

namespace App\Models;

use MongoDB\Client;
use Dotenv\Dotenv;

class ContactModel
{
    private $collection;
    private $client;

    public function __construct()
    {
        // Accéder directement à la variable d'environnement
        $mongoUri = getenv('MONGO_URI');

        if (!$mongoUri) {
            throw new \Exception('La variable MONGO_URI n\'est pas définie dans l\'environnement');
        }

        $this->client = new Client($mongoUri);
        $this->client->listDatabases();

        $this->collection = $this->client->selectCollection('zoo', 'contacts');
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
            $this->client->listDatabases();
        } catch (\Exception $e) {
        }
    }
}

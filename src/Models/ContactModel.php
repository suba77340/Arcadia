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
        // Charger les variables d'environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');

        $dotenv->load();

        $mongoUri = $_ENV['MONGO_URI'];

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

<?php

namespace App\Models;

use MongoDB\Client;
use Dotenv\Dotenv;

class CompteurModel
{
    private $client;
    private $collection;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $dotenv->load();

        $mongoUri = $_ENV['MONGO_URI'];
        $this->client = new Client($mongoUri);

        $this->client->listDatabases();

        $this->collection = $this->client->selectCollection('zoo', 'compteurs');
    }

    public function logConsultation($animalId, $animalNom)
    {
        $this->collection->updateOne(
                ['animal_id' => $animalId],
                [
                    '$inc' => ['views' => 1],
                    '$set' => ['animal_nom' => $animalNom]
                ],
                ['upsert' => true]
            );
    }


    public function getConsultations($animalId)
    {
        return $this->collection->findOne(['animal_id' => $animalId]);
    }

    public function deleteConsultation($animalId)
    {
        $this->collection->deleteOne(['animal_id' => $animalId]);
    }
}

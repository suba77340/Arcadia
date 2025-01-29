<?php

namespace App\Models;

use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use Dotenv\Dotenv;

class HoraireModel
{
    private $collection;

    public function __construct()
    {
        // Charger les variables d'environnement ici
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $mongoUri = $_ENV['MONGO_URI'];
        if (!$mongoUri) {
            throw new \Exception('MONGO_URI not set');
        }

        $client = new Client($mongoUri);
        $this->collection = $client->zoo->horaires;
    }

    public function createHoraire($jour, $ouverture, $fermeture)
    {
        $horaire = [
            'jour' => $jour,
            'ouverture' => $ouverture,
            'fermeture' => $fermeture,
            'date' => new \MongoDB\BSON\UTCDateTime()
        ];
        return $this->collection->insertOne($horaire);
    }

    public function findAllHoraires()
    {
        $horaires = $this->collection->find()->toArray();
        foreach ($horaires as &$horaire) {
            $horaire['_id'] = (string) $horaire['_id'];
        }
        return $horaires;
    }
    

    public function findHoraireById($id)
    {
        $horaire = $this->collection->findOne(['_id' => new ObjectId($id)]);
        if ($horaire) {
            $horaire['_id'] = (string) $horaire['_id'];
        }
        return $horaire;
    }
    

    public function updateHoraire($id, $jour, $ouverture, $fermeture)
    {
        $filter = ['_id' => new ObjectId($id)];
        $update = [
            '$set' => [
                'jour' => $jour,
                'ouverture' => $ouverture,
                'fermeture' => $fermeture
            ]
        ];
        return $this->collection->updateOne($filter, $update);
    }

    public function deleteHoraire($id)
    {
        $filter = ['_id' => new ObjectId($id)];
        return $this->collection->deleteOne($filter);
    }
}


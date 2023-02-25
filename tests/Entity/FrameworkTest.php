<?php

namespace App\Tests\Entity;

use App\Entity\Framework;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

// Commande terminal : php bin/phpunit --filter FrameworkTest

// Importe la classe KernelTestCase du composant Symfony pour faciliter les tests d'intégration
class FrameworkTest extends KernelTestCase
{
    // Teste la validation de l'entité Framework
    public function testValidEntity()
    {
        // Lance le noyau de l'application Symfony
        self::bootKernel();

        // Récupère le conteneur de service de l'application
        $container = static::getContainer();

        // Crée une nouvelle instance de l'entité Framework
        $framework = new Framework();

        // Définit le nom du framework.
        $framework->setNameFramework('Symfony');

        // Valide l'entité avec le service Validator et récupère les erreurs éventuelles
        $errors = $container->get('validator')->validate($framework);

        // Vérifie que le nombre d'erreurs est égal à 0
        $this->assertCount(0, $errors);
    }
}

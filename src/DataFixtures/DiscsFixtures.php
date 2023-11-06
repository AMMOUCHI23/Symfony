<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Disc;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DiscsFixtures extends Fixture



    // Utiliser php faker pour charger une table dans la base hde données
/*
    private Generator $faker;
public function __construct()
{
    $this->faker=Factory::create('fr_FR');
}
      public function load(ObjectManager $manager): void
    {  

        require ("public/assets/artist.php");
        require ("public/assets/disc.php");
        $artistRepo = $manager->getRepository(Artist::class);
        foreach ($artist as $art) { 
            $artistDB = new Artist();
            $artistDB->setId($art["artist_id"])
            ->setName($art["artist_name"])
            ->setUrl($art["artist_url"]);
            $manager->persist($artistDB);

            
        }
        foreach ($disc as $d) {
            $discDB = new Disc();
            $discDB
            ->setId($d['disc_id'])
            ->setTitle($d['disc_title'])
            ->setYear($d['disc_year'])
            ->setLabel($d['disc_label'])
            ->setPicture($d['disc_picture'])
            ->setLabel($d['disc_label'])
            ->setGenre($d['disc_genre'])
            ->setPrice($d['disc_price']);
           
            $artistId = $d['artist_id'];
            dd($artistId);
            $artistDB = $artistRepo->find($artistId);
            $discDB->setArtist($artistDB);
           //$artist = $artistRepo->find($d['artist_id']);
            //$discDB->setArtist($artist);
            $manager->persist($discDB);
            
        }
       //charger la table user avec Faker
       for ($i=0; $i <10 ; $i++){
        $user= new Utilisateur();
        $user->setFullname($this->faker->name())
        ->setPseudo(mt_rand(0, 1)==1? $this->faker->firstName(): null)
        ->setEmail($this->faker->email())
        ->setPassword("Mot de passe");
        $manager->persist($user);
       }

        $manager->flush();

*/
// Utiliser php faker pour charger une table dans la base hde données
{
    private Generator $faker;
    private UserPasswordHasherInterface $hasher;
public function __construct(UserPasswordHasherInterface $hasher)
{
    $this->faker=Factory::create('fr_FR');
    $this->hasher=$hasher;
}
    public function load(ObjectManager $manager): void
    { 
         for ($i=0; $i <10 ; $i++){
        $user= new Utilisateur();
        $user->setFullname($this->faker->name())
        ->setPseudo(mt_rand(0, 1)==1? $this->faker->firstName(): null)
        ->setEmail($this->faker->email())
        -> setRoles(['Role_User'])
        ->setPassword("Mot de passe");
        $hashedPassword = $this->hasher->hashPassword(
            $user,
            "papy"
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

            
        }
        $manager->flush();
    

       /*
        include 'record.php';
        $artistRepo = $manager->getRepository(Artist::class);

        foreach ($artist as $art){
            $artistDB = new Artist();
            $artistDB
            ->setId($art['artist_id'])
            ->setName($art['artist_name'])
            ->setUrl($art['artist_url']);

            $manager->persist($artistDB);

             // empêcher l'auto incrément
            $metadata = $manager->getClassMetaData(Artist::class);
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $manager->flush();

        foreach ($disc as $d) {
            $discDB = new Disc();
            $discDB
            ->setTitle($d['disc_title'])
            ->setLabel($d['disc_label'])
            ->setPicture($d['disc_picture']);
            $artist = $artistRepo->find($d['artist_id']);
            $discDB->setArtist($artist);
            $manager->persist($discDB);
        }

        $manager->flush();
        */
    }
}
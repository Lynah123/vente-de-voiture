<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Type;
use App\Entity\Brand;
use App\Entity\Client;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Supplier;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr-FR');

        //CLIENT
        for($i = 1; $i <= 30; $i++) {
            $client = new Client();
            $fisrtName = $faker->firstname;
            $lastName = $faker->lastname();
            $email = $faker->email();
            $phone = $faker->phoneNumber();
            $adresse = $faker->address();
            $password = $this->passwordEncoder->encodePassword($client, 'user123');

            $client->setFirstName($fisrtName)
                   ->setLastName($lastName)
                   ->setAddress($adresse)
                   ->setPhoneNumber($phone)
                   ->setEmail($email)
                   ->setRoles(['ROLE_USER'])
                   ->setPassword($password);
            $manager->persist($client);
        }

        //TYPE
        $types = [];
        for($i = 1; $i <= 30; $i++) {
            $type = new Type();
            $title = $faker->words(1, true);
            $type->setTitle($title);
            $manager->persist($type);
            $types[] = $type;
        }

        //GENRE
        $categories = [];
        for($i = 1; $i <= 30; $i++) {
            $category = new Category();
            $title = $faker->words(1, true);
            $category->setTitle($title);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Création des fournisseurs
        $suppliers = [];
        for ($i = 1; $i <= 30; $i++) {
            $supplier = new Supplier();
            $name = $faker->words(2, true);
            $adresse = $faker->address();
            $phone = $faker->phoneNumber();
            $supplier->setName($name)
                    ->setAddress($adresse)
                    ->setPhoneNumber($phone);
            $manager->persist($supplier);
            $suppliers[] = $supplier;
        }

        // Création des marques avec association à un fournisseur
        $brands = [];
        for ($i = 1; $i <= 30; $i++) {
            $brand = new Brand();
            $title = $faker->words(1, true);

            // Choisissez un fournisseur aléatoire dans la liste des fournisseurs
            $randomSupplier = $faker->randomElement($suppliers);

            $brand->setTitle($title)
                ->setSupplier($randomSupplier);

            $manager->persist($brand);
            $brands[] = $brand;
        }

        $manager->flush();


        //CARRIER
        for($i = 1; $i <= 30; $i++) {
            $carrier = new Carrier();
            $name = $faker->words(3, true);
            $price = $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 100);
            $description = $faker->paragraph($nbSentences = 3, $variableNbSentences = true);
            $carrier->setName($name)
                    ->setPrice($price)
                    ->setDescription($description);
            $manager->persist($carrier);
        }

        $images = [
            'car1.jpeg', 
            'car2.jpeg', 
            'car3.jpeg', 
            'car4.jpeg', 
            'car5.jpeg', 
            'car6.jpeg', 
            'car7.jpeg', 
            'car8.jpeg', 
            'car9.jpg', 
            'car10.jpeg'
        ];

        for($i = 1; $i <= 30; $i++) {
            $product = new Product();
            $title = $faker->words(3, true);
            $description = $faker->paragraph($nbSentences = 3, $variableNbSentences = true);
            $quantity = $faker->numberBetween($min = 0, $max = 10);
            $price = $faker->randomFloat($nbMaxDecimals = 2, $min = 1000, $max = 10000);
            $randomBrand = $faker->randomElement($brands);
            $randomCategory = $faker->randomElement($categories);
            $randomType = $faker->randomElement($types);
            $image = $faker->randomElement($images);
            $date = $faker->dateTime();
        
            $product->setTitle($title)
                    ->setDescription($description)
                    ->setQuantity($quantity)
                    ->setPrice($price)
                    ->setBrand($randomBrand)
                    ->setCategory($randomCategory)
                    ->setType($randomType)
                    ->setIsActive(true)
                    ->setIsOutOfStock(0)
                    ->setImage($image)
                    ->setCreatedAt($date);
            $manager->persist($product);
        }
        

        $manager->flush();
    }
}

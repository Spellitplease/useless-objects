<?php
require_once 'vendor/autoload.php';
require_once 'database.php';

use Faker\Factory;

$faker = Factory::create();

for ($i = 0; $i < 10; $i++) {

	$query = "INSERT INTO users (nom, mail, mp, role) VALUES (:nom, :mail, :mp, :role)";
	$statement = $pdo->prepare($query);
	$statement->bindValue(':nom', $faker->name);
	$statement->bindValue(':mail', $faker->email);
	$statement->bindValue(':mp', $faker->password);
	$statement->bindValue(':role', 0);
	$statement->execute();
}

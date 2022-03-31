<?php

// En premier on connecte au fichier connec contenant les identifiants de la BDD

require_once 'connec.php';

// Ensuite on initialise $error et on se connecte à la base de donnée

$errors = [];   //Permet d'initialiser le tableau $errors, cela permettra par la suite de tester ci celui-ci est vide. Si cette lign n'est pas créée, il sera impossible de faire les "IF" présents par la suite
$pdo = new PDO(DSN, USER, PASSWORD);    // Connexion à config.php (qui se trouvera dans gitignore pour ne pas être versionné)


// On fait du tri et on façonne les erreurs

    //Enlever les espaces avant et après les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // nettoyer mes donnees
    $story = array_map('trim', $_POST); // array_map : Applique une fonction sur les éléments d'un tableau

    // validation des données
    if (empty($story['firstname'])) {
        $errors[] = 'Le prénom est obligatoire';
    }

    if (empty($story['lastname'])) {
        $errors[] = 'Le nom de famille est obligatoire';
    }

    if (empty($errors)) {
        // si pas d'erreur
        // insertion en bdd

        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);
        $statement->bindValue('firstname', $story['firstname']);
        $statement->bindValue('lastname', $story['lastname']);
        $statement->execute();

        // redirection
        header('Location: index.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<h1>Ajouter un personnage de Friends</h1>

<ul>
    <?php foreach ($errors as $error) : ?>
        <li><?= $error ?></li>
    <?php endforeach; ?>
</ul>
<form method="POST" novalidate>
    <label for="firstname">Firstname</label>
    <input type="text" id="firstname" name="firstname" required value="<?= isset($friend['firstname']) ? $story['firstname'] : '' ?>">

    <label for="lastname">Lastname</label>
    <input type="text" id="lastname" name="lastname" value="<?= isset($friend['lastname']) ? $story['lastname'] : '' ?>">

    <button>Ajouter</button>
</form>
</body>

</html>

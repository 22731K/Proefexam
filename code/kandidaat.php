<?php

require 'db.php';


$message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $partij = $_POST['partij'];

    if (!empty($naam) && !empty($partij)) {
        try {
            
            $stmt = $pdo->prepare("INSERT INTO kandidaten (naam, partij) VALUES (:naam, :partij)");
            $stmt->execute(['naam' => $naam, 'partij' => $partij]);
            $message = "Kandidaat toegevoegd!";
        } catch (PDOException $e) {
            $message = "Fout bij toevoegen: " . $e->getMessage();
        }
    } else {
        $message = "Vul alle velden in!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandidaat Toevoegen</title>
</head>

<body>
<style>
        nav{
            min-height: 30%;
            background-color: black;
        }
nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            
            
            
            
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            background-color: #333;
        }
        nav ul li a:hover {
            background-color: #111;
        }
        </style>
<nav>
        <ul>
            <li><a href="stem.php">Stem</a></li>
            <li><a href="resultaat.php">Resultaten</a></li>
            <li><a href="kandidaat.php">add_kandidaten</a></li>
            <li><a href="verkiezing.php">add_verkiezing</a></li>
        </ul>
    </nav>
    <h1>Kandidaat Toevoegen</h1>

   
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    
    <form action="kandidaat.php" method="POST">
        <label for="naam">Naam:</label><br>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="partij">Partij Naam:</label><br>
        <input type="text" id="partij" name="partij" required><br><br>

        <button type="submit">Toevoegen</button>
    </form>
</body>
</html>

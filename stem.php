<?php

require 'db.php';


$verkiezingen_query = "SELECT id, naam FROM verkiezing";
$verkiezingen_stmt = $pdo->query($verkiezingen_query);
$verkiezingen = $verkiezingen_stmt->fetchAll(PDO::FETCH_ASSOC);


$message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $verkiezing_id = isset($_POST['verkiezing_id']) ? $_POST['verkiezing_id'] : ''; 
    $kandidaat_id = isset($_POST['kandidaat_id']) ? $_POST['kandidaat_id'] : '';   

    if (!empty($verkiezing_id) && !empty($kandidaat_id)) {
        try {
            
            $stmt = $pdo->prepare("INSERT INTO stemmen (verkiezing_id, kandidaat_id) VALUES (:verkiezing_id, :kandidaat_id)");
            $stmt->execute(['verkiezing_id' => $verkiezing_id, 'kandidaat_id' => $kandidaat_id]);

            $message = "Je hebt gestemd!";
        } catch (PDOException $e) {
            $message = "Fout bij stemmen: " . $e->getMessage();
        }
    } else {
        $message = "Kies een verkiezing en een kandidaat!";
    }

    
    if (!empty($verkiezing_id)) {
        $kandidaten_query = "SELECT k.id, k.naam FROM kandidaten k
                             JOIN verkiezing_kandidaten vk ON k.id = vk.kandidaat_id
                             WHERE vk.verkiezing_id = :verkiezing_id";
        $kandidaten_stmt = $pdo->prepare($kandidaten_query);
        $kandidaten_stmt->execute(['verkiezing_id' => $verkiezing_id]);
        $kandidaten = $kandidaten_stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $kandidaten = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stem op Verkiezing</title>
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
    <h1>Stem op Verkiezing</h1>

    
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    
    <form action="stem.php" method="POST">
        <label for="verkiezing_id">Kies een Verkiezing:</label><br>
        <select name="verkiezing_id" id="verkiezing_id" required onchange="this.form.submit()">
            <option value="">Selecteer Verkiezing</option>
            <?php foreach ($verkiezingen as $verkiezing): ?>
                <option value="<?php echo $verkiezing['id']; ?>" <?php echo (isset($_POST['verkiezing_id']) && $_POST['verkiezing_id'] == $verkiezing['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($verkiezing['naam']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <?php if (!empty($kandidaten)): ?>
            <label for="kandidaat_id">Kies een Kandidaat:</label><br>
            <select name="kandidaat_id" id="kandidaat_id" required>
                <option value="">Selecteer Kandidaat</option>
                <?php foreach ($kandidaten as $kandidaat): ?>
                    <option value="<?php echo $kandidaat['id']; ?>"><?php echo htmlspecialchars($kandidaat['naam']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <button type="submit">Stem</button>
        <?php endif; ?>
    </form>

</body>
</html>

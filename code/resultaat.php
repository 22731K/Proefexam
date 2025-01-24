<?php

require 'db.php';


$verkiezingen_query = "SELECT id, naam FROM verkiezing";
$verkiezingen_stmt = $pdo->query($verkiezingen_query);
$verkiezingen = $verkiezingen_stmt->fetchAll(PDO::FETCH_ASSOC);


$verkiezing_id = isset($_GET['verkiezing_id']) ? $_GET['verkiezing_id'] : '';

if ($verkiezing_id) {
    $kandidaten_query = "SELECT k.id, k.naam, COUNT(s.id) AS votes 
                         FROM kandidaten k
                         LEFT JOIN stemmen s ON k.id = s.kandidaat_id
                         WHERE s.verkiezing_id = :verkiezing_id
                         GROUP BY k.id, k.naam
                         ORDER BY votes DESC";
    $kandidaten_stmt = $pdo->prepare($kandidaten_query);
    $kandidaten_stmt->execute(['verkiezing_id' => $verkiezing_id]);
    $kandidaten = $kandidaten_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $kandidaten = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stem Resultaten</title>
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
    <h1>Stem Resultaten</h1>
    


    
    <form action="resultaat.php" method="GET">
        <label for="verkiezing_id">Kies een Verkiezing:</label><br>
        <select name="verkiezing_id" id="verkiezing_id" required onchange="this.form.submit()">
            <option value="">Selecteer Verkiezing</option>
            <?php foreach ($verkiezingen as $verkiezing): ?>
                <option value="<?php echo $verkiezing['id']; ?>" <?php echo ($verkiezing['id'] == $verkiezing_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($verkiezing['naam']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
    </form>

    <?php if (!empty($kandidaten)): ?>
        <h2>Stem Resultaten voor Verkiezing: <?php echo htmlspecialchars($verkiezingen[array_search($verkiezing_id, array_column($verkiezingen, 'id'))]['naam']); ?></h2>
        <table>
            <tr>
                <th>Kandidaat</th>
                <th>Stemmen</th>
            </tr>
            <?php foreach ($kandidaten as $kandidaat): ?>
                <tr>
                    <td><?php echo htmlspecialchars($kandidaat['naam']); ?></td>
                    <td><?php echo $kandidaat['votes']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($verkiezing_id)): ?>
        <p>Er zijn geen stemmen geregistreerd voor deze verkiezing.</p>
    <?php endif; ?>
</body>
</html>

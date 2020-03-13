<?php

$id = $_GET['id'];

$localhost = 'localhost';
$db = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$localhost;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} 
catch (\PDOException $e) {
    echo 'error connecting to database: ' . $e->getMessage();
}

$film = $pdo->prepare('SELECT * FROM movies WHERE id');
$film->bindParam(':id', $id);
$film->execute();

$film = $film->fetch(PDO::FETCH_OBJ);

function getTitle() {
    global $film;
    return $film->title;
}

function getDuration() {
    global $film;
    return $film->duur;
}

function getDatum() {
    global $film;
    return $film->datum_van_uitkomst;
}

function getCountry() {
    global $film;
    return $film->land_van_uitkomst;
}

function getDescription() {
    global $film;
    return $film->description;
}

function getTrailerID() {
    global $film;
    return $film->youtube_trailer_id;
}

?>

<a href="index.php">terug</a>

<h2><?php echo getTitle(); echo ' - ' . getDuration();?></h2>

<table>
    <tr>
        <th>Datum van uitkomst</th>
        <td><?php echo getDatum(); ?></td>
    </tr>
    <tr>
        <th>Land</th>
        <td><?php echo getCountry(); ?></td>
    </tr>
</table>

<p><?php echo getDescription(); ?></p>

<iframe width="420" height="345" src=<?php echo "https://www.youtube.com/embed/" . getTrailerID();?>>
</iframe>
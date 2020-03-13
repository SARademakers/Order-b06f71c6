<?php
$host = '127.0.0.1';
$db   = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo("Verbonden met: " . $db);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$series = $pdo->prepare('SELECT * FROM series');
$series->execute();

$movies = $pdo->prepare('SELECT * FROM movies');
$movies->execute();

$series_array = $series->fetchAll(PDO::FETCH_OBJ);
$movies_array = $movies->fetchAll(PDO::FETCH_OBJ);

function echoSeries() {
    global $series_array;
    foreach ($series_array as $key) {
        echo 
            '<tr><td>' . $key->title . 
            '</td><td>' . $key->rating .
            '</td><td>' . "<a href='series.php?id=$key->id'>details</a>" . '</td></tr>';
    }
}

function echoMovies() {
    global $movies_array;
    foreach ($movies_array as $key) {
        echo 
        '<tr><td>' . $key->title .
        '</td><td>' . $key->duur .
        '</td><td>' . "<a href='films.php?id=$key->id'>details</a>" . '</td></tr>';
    }
}

?>
    <table>
        <h3>Series</h3>
    <tr>
        <th>Titel</th>
        <th>Rating</th>
        <th>Details</th>
    </tr>
    <tr>
<?php echoSeries($series); ?>
    </tr>
    </table>

<br>
<br>

    <table>
        <h3>Films</h3>
    <tr>
        <th>Titel</th>
        <th>Duur</th>
        <th>Details</th>
</tr>
<tr>
<?php echoMovies($movies); ?>
</tr>
</table>
<?php

$localhost = 'localhost';
$db = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$localhost;dbname=$db;charset=$charset";

try  {
    $pdo = new PDO($dsn, $user, $pass);
} 
catch (\PDOException $e) {
    echo 'error' . $e->getMessage();
}


session_start();

if(!isset($_SESSION['serieswitch'])) {
    $_SESSION['serieswitch'] = true;
}

if(!isset($_SESSION['filmswitch'])) {
    $_SESSION['filmswitch'] = true;
}

$serie_order = 'title';
$film_order = 'title';


if(isset($_GET['serie_order'])) {
    $serie_order = $_GET['serie_order'];
}

if(isset($_GET['film_order'])) {
    $film_order = $_GET['film_order'];
}

if(isset($_GET['serie_switch'])) {
    $_SESSION['serieswitch'] = !$_SESSION['serieswitch'];
}

if(isset($_GET['film_switch'])) {
    $_SESSION['filmswitch'] = !$_SESSION['filmswitch'];
}


function getASC_or_DESC($switch) {
    if($switch) {
        return 'ASC';
    }
    return 'DESC';
}


$series = $pdo->prepare("SELECT * FROM series ORDER BY $serie_order " . getASC_or_DESC($_SESSION['serieswitch']));
$series->execute();

$film = $pdo->prepare("SELECT * FROM movies ORDER BY $film_order " . getASC_or_DESC($_SESSION['filmswitch']));
$film->execute();

$series_array = $series->fetchAll(PDO::FETCH_OBJ);
$movies_array = $film->fetchAll(PDO::FETCH_OBJ);


function echoSeries() {
    global $series_array;
    foreach ($series_array as $key) {
        echo 
        '<tr><td>' . $key->title . '</td>
            <td>' . $key->rating . '</td>
            <td>' . "<a href='series.php?id=$key->id'>details</a>" . '</td></tr>';
    }
}


function echoMovies() {
    global $movies_array;
    foreach ($movies_array as $key) {
        echo 
        '<tr><td>' . $key->title . '</td>
            <td>' . $key->duur . '</td>
            <td>' . "<a href='films.php?id=$key->id'>details</a>" . '</td></tr>';
    }
}



?>
<table>
<h3>Series</h3>
<tr>
<th><a href=<?php echo "index.php?serie_order=title&serie_switch=" . $_SESSION['serieswitch']; ?>>Titel</a></th>
<th><a href=<?php echo "index.php?serie_order=rating&serie_switch=" . $_SESSION['serieswitch']; ?>>Rating</a></th>
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
<th><a href=<?php echo "index.php?film_order=title&film_switch=" . $_SESSION['filmswitch']; ?>>Titel</a></th>
<th><a href=<?php echo "index.php?film_order=duur&film_switch=" . $_SESSION['filmswitch']; ?>>Duur</a></th>
</tr>
<tr>
<?php echoMovies($film); ?>
</tr>
</table>
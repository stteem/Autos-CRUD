<?php
require_once "pdo.php";
session_start();

if (! isset($_REQUEST['autos_id'])  ) {
    die('Missing autos_id parameter');
    /*header("Location: edit.php?autos_id=".$_POST['autos_id']);
    return;*/
}

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id']) ) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1
        || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }

    elseif (! is_numeric($_POST['year']) || (! is_numeric($_POST['mileage']))) {
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }

    else {

        $sql = "UPDATE autos2 SET make = :make,
            model = :model, year = :year,
            mileage = :mileage
            WHERE autos_id = :autos_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id' => $_POST['autos_id']));
            //$_SESSION['green'] = 'Record edited';
            header( 'Location: index.php' ) ;
            return;

    }


    
}

 //Guardian: Make sure that user_id is present
/*if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}*/

$stmt = $pdo->prepare("SELECT * FROM autos2 where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' );
    return;
}



$m = htmlentities($row['make']);
$n = htmlentities($row['model']);
$y = htmlentities($row['year']);
$p = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>


<!DOCTYPE html>
<html>
<head>
<title>Uwem Uke's Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Editing Automobile</h1>

<?php 
// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>

<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $m ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $n ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $y ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $p ?>"></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<p><input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel"></p>
</form>
</div>
</body>
</html>

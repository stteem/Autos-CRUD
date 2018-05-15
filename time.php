<?php 
$now = new DateTime();
$nextWeek = new DateTime('today + 1 week');

echo ("Now :  ". $now->format('Y-m-d') . "<br>");
echo "Next Week : ". $nextWeek->format('Y-m-d') . "\n";

echo "&nbsp";
?>


<?
if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
	echo ('<p><a href="add.php">Add New Entry</a></p>');
}
?>

<?
if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
?>
	<p><a href="add.php">Add New Entry</a></p>
<?	
}
?>
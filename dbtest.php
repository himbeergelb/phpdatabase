<?php
$dbhost = getenv("MYSQL_SERVICE_HOST");
$dbport = getenv("MYSQL_SERVICE_PORT");
$dbuser = getenv("databaseuser");
$dbpwd = getenv("databasepassword");
$dbname = getenv("databasename");

# $connection = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
# if ($connection->connect_errno) {
#     printf("Connect failed: %s\n", $mysqli->connect_error);
#     exit();
# } else {
#     printf("Connected to the database $dbname");
# }
# $connection->close();

$db = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
} else {
    printf("Connected to the database $dbname<br /><br /><br />");
}

$ergebnis = mysqli_query($db, "SELECT * FROM Angestellte");
# $abfrage = "SELECT url FROM links";

echo '<table border="1">';
while($row = mysqli_fetch_object($ergebnis))
{
  echo "<tr>";
  echo "<td>". $row->id . "</td>";
  echo "<td>". $row->Vorname . "</td>";
  echo "<td>". $row->Nachname . "</td>";
  echo "<td>". $row->PLZ . "</td>";
  echo "<td>". $row->Wohnort . "</td>";
  echo "<td>". $row->Telefon . "</td>";
  echo "<td>". $row->Geburtsdatum . "</td>";
  echo "</tr>";
}
echo "</table>";

?>

<?php
$dbhost = getenv("MYSQL_SERVICE_HOST");
$dbport = getenv("MYSQL_SERVICE_PORT");
$dbuser = getenv("databaseuser");
$dbpwd = getenv("databasepassword");
$dbname = getenv("databasename");

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO Angestellte (id, Nachname, Vorname, PLZ, Wohnort, Telefon, Geburtsdatum) VALUES (NULL, 'Meyer-Landrut', 'Lena', '33333', 'Hannover', '(0511)987654321', '1991-05-23');";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

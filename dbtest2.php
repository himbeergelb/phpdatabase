<?php
$dbhost = getenv("MYSQL_SERVICE_HOST");
$dbport = getenv("MYSQL_SERVICE_PORT");
$dbuser = getenv("databaseuser");
$dbpwd = getenv("databasepassword");
$dbname = getenv("databasename");

$link = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);

/* Datenbankverbindung prüfen */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}else{
    printf("Verbunden mit<ul><li>host: <tt>$dbhost</tt></li><li>port: <tt>$dbport</tt></li><li>database: <tt>$dbname</tt></li></ul>");
}

if ($result = mysqli_query($link, "SHOW TABLES FROM $dbname")) {
    printf("Die DB <tt>$dbname</tt> beinhaltet folgende %d Tabellen:<br />\n", mysqli_num_rows($result));

    /* free result set */
    mysqli_free_result($result);
}

///////////////////////////////////////////////
$showtables= mysqli_query($link, "SHOW TABLES FROM pma");

$ct = 0;
$maexist=0;
echo "<ul>";
while($table = mysqli_fetch_array($showtables)) { // go through each row that was returned in $result
	$ct ++;
	if ($table[0] == "Kollegen")
	{
		$maexist=1;
	}
    echo "<li>" .$ct. ". " . ($table[0] . "</li>");    // print the table that was returned on that row.
}
echo "</ul>";
// echo "maexist=". $maexist;

if ($maexist == 0) {
	$sql = "CREATE TABLE Kollegen (id INT AUTO_INCREMENT PRIMARY KEY, Nachname VARCHAR(20), Vorname VARCHAR(20), PLZ DECIMAL(5,0) UNSIGNED ZEROFILL, Wohnort VARCHAR(40), Telefon VARCHAR(20), Geburtsdatum DATE)";
	
	if ($link->query($sql) === TRUE) {
        echo "Tabelle <tt>Kollegen</tt> erfolgreich erstellt.";
    } else {
            echo "Error: " . $sql . "<br />" . $link->error;
    }
}

///////////////////////////////////////////////


$query = "SELECT * FROM Kollegen";
if ($stmt = mysqli_prepare($link, $query)) {

    /* Abfrage ausführen */
    mysqli_stmt_execute($stmt);

    /* Ergebnis holen */
    mysqli_stmt_store_result($stmt);

//    printf("Number of rows: %d.\n", mysqli_stmt_num_rows($stmt));

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "Die Tabelle <tt>Kollegen</tt> ist <strong>nicht</strong> leer:<br/ >";
				
		$ergebnis = mysqli_query($link, "SELECT * FROM Kollegen");
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
        } else {
                echo "Die Tabelle <tt>Kollegen</tt> ist leer, Daten werden erzeugt.";

                $sql = "INSERT INTO Kollegen (id, Nachname, Vorname, PLZ, Wohnort, Telefon, Geburtsdatum) VALUES
                (NULL, 'Meier', 'Peter', '12345', 'Berlin', '(030)555-5555', '1980-01-31'),
                (NULL, 'Meier', 'Petra', '12345', 'Berlin', '(030)555-5678', '1985-04-04'),
                (NULL, 'Mayer', 'Jana', '80123', 'Muenchen', '(089)89898989', '1966-11-24'),
                (NULL, 'Meyer-Landrut', 'Lena', '30333', 'Hannover', '(0511)987654321','1991-05-23'),
                (NULL, 'Landrut-Meyer', 'Nena', '33033', 'Hannover', '(0511)987654322', '1991-05-23')";

                if ($link->query($sql) === TRUE) {
                echo "Datensaetze erfolgreich erstellt.";
                } else {
                    echo "Error: " . $sql . "<br />" . $link->error;
                }
        }

    /* Abfrage-Objekt schliessen */
    mysqli_stmt_close($stmt);
}

/* Verbindung schliessen */
mysqli_close($link);
?>

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

$query = "SELECT * FROM Angestellte";
if ($stmt = mysqli_prepare($link, $query)) {

    /* Abfrage ausführen */
    mysqli_stmt_execute($stmt);

    /* Ergebnis holen */
    mysqli_stmt_store_result($stmt);

//    printf("Number of rows: %d.\n", mysqli_stmt_num_rows($stmt));

	if (mysqli_stmt_num_rows($stmt) > 0) {
		echo "Tabelle <tt>Angestellte</tt> ist da.";
	} else {
		echo "Tabelle <tt>Angestellte</tt> ist <strong>nicht</strong> da.";
	
		$sql = "INSERT INTO Angestellte (id, Nachname, Vorname, PLZ, Wohnort, Telefon, Geburtsdatum) VALUES 
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

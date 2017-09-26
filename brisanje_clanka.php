<?php 
	$clanak_id = $_REQUEST["id"];
	session_start();	
	if (!isset($_SESSION['korisnicko_ime'])) {
		echo 'Greska! Ulogujte se.';
	} 
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
	$username = $_SESSION['korisnicko_ime'];
	$query = "SELECT id FROM korisnici WHERE korisnicko_ime='$username'";
	$result = mysqli_query($conn, $query);
	$autor = mysqli_fetch_row($result);
	$autor = $autor[0];
	$query = "SELECT * FROM clanak WHERE id=$clanak_id";
	$result = mysqli_query($conn, $query);
	$clanak = mysqli_fetch_array($result);
	$autor_clanka = $clanak['autor'];
	if ($autor_clanka == $autor) {
		$query = "DELETE FROM clanak WHERE id=$clanak_id";
		$result = mysqli_query($conn, $query);
		echo 'Uspesno ste izbrisali clanak';
	} else {
		echo 'Ovom korisniku nije dozvoljeno brisanje';
	}
?>


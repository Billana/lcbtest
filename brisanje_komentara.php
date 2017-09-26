<?php 
	$komentar_id = $_REQUEST["id"];
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
	$query = "SELECT * FROM komentari WHERE id=$komentar_id";
	$result = mysqli_query($conn, $query);
	$komentar = mysqli_fetch_array($result);
	$autor_clanka = $komentar['autor'];
	if ($autor_clanka == $autor) {
		$query = "DELETE FROM komentari WHERE id=$komentar_id";
		$result = mysqli_query($conn, $query);
		echo 'Uspesno ste izbrisali komentar';
	} else {
		echo 'Ovom korisniku nije dozvoljeno brisanje';
	}
?>


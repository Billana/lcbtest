<?php 
	$kategorija_id = $_REQUEST["id"];
	session_start();	
	if (!isset($_SESSION['korisnicko_ime'])) {
		echo 'Greska! Ulogujte se.';
	} 
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
	$query = "SELECT * FROM clanak WHERE kategorija='$kategorija_id'";
	$rezultat = mysqli_query($conn, $query);
	$kategorije = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);
	if (count($kategorije) >= 1) {
		$query = "SELECT id FROM kategorija WHERE naslov='nekategorisano'";
		$rezultat = mysqli_query($conn, $query);
		$kategorije = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);
		if (count($kategorije) >= 1) {
			$kategorija = mysqli_fetch_row($rezultat);
			$nova_kategorija_id = $kategorija[0];
		} else {
			// Kreiranje nove kategorije za sirocice.
			$query = "INSERT INTO kategorija (naslov) VALUES ('nekategorisano')";
			$result = mysqli_query($conn, $query);
			$nova_kategorija_id = mysqli_insert_id($conn);
		}
		if($nova_kategorija_id == $kategorija_id) {
			// Kreiranje nove kategorije za sirocice.
			$query = "INSERT INTO kategorija (naslov) VALUES ('nekategorisano')";
			$result = mysqli_query($conn, $query);
			$nova_kategorija_id = mysqli_insert_id($conn);
		}
		// Dodeljivanje nove kategorije svim sirocicima.
		$query = "UPDATE clanak SET kategorija='$nova_kategorija_id' WHERE kategorija=$kategorija_id";
        $result = mysqli_query($conn, $query);
	}
	$query = "DELETE FROM kategorija WHERE id=$kategorija_id";
	$result = mysqli_query($conn, $query);
	echo 'Uspesno ste izbrisali kategoriju.';
?>


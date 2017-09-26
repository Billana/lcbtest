<?php
	session_start();
	if (!isset($_SESSION['korisnicko_ime'])) {
		header ("Location: login.php");
	} else {
		echo "Zdravo ".$_SESSION['korisnicko_ime'];
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
?>
<br><br>
<div>
<p>Lista svih clanaka</p>
<?php
	$query="SELECT id, naslov FROM clanak WHERE autor={$autor}";
	$rezultat=$conn->query($query);
	if (!empty($rezultat)) {
		$clanci= mysqli_fetch_all($rezultat, MYSQLI_ASSOC);	
	foreach ($clanci as $clanak) {
		echo "<p>";
		echo "<a style='margin-left:10px' href='pregled_clanka.php?id={$clanak['id']}'>{$clanak['naslov']}</a>";
		echo "<a style='margin-left:10px' href='izmena_clanka.php?id={$clanak['id']}'>Izmeni</a>";
		echo "<a style='margin-left:10px' href='#' class='brisanje_clanka' clanak_id='{$clanak['id']}' clanak_naslov='{$clanak['naslov']}'>Izbrisi</a>";
		echo "</p>";
	}
	}
?>
<p><a href="clanak.php">+ Kreiraj novi clanak.</a>
</p>
</div>
<br>
<div>
<p>Lista svih kategorija</p>
<?php
	$query="SELECT id, naslov FROM kategorija";
	$rezultat=$conn->query($query);
	if (!empty($rezultat)) {
		$kategorije = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);	
	foreach ($kategorije as $kategorija) {
		echo "<p>";
		echo $kategorija['naslov'];
		echo "<a style='margin-left:10px' href='izmena_kategorije.php?id={$kategorija['id']}'>Izmeni</a>";
		echo "<a style='margin-left:10px' href='#' class='brisanje_kategorije' kategorija_id='{$kategorija['id']}' kategorija_naslov='{$kategorija['naslov']}'>Izbrisi</a>";
		echo "</p>";
	}
	}
?>
<p><a href="kategorija.php">+ Kreiraj novu kategoriju.</a>
</p>
</div>
<br>
<a href="logout.php">Izloguj se</a>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	$( document ).ready(function() {
		$('.brisanje_clanka').on('click', function() {
			var clanak_id = $(this).attr('clanak_id');
			var clanak_naslov = $(this).attr('clanak_naslov');
			var r = confirm("Da li ste sigurni da zelite da izbrisete clanak: '" + clanak_naslov + "'?");
			if (r == true) {
				$.ajax({
				  method: "POST",
				  url: "brisanje_clanka.php",
				  data: { id: clanak_id }
				})
				  .done(function( response ) {
					alert( response );
					location.reload();
				  });
			}
		});
		$('.brisanje_kategorije').on('click', function() {
			var kategorija_id = $(this).attr('kategorija_id');
			var kategorija_naslov = $(this).attr('kategorija_naslov');
			var r = confirm("Da li ste sigurni da zelite da izbrisete kategoriju: '" + kategorija_naslov + "'?");
			if (r == true) {
				$.ajax({
				  method: "POST",
				  url: "brisanje_kategorije.php",
				  data: { id: kategorija_id }
				})
				  .done(function( response ) {
					alert( response );
					location.reload();
				  });
			}
		});
	});
</script>
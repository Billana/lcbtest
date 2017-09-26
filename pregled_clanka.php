<?php 
	$clanak_id = $_REQUEST["id"];
	session_start();	
	if (!isset($_SESSION['korisnicko_ime'])) {
		header ("Location: login.php");
	} 
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
	$query = "SELECT * FROM clanak WHERE id=$clanak_id";
	$result = mysqli_query($conn, $query);
	$clanak = mysqli_fetch_array($result);
	// trenutni korisnik
	$username = $_SESSION['korisnicko_ime'];
	$query = "SELECT id FROM korisnici WHERE korisnicko_ime='$username'";
	$result = mysqli_query($conn, $query);
	$autor = mysqli_fetch_row($result);
	$autor = $autor[0];
	// dodavanje komentara
	if (isset($_POST['naslov'])){
        $naslov = $_POST['naslov'];
        $query = "INSERT INTO komentari (tekst, clanak, autor) VALUES ('$naslov', $clanak_id, $autor)";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Komentar je dodat.";
        }else{
            $message ="Doslo je do greske.";
			$message.=mysqli_error($conn);
        }
		echo $message;
    }	

?>
	<h1><?php echo $clanak['naslov']; ?></h1>
	<p><?php echo $clanak['tekst']; ?></p>
	<h2>Komentari</h2>
<?php
	$query = "SELECT * FROM komentari WHERE clanak=$clanak_id";
	$result = mysqli_query($conn, $query);
	$komentari = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if (!empty($komentari)) {
		foreach ($komentari as $komentar){
			echo "<p>";
			echo $komentar['tekst'];
			if($komentar['autor'] == $autor) {
				echo "<a style='margin-left:10px' href='izmena_komentara.php?id={$komentar['id']}'>Izmeni</a>";
				echo "<a style='margin-left:10px' href='#' class='brisanje_komentara' komentar_id='{$komentar['id']}' komentar_tekst='{$komentar['tekst']}'>Izbrisi</a>";
			}
			echo "</p>";
		}
	}
?>
<hr>
<form name="komentar" method="post" action="">
	<div style="width:500px;">
		<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
			<tr class="tableheader">
				<td colspan="2">Dodaj komentar</td>
			</tr>
			<tr>
				<td><label>Komentar</label></td>
				<td><input type="text" name="naslov" class="txtField" value=""></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Komentarisi" class="btnSubmit"></td>
			</tr>
		</table>
	</div>
</form>
<a href="index.php">Vrati se na pocetak.</a>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	$( document ).ready(function() {
		$('.brisanje_komentara').on('click', function() {
			var komentar_id = $(this).attr('komentar_id');
			var komentar_tekst = $(this).attr('komentar_tekst');
			var r = confirm("Da li ste sigurni da zelite da izbrisete komentar: '" + komentar_tekst + "'?");
			if (r == true) {
				$.ajax({
				  method: "POST",
				  url: "brisanje_komentara.php",
				  data: { id: komentar_id }
				})
				  .done(function( response ) {
					alert( response );
					location.reload();
				  });
			}
		});
	});
</script>
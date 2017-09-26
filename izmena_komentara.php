<?php 
	$komentar_id = $_REQUEST["id"];
	session_start();	
	if (!isset($_SESSION['korisnicko_ime'])) {
		header ("Location: login.php");
	} 
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
	$username = $_SESSION['korisnicko_ime'];
	$query = "SELECT id FROM korisnici WHERE korisnicko_ime='$username'";
	$result = mysqli_query($conn, $query);
	$autor = mysqli_fetch_row($result);
	$ulogovani_korisnik = $autor[0];
	$query = "SELECT * FROM komentari WHERE id=$komentar_id";
	$result = mysqli_query($conn, $query);
	$komentar = mysqli_fetch_array($result);
	$autor_komentara = $komentar['autor'];
	if ($autor_komentara != $ulogovani_korisnik) {
		header('Location: index.php');
	}
	if (isset($_POST['tekst'])){
        $tekst = $_POST['tekst'];
        $query = "UPDATE komentari SET tekst='$tekst' WHERE id=$komentar_id";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Komentar je izmenjen.";
			$query = "SELECT * FROM komentari WHERE id=$komentar_id";
			$result = mysqli_query($conn, $query);
			$komentar = mysqli_fetch_array($result);
        }else{
            $message ="Doslo je do greske.";
			$message.=mysqli_error($conn);
        }
		echo $message;
    }	
?>
<form name="komentar" method="post" action="">
	<div style="width:500px;">
		<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
			<tr class="tableheader">
				<td colspan="2">Izmena komentara</td>
			</tr>
			<tr>
				<td><label>Naslov</label></td>
				<td><input type="text" name="tekst" class="txtField" value="<?php echo $komentar['tekst']; ?>"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Izmeni" class="btnSubmit"></td>
			</tr>
		</table>
	</div>
</form>
<a href="index.php">Vrati se na pocetak.</a>
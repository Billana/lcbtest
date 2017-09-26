<?php 
	$kategorija_id = $_REQUEST["id"];
	session_start();	
	if (!isset($_SESSION['korisnicko_ime'])) {
		header ("Location: login.php");
	} 
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
	$query = "SELECT * FROM kategorija WHERE id=$kategorija_id";
	$result = mysqli_query($conn, $query);
	$kategorija = mysqli_fetch_array($result);
	if (isset($_POST['naslov'])){
        $naslov = $_POST['naslov'];
        $query = "UPDATE kategorija SET naslov='$naslov' WHERE id=$kategorija_id";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Kategorija je izmenjena.";
			$query = "SELECT * FROM kategorija WHERE id=$kategorija_id";
			$result = mysqli_query($conn, $query);
			$kategorija = mysqli_fetch_array($result);
        }else{
            $message ="Doslo je do greske.";
			$message.=mysqli_error($conn);
        }
		echo $message;
    }	
?>
<form name="clanak" method="post" action="">
	<div style="width:500px;">
		<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
			<tr class="tableheader">
				<td colspan="2">Izmena kategorije</td>
			</tr>
			<tr>
				<td><label>Naslov</label></td>
				<td><input type="text" name="naslov" class="txtField" value="<?php echo $kategorija['naslov']; ?>"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Izmeni" class="btnSubmit"></td>
			</tr>
		</table>
	</div>
</form>
<a href="index.php">Vrati se na pocetak.</a>
<?php
	session_start();
	if (!isset($_SESSION['korisnicko_ime'])) {
		header ("Location: login.php");
	} 
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
	if (isset($_POST['naslov'])){
        $naslov = $_POST['naslov'];
        $query = "INSERT INTO kategorija (naslov) VALUES ('$naslov')";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Kategorija je kreirana.";
			header('Location: lcbtest.php');
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
				<td colspan="2">Kreiraj kategoriju</td>
			</tr>
			<tr>
				<td><label>Naslov</label></td>
				<td><input type="text" name="naslov" class="txtField"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Kreiraj" class="btnSubmit"></td>
			</tr>
		</table>
	</div>
</form>
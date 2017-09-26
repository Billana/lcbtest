<?php
	session_start();
	if (!isset($_SESSION['korisnicko_ime'])) {
		header ("Location: login.php");
	} 
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
	$query="SELECT id, naslov FROM kategorija";
	$rezultat=$conn->query($query);
	$kategorije = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);
	if (isset($_POST['naslov']) && isset($_POST['tekst']) && isset($_POST['kategorija'])){
        $naslov = $_POST['naslov'];
        $tekst = $_POST['tekst'];
		$kategorija = $_POST ['kategorija'];
		$username = $_SESSION['korisnicko_ime'];
		$query = "SELECT id FROM korisnici WHERE korisnicko_ime='$username'";
		$result = mysqli_query($conn, $query);
		$autor = mysqli_fetch_row($result);
		$autor = $autor[0]; 
        $query = "INSERT INTO clanak (naslov, tekst, kategorija, autor) VALUES ('$naslov', '$tekst', '$kategorija', '$autor')";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Clanak je objavljen.";
			header('Location: index.php');
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
				<td colspan="2">Napisi clanak</td>
			</tr>
			<tr>
				<td><label>Naslov</label></td>
				<td><input type="text" name="naslov" class="txtField"></td>
			</tr>
			<tr>
				<td><label>Tekst</label></td>
				<td><input type="text" name="tekst" class="txtField"></td>
			</tr>
				<td><label>Kategorija</label></td>
				<td><select name="kategorija">
				<?php
				foreach ($kategorije as $kategorija) {
				echo "<option value='".$kategorija["id"]."'>".$kategorija["naslov"]."</option>";
				}
				?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Kreiraj" class="btnSubmit"></td>
			</tr>
		</table>
	</div>
</form>
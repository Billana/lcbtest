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
	$username = $_SESSION['korisnicko_ime'];
	$query = "SELECT id FROM korisnici WHERE korisnicko_ime='$username'";
	$result = mysqli_query($conn, $query);
	$autor = mysqli_fetch_row($result);
	$autor = $autor[0];
	$query = "SELECT * FROM clanak WHERE id=$clanak_id";
	$result = mysqli_query($conn, $query);
	$clanak = mysqli_fetch_array($result);
	$autor_clanka = $clanak['autor'];
	if ($autor_clanka != $autor) {
		header('Location: index.php');
	}
	$query="SELECT id, naslov FROM kategorija";
	$rezultat=$conn->query($query);
	$kategorije = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);
	if (isset($_POST['naslov']) && isset($_POST['tekst']) && isset($_POST['kategorija'])){
        $naslov = $_POST['naslov'];
        $tekst = $_POST['tekst'];
		$kategorija = $_POST ['kategorija'];
        $query = "UPDATE clanak SET naslov='$naslov', tekst='$tekst', kategorija='$kategorija' WHERE id=$clanak_id";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Clanak je izmenjen.";
			$query = "SELECT * FROM clanak WHERE id=$clanak_id";
			$result = mysqli_query($conn, $query);
			$clanak = mysqli_fetch_array($result);
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
				<td><input type="text" name="naslov" class="txtField" value="<?php echo $clanak['naslov']; ?>"></td>
			</tr>
			<tr>
				<td><label>Tekst</label></td>
				<td><input type="text" name="tekst" class="txtField" value="<?php echo $clanak['tekst']; ?>"></td>
			</tr>
				<td><label>Kategorija</label></td>
				<td><select name="kategorija">
				<?php
				foreach ($kategorije as $kategorija) {
					if ($kategorija['id'] == $clanak['kategorija']) {
						echo "<option value='".$kategorija["id"]."' selected>".$kategorija["naslov"]."</option>";
					} else { 
						echo "<option value='".$kategorija["id"]."'>".$kategorija["naslov"]."</option>";
					}
				}
				?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Izmeni" class="btnSubmit"></td>
			</tr>
		</table>
	</div>
</form>
<a href="index.php">Vrati se na pocetak.</a>
<?php
	session_start();
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
    if (isset($_POST['korisnicko_ime']) && isset($_POST['sifra'])){
        $username = $_POST['korisnicko_ime'];
        $password = $_POST['sifra'];
		$query = "SELECT * FROM korisnici WHERE korisnicko_ime='$username' AND sifra='$password'";
		$result = mysqli_query($conn, $query);
		$count = mysqli_num_rows($result);
        if($count == 1){
            $message = "Korisnik ulogovan.";
			$_SESSION['korisnicko_ime'] = $username;
			header('Location: index.php');
        }else{
            $message ="Neispravno korisnicko ime ili sifra.";
        }
			echo $message;
	}
?>
            <section class="tm-section tm-section-contact" id="contact">
                <div class="tm-page-content-width">
                    <div class="tm-bg-black-translucent text-xs-left tm-textbox tm-2-col-textbox-2 tm-textbox-padding tm-textbox-padding-contact tm-content-box  tm-content-box-right">
                        <h2 class="tm-section-title">Prijava</h2>
                        <form action="login.php" method="post" class="tm-contact-form">

                            <div class="form-group">
                                <input type="text" id="korisnicko_ime" name="korisnicko_ime" class="form-control" placeholder="Korisnicko ime"  required/>
                            </div
							<div class="form-group">                                                        
                                <input type="password" id="sifra" name="sifra" class="form-control" placeholder="Sifra"  required/>
                            </div>    
                            <button type="submit" class="tm-submit-btn" name="login">Prijavi se</button>
                        
                        </form>  
                    </div>
                </div>             
            </section>
<a href="registracija.php">Registruj se</a>
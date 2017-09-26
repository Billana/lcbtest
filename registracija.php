<?php
    session_start();
	if (isset($_SESSION['korisnicko_ime'])) {
		header ("Location: index.php");
	}
	$conn = new mysqli("localhost", "root", "", "lcbtest");
	if ($conn->connect_error) {
		die ("Connection failed: " . $conn->connect_error);
	}
    if (isset($_POST['korisnicko_ime']) && isset($_POST['sifra']) && isset($_POST['user_type'])){
        $username = $_POST['korisnicko_ime'];
        $password = $_POST['sifra'];
		$user_type = $_POST ['user_type'];
        $query = "INSERT INTO korisnici (korisnicko_ime, sifra, administrator) VALUES ('$username', '$password', '$user_type')";
        $result = mysqli_query($conn, $query);
        if($result){
            $message = "Korisnik registrovan.";
			$_SESSION['korisnicko_ime'] = $username;
			header('Location: index.php');
        }else{
            $message ="Doslo je do greske.";
			$message.=mysqli_error($conn);
        }
		echo $message;
    }
?>
            <section class="tm-section tm-section-contact" id="contact">
                <div class="tm-page-content-width">
                    <div class="tm-bg-black-translucent text-xs-left tm-textbox tm-2-col-textbox-2 tm-textbox-padding tm-textbox-padding-contact tm-content-box  tm-content-box-right">
                        <h2 class="tm-section-title">Registracija</h2>
                        <form action="registracija.php" method="post" class="tm-contact-form">

                            <div class="form-group">
                                <input type="text" id="korisnicko_ime" name="korisnicko_ime" class="form-control" placeholder="Korisnicko ime"  required/>
                            </div
							<div class="form-group">                                                        
                                <input type="password" id="sifra" name="sifra" class="form-control" placeholder="Sifra"  required/>
                            </div>    
                            <div class="form-group">
								<select class="form-control" id="user_type" name="user_type">
								  <option value="1">Administrator</option>
								  <option value="0">Moderator</option>
								</select>
                            </div> 

                            <button type="submit" class="tm-submit-btn" name="register">Register</button>
                        
                        </form>  
                    </div>
                </div>             
            </section>
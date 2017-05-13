<?php include('db_connect.php'); 
$imie = ''; /* zmienna w php która kieruje do inputa z name=imie */
$nazwisko = '';
$email = '';
$telefon = '';
$ulica = '';
$miasto = '';
$login = '';
$haslo = '';
$powtorz = '';

$errorImie = ''; /* zmienne do wyświetlania błędów */
$errorNazwisko = '';
$errorEmail = '';
$errorTelefon = '';
$errorUlica = '';
$errorMiasto = '';
$errorLogin = '';
$errorHaslo = '';
$errorPowtorz = '';

if ( isset( $_POST['wyslij'] ) ) { /* wykonanie uzupełnionego formularza */
	$imie = $_POST['imie'];
	$nazwisko = $_POST['nazwisko'];
	$email = $_POST['email'];
	$telefon = $_POST['telefon'];
	$ulica = $_POST['ulica'];
	$miasto = $_POST['miasto'];
	$login = $_POST['login'];
	$haslo = $_POST['haslo'];
	$powtorz = $_POST['powtorz'];
	
	if(! ($imie && $nazwisko && $email && $telefon && $ulica && $miasto && $login && $haslo && $powtorz) ){

		if ( ! $imie ) { /* jeżeli jest puste - wyświetl błąd */ 
			$errorImie = 'Uzupełnij pole';
		} 

		if ( ! $nazwisko ) {
			$errorNazwisko = 'Uzupełnij pole';
		} 

		if ( ! $email ) {
			$errorEmail = 'Uzupełnij pole';
		} elseif ( $email && ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {  /* funkcja sprawdzająca poprawny format emaila */
			$errorEmail = 'Upewnij się, że adres email ma prawidłowy format';
		}

		if ( ! $telefon ) {
			$errorTelefon = 'Uzupełnij pole';
		} 

		if ( ! $ulica ) {
			$errorUlica = 'Uzupełnij pole';
		} 

		if ( ! $miasto ) {
			$errorMiasto = 'Uzupełnij pole';
		} 

		if ( ! $login ) {
			$errorLogin = 'Uzupełnij pole';
		}

		if ( ! $haslo ) {
			$errorHaslo = 'Uzupełnij pole';
		} elseif ( $haslo && strlen($haslo) < 6 ) { /* sprawdza długość hasła */ 
			$errorHaslo = 'Hasło musi zawierać minimum 6 znaków';
		} elseif ( $haslo != $powtorz ) {  /* jeżeli hasła się różnią, wykonaj */ 
			$errorHaslo = 'Dwa rozne hasla';
		}

		if ( ! $powtorz ) { /* brak uzupełnionego pola - uzupełnij */
			$errorPowtorz = 'Uzupełnij pole';
		} 
	}else{  /* jeżeli wszystko zostało uzupełnione, wykonuje się instrukcja insert */
		$statement = $mysqli->prepare("INSERT uzytkownicy (imie,nazwisko,email,telefon,ulica,miasto,login,haslo) VALUES (?,?,?,?,?,?,?,?)");
		$statement->bind_param("sssissss",$imie,$nazwisko,$email,$telefon,$ulica,$miasto,$login,$haslo); /* funkcja wstawia zamiast znaków zapytania, wartości z inputów */ 
		$statement->execute();
		$statement->close();
		header("Location:zaloguj.php"); /* po wykonaniu przekieruj na zaloguj.php */
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">

<head>
	<title>Otomoto</title>

	<meta charset= "utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
</script>
	
</head>

<body>

	<header class="gora">
		<div class="wyrownanie">
			<div class="wyrownanie zmien-logo">
				<a href="index.php"><img src="img/logo.png" class="logo" alt=""></a>
			</div>
			<div class="wyrownanie odstep">
				<div class="main-menu">
					<ul>
						<li><a href="kategoria.php">Kategoria</a></li>
						<li>/</li>
						<li><a href="rejestracja.php">Rejestracja</a></li>
						<li>/</li>
						<li><a href="zaloguj.php">Zaloguj się</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>


	<section class="rejestruj">
		<div class="przes-h2">
			<h2>Zarejestruj się</h2>
		</div>
		<div class="wyrownanie kolortla2">
			<div class="polowa">
				<form name="formularz" action="#" method="post" onsubmit="sprawdz_formularz()">
					<fieldset>
						<label for="name">
							<strong>Imię</strong>
						</label><br>
						<div class="zmien">
							<?php if ( $errorImie != null ) { ?> <!-- wyświetlenie błędów, dalej tak samo -->
									<?php echo $errorImie; ?>
							<?php } ?>
						</div>
						<input type="text" name="imie" value="<?php echo $imie;?>"><br> <!-- php echo - zapamiętanie inputów po odświeżeniu -->
						<label for="email">
							<strong>Nazwisko</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorNazwisko != null ) { ?>
									<?php echo $errorNazwisko; ?>
							<?php } ?>
						</div>
						<input type="text" name="nazwisko" value="<?php echo $nazwisko;?>"><br>
						
						<label for="email">
							<strong>E-mail</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorEmail != null ) { ?>
									<?php echo $errorEmail; ?>
							<?php } ?>
						</div>
						<input type="text" name="email" value="<?php echo $email;?>"><br>

						<label for="telefon">
							<strong>Telefon</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorTelefon != null ) { ?>
									<?php echo $errorTelefon; ?>
							<?php } ?>
						</div>
						<input type="text" name="telefon" value="<?php echo $telefon;?>"><br>
						
						<label for="ulica">
							<strong>Ulica zamieszkania</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorUlica != null ) { ?>
									<?php echo $errorUlica; ?>
							<?php } ?>
						</div>
						<input type="text" name="ulica" value="<?php echo $ulica;?>"><br>

						<label for="miasto">
							<strong>Miasto</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorMiasto != null ) { ?>
									<?php echo $errorMiasto; ?>
							<?php } ?>
						</div>
						<input type="text" name="miasto" value="<?php echo $miasto;?>"><br>
						
						<label for="name">
							<strong>Login</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorLogin != null ) { ?>
									<?php echo $errorLogin; ?>
							<?php } ?>
						</div>
						<input type="text" name="login" value="<?php echo $login;?>"><br>
						<label for="haslo">
							<strong>Hasło</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorHaslo != null ) { ?>
									<?php echo $errorHaslo; ?>
							<?php } ?>
						</div>
						<input type="password" name="haslo"><br>
						
						<label for="powtorzhaslo">
							<strong>Powtórz hasło</strong>
						</label><br>
						<div class="ui-red-label">
							<?php if ( $errorPowtorz != null ) { ?>
									<?php echo $errorPowtorz; ?>
							<?php } ?>
						</div>
						<input type="password" name="powtorz"><br>

						<input type="submit" name="wyslij" value="Zarejestruj się" class="button" />
					</fieldset>
				</form>
			</div>

			<div class="polowa">
				<img src="icon/icon2.png" class="icon" alt="">
			</div>
		</div>
	</section>

	

	<footer>
		<p>Projekt wykonany przez: Danecka Agnieszka, Michałowski Oskar, Puk Dominika</p>
	</footer>
</body>
</html>
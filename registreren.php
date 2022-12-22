<?php
require_once "./models/db.php";
$db = new DB();
$registrationDone = False;
?>
<!doctype html>
<html lang="nl">

<head>
  <title>Registreren</title>
  <?= include_once("./components/header_info.php"); ?>

</head>

<body>
  <header>
    <!-- place navbar here -->
    <?php
        include_once "./components/menu.php";
    ?>
    
  </header>
  <main>

  <div class="container">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col">
            <img src="./imgs/undraw_my_app_re_gxtj.svg" alt="Registreren">
        </div>
        <div class="col">
            <div class="container">
                <?php
                $voornaam = "";
                $naam = "";
                $email = "";
                $wachtwoord = "";
                try {
                    // Controleer als de srv-request post is
                    if($_SERVER["REQUEST_METHOD"] == "POST")
                    { 
                        // Plaats alle inputvelden in een variabele
                        $voornaam = $_POST["inputVoornaam"];
                        $naam = $_POST["inputNaam"];
                        $email = $_POST["inputEmail"];
                        $wachtwoord = $_POST["inputWachtwoord"];
                        $foutmelding = False;
    
                        // Controleer of alle velden ingevuld zijn
                        if(!(strlen($voornaam)>=2 && strlen($naam)>=2 && strlen($email)>=2 && strlen($wachtwoord)>=2))
                        {
                            $foutmelding = True;
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              Alle velden moeten ingevuld worden!
                            </div>
                            
                            <script>
                              var alertList = document.querySelectorAll('.alert');
                              alertList.forEach(function (alert) {
                                new bootstrap.Alert(alert)
                              })
                            </script>";
                        }
                        // Kijk of het wachtwoord aan bepaalde zaken voldoet
    
    
    
    
    
    
                        // Wachtwoord beveiligen
                        if(!$foutmelding)
                        {
                            $wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
    
                            // Controleer of het e-mailadres al in de database voorkomt
                            $emailadresBestaat = $db->select_data("SELECT id FROM `tb_gebruikers` WHERE email=?", "s", $email);
                            if(count($emailadresBestaat)>=1)
                            {
                                $foutmelding = True;
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  Dit e-mailadres staat al in onze database!
                                </div>
                                
                                <script>
                                  var alertList = document.querySelectorAll('.alert');
                                  alertList.forEach(function (alert) {
                                    new bootstrap.Alert(alert)
                                  })
                                </script>";
                            }
                        }
    
                        // Voeg de gebruiker toe aan de database
                        if(!$foutmelding)
                        {
                            $isGelukt = $db->rij_toevoegen_bewerken_verwijderen("INSERT INTO `tb_gebruikers` (`id`, `voornaam`, `naam`, `wachtwoord`, `email`, `email_bevestigd`) VALUES (uuid(), ?, ?, ?, ?, 0)", "ssss", $voornaam, $naam, $wachtwoord, $email);
                            if(!$isGelukt)
                            {
                                $foutmelding = True;
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  Registratie is mislukt!
                                </div>
                                
                                <script>
                                  var alertList = document.querySelectorAll('.alert');
                                  alertList.forEach(function (alert) {
                                    new bootstrap.Alert(alert)
                                  })
                                </script>";
                            }
                        }
    
                        // Stuur een bevestigingsmail naar het e-mailadres van de gebruiker
                        if(!$foutmelding)
                        {
                            // Maak een activatiecode + zet hem in de database
                            $activatiecode = uniqid();
                            $isGelukt = $db->rij_toevoegen_bewerken_verwijderen("UPDATE `tb_gebruikers` SET `activatiecode`=? WHERE email=?", "ss", $activatiecode, $email);
                            if(!$isGelukt)
                            {
                                $foutmelding = True;
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  Registratie is mislukt!
                                </div>
                                
                                <script>
                                  var alertList = document.querySelectorAll('.alert');
                                  alertList.forEach(function (alert) {
                                    new bootstrap.Alert(alert)
                                  })
                                </script>";
                            }
                            else
                            {
                                // Verzend link naar gebruiker
                                $activatielink = "http://localhost:9000/activeerAccount.php?email=".$email."&code=".$activatiecode;
                                $bericht = "Beste\nHierbij de link voor activatie: ".$activatielink;
                                $registrationDone = True;
                                // Verstuur email
                                mail($email,"Activatie account",$bericht);
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  Registratie is gelukt! U ontvangt zodadelijk een e-mail met daarin de activatiecode.
                                </div>
                                
                                <script>
                                  var alertList = document.querySelectorAll('.alert');
                                  alertList.forEach(function (alert) {
                                    new bootstrap.Alert(alert)
                                  })
                                </script>";
                            }
                        }
                    }
                } catch (\Throwable $th) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        Registratie is mislukt!
                    </div>
                    
                    <script>
                        var alertList = document.querySelectorAll('.alert');
                        alertList.forEach(function (alert) {
                        new bootstrap.Alert(alert)
                        })
                    </script>";
                }
                ?>
                 <form method="post" class="<?= $registrationDone? 'invisible' : 'visible'?>">
                        <div class="mb-3 row">
                            <label for="inputVoornaam" class="col-4 col-form-label">Voornaam</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="inputVoornaam" id="inputVoornaam" placeholder="Voornaam" value="<?= $voornaam ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputNaam" class="col-4 col-form-label">Naam</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="inputNaam" id="inputNaam" placeholder="Naam" value="<?= $naam ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputEmail" class="col-4 col-form-label">E-mail</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="test@bedrijf.be" value="<?= $email ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputWachtwoord" class="col-4 col-form-label">Wachtwoord</label>
                            <div class="col-8">
                                <input type="password" class="form-control" name="inputWachtwoord" id="inputWachtwoord" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="offset-sm-4 col-sm-8">
                                <button type="submit" class="btn btn-primary">Registreren</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
  </div>

  </main>
  <!-- Bootstrap JavaScript Libraries -->
  <?= include_once("./components/bt_libs.php"); ?>
</body>

</html>
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
                 <form method="post" class="visible">
                        <div class="mb-3 row">
                            <label for="inputVoornaam" class="col-4 col-form-label">Voornaam</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="inputVoornaam" id="inputVoornaam" placeholder="Voornaam" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputNaam" class="col-4 col-form-label">Naam</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="inputNaam" id="inputNaam" placeholder="Naam" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputEmail" class="col-4 col-form-label">E-mail</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="test@bedrijf.be" required>
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
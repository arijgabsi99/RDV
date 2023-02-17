<?php
session_start();
$serveur = "localhost";
$dbname = "rdv";
$user = "root";
$pass = "";
$err = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $dbco = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $requser = $dbco->prepare("SELECT * from utilisateur Where email= :email");
        $requser->execute(["email" => $_POST["email"]]);
        if (!empty($requser->fetch())) {
            $err  = 'email deja existe.';
        } else {

            $err = 'reservation bien envoyer ! ';

            include("rdv/index.php");
        }
    } catch (PDOException $e) {
        echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <title>Rendez-vous</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="javascript.js" defer></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
</head>

<body>
    <div class="main-block">
        <a class="tiledBackground"></a>
        <form action="/" method="post">
            <div class="title">
                <i class="fas fa-pencil-alt"></i>
                <h2>Prendre un Rendez-vous</h2>
            </div>
            <div class="info">
                <?php $name = $_POST['nom'] ?? ''; ?>
                <input class="fname" type="text" name="nom" id="nom" value='<?= $name; ?>' placeholder="Nom" required
                    pattern="[a-z A-Z ]*" autocomplete="on">
                <?php $name = $_POST['prenom'] ?? ''; ?>
                <input class="fname" type="text" name="prenom" placeholder="Prenom" value='<?= $name; ?>' required
                    pattern="[a-z A-Z]*" autocomplete="on">
                <?php $name = $_POST['age'] ?? ''; ?>
                <input class="fname" type="number" name="age" placeholder="Age" value='<?= $name; ?>' required
                    autocomplete=" on">
                <?php $name = $_POST['email'] ?? ''; ?>
                <input type="email" name="email" class="fname" id="email" value='<?= $name; ?>' required
                    placeholder="Email" autocomplete="on"> <span class="validity"></span>
                <?php $name = $_POST['numero_tel'] ?? ''; ?>
                <input id="tel" name="numero_tel" type="text" placeholder="Numero Telephone" value='<?= $name; ?>'
                    required pattern="(00216|\+216){0,}[]{0,}(2|5|9)[0-9][ ]{0,}[0-9]{3}[ ]{0,}[0-9]{3}"
                    autocomplete="on"> <span class="validity"></span>

                <b>Veuillez choisir la date et l'heure du votre rendez-vous :</b>
                <li>
                    <label for="meeting-time">Date :</label>
                    <?php $name = $_POST['daterdv'] ?? ''; ?>
                    <input type="date" id="meeting-time" name="daterdv" min="2023-02-14" value='<?= $name; ?>' required
                        max="2023-06-31" required>
                    <span class="validity"></span>
                </li>
                <li>

                    <label for="appt">Heure :</label>
                    <?php $name = $_POST['heure'] ?? ''; ?>
                    <input type="time" id="appt" name="heure" min="08:00" max="17:30" value='<?= $name; ?>' required>
                    <br>

                </li>

                <label for="exampleFormControlFile1 ">Votre Dossier</label>
                <input type="file" id="file" name="file" accept="image/png, image/jpeg">

            </div>

            <button type="submit" class="btn" id="success" name="valider">Reserver !</button>

            <?php echo "$err";

            ?>




        </form>
    </div>
</body>

</html>
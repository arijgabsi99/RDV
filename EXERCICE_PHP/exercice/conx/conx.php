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
        $requser = $dbco->prepare("SELECT * from medecin Where (email= :email)and(motdepass= :motdepass)");
        $requser->execute(array("email" => $_POST["email"], "motdepass" => $_POST["motdepass"]));

        if (!empty($requser->fetch())) {
            $err  = 'email deja existe.';
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["nomdr"] = $_POST['nom'];

            header("Location:liste.php");
        } else {
            $err  = 'verifier vos informations.';
            //header("Location:conx.php");
        }
    } catch (PDOException $e) {
        echo 'Impossible de traiter les données. Erreur : ' . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html>
<title>Se connecter</title>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="conxstyle1.css">
</head>

<body>
    <form action="" method="post">
        <h1>Se connecter </h1>
        <div class="icon">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="formcontainer">
            <div class="container">
                <label for="nom" name='nom'><strong>Nom</strong></label>
                <?php $name = $_POST['nom'] ?? ''; ?>
                <input type="text" placeholder="Votre Nom" name="nom" pattern="[a-z A-Z ]*" value='<?= $name; ?>' required>
                <label for="mail" name='email'><strong>E-mail</strong></label>
                <?php $name = $_POST['email'] ?? ''; ?>
                <input type="text" placeholder="Votre E-mail" name="email" value='<?= $name; ?>' required>
                <label for="psw"><strong>Password</strong></label>
                <?php $name = $_POST['motdepass'] ?? ''; ?>
                <input type="password" placeholder="Votre mot de pass" name="motdepass" value='<?= $name; ?>' required>
            </div>

            <button name="submit" type="submit"><strong>Se connecter</strong></button>
            <span>
                <?php echo "$err";

                ?>
            </span>
            <div class="container" style="background-color: #eee">
                <label style="padding-left: 15px">
                    <input type="checkbox" checked="checked" name="remember"> Souviens-toi de moi
                </label>
                <span class="psw"><a href="#">Mot De Passe oublié?</a></span>
            </div>
    </form>
</body>

</html>
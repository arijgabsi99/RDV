<?php
session_start();
$serveur = "localhost";
$dbname = "rdv";
$user = "root";
$pass = "";
$err = '';
$nomdr = $_SESSION["nomdr"];
try {
    $dbco = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass);
    $id =  $_GET['id'];
    $sql = $dbco->prepare("SELECT * FROM rendez_vous WHERE id = '$id'");
    $sql->execute();
    $stmt = $sql->fetch(PDO::FETCH_ASSOC);
    $_SESSION["nom"] = $stmt['nom'];
    $_SESSION["prenom"] = $stmt['prenom'];
    $_SESSION["email"] = $stmt['email'];
    $reponse = $_GET["reponse"];
    $sql = $dbco->prepare("UPDATE rendez_vous SET reponse = '$reponse' WHERE id = '$id'");
    $valid_statement = $sql->execute();

    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
    $response = ($reponse == 1) ? "ACCEPTEE" : "REFUSEE";
    $nomdr = $_SESSION["nomdr"];
    $message = "Bonjour  " . $nom . "  " . $prenom . ", Votre rendez-vous demande pour la date" . $date . " a ete  " . $response . "  .
	                                     Cabinet " . $nomdr . ".";

    if (mail($email, "Reponse Rendez-vous", $message)) {
        echo "Send Sucessfully";
    } else {
        echo "sorry, Failed to send email. Please try again later";
    }
    header("location:.\liste.php");
} catch (PDOException $e) {
    echo $e->getMessage();
}
$conn = null;

<?php
session_start();
$serveur = "localhost";
$dbname = "rdv";
$user = "root";
$pass = "";
$nomdr = $_SESSION["nomdr"];
$dbco = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass);
$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// récupérer tous les utilisateurs
$sql = "SELECT * FROM rendez_vous where reponse = 0 ";
try {
    $stmt = $dbco->query($sql);
    if ($stmt === false) {
        die("Erreur");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Afficher la table rendez-vous </title>
    <link rel="stylesheet" type="text/css" href="../conx/style3.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>

<body>
    <div class="testbox">
        <form>
            <div class="banner">
                <h1>Liste des rendez-vous</h1>
            </div>
            <table>
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Nom </th>
                        <th> Prenom </th>
                        <th> Age </th>
                        <th> Email </th>
                        <th> NumeroTel </th>
                        <th> Daterdv </th>
                        <th> Heure </th>
                        <th> Confirmer </th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $message = ""; ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($row['id']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['nom']);
                                //$_SESSION["nomu"] = $row['nom']; 
                                ?></td>
                            <td><?php echo htmlspecialchars($row['prenom']);
                                //$_SESSION["prenomu"] = $row['prenom']; 
                                ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']);
                                //$_SESSION["emailu"] = $row['email']; 
                                ?></td>
                            <td><?php echo htmlspecialchars($row['numero_tel']); ?></td>
                            <td><?php echo htmlspecialchars($row['daterdv']);
                                //$_SESSION["daterdv"] = $row['daterdv']; 
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['heure']); ?></td>
                            <td>
                                <div>
                                    <a href="mail.php?reponse=1&id=<?php echo $row['id'] ?>"> Accepter </a>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <!-- <button type="submit" name="accept[ $row['id'] ]">Accepter</button> !-->
                                    <!-- <button type="submit" name="refuse[ $row['id'] ]">Refuser</button> !-->
                                    <a href="mail.php?reponse=2&id=<?php echo $row['id'] ?>">
                                        Refuser </a>

                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>
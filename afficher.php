<?php
session_start();
include("connect.php");

$afficher = false;
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ( isset($_POST['password_prof'])) {
        
        $password = $_POST['password_prof'];

        
        $userQuery = mysqli_query($conn, "SELECT password FROM code_table WHERE password='$password'");
        $codeRow = mysqli_fetch_array($userQuery);

        if ($codeRow) {
            
            $correctCode = $codeRow['password'];

            if ($password == $correctCode) {
                $afficher = true;

                $presentQuery = mysqli_query($conn, "SELECT * FROM present");
                $absentQuery = mysqli_query($conn, "SELECT * FROM absent");
            } else {
                $errorMessage = 'Invalid password. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des absents et présents</title>
    <link rel="stylesheet" href="afficher.css">
</head>
<body>
    <div class="container">
        <h1>Affichage des absents et présents</h1>
        <form id="loginForm" method="post" action="afficher.php">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password_prof">
            <button type="submit" id="tester" name="afficher">test_affiche</button>
        </form>
        <div id="result"></div>
    </div>

    <?php if ($afficher): ?>
        <h2> Table present</h2>
        <table border="8" style="margin: 0 auto;">
            <tr>
                
                <th>Email</th>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Temps</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($presentQuery)): ?>
                <tr>
                    
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['firstName']; ?></td>
                    <td><?php echo $row['lastName']; ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        
        <h2> Table absent</h2>
        <table border="8" style="margin: 0 auto;">
            <tr>
              
                <th>Email</th>
                <th>Prenom</th>
                <th>nom</th>
                <th>Temps</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($absentQuery)): ?>
                <tr>
                    
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['firstName']; ?></td>
                    <td><?php echo $row['lastName']; ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
    
    <br>
    <br><a href="homepage.php">homepage</a>
    <a href="logout.php">Logout</a>
</body>
</html>
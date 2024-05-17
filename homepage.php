<?php
session_start();
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['code']) && isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $email_test = "abdotizguini3@gmail.com";
        $inputCode = $_POST['code'];

        
        $codeQuery = mysqli_query($conn, "SELECT code FROM code_table WHERE email='$email_test'");
        $codeRow = mysqli_fetch_array($codeQuery);
        $correctCode = $codeRow['code'];

        
        $userQuery = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $userRow = mysqli_fetch_array($userQuery);
        $firstName = $userRow['firstName'];
        $lastName = $userRow['lastName'];

        
        if ($inputCode == $correctCode) {
            
            $insertPresent = "INSERT INTO present (email, firstName, lastName) VALUES ('$email', '$firstName', '$lastName')";
            mysqli_query($conn, $insertPresent);
        } else {
            
            $insertAbsent = "INSERT INTO absent (email, firstName, lastName) VALUES ('$email', '$firstName', '$lastName')";
            mysqli_query($conn, $insertAbsent);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <div style="text-align:center; padding:15%;">
      <p style="font-size:50px; font-weight:bold;">
      (:Hello <?php 
       if (isset($_SESSION['email'])) {
           $email = $_SESSION['email'];
           $query = mysqli_query($conn, "SELECT users.* FROM users WHERE users.email='$email'");
           while ($row = mysqli_fetch_array($query)) {
               echo $row['firstName'] . ' ' . $row['lastName'];
           }
       }
       ?> :)
      </p>
      <form method="POST" action="">
          <input type="text" name="code" placeholder="Enter your code" required>
          <button type="submit">Envoyer Code</button>
      </form>
      <br>
      <a href="afficher.php">affiche_data</a> <br> <br>
      <a href="logout.php">Logout</a>
    </div>
</body>
</html>
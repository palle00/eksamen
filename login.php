<?php
// Starter en session
session_start();
// Tjek om brugeren er logget ind
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}
 
// Inkludere config - Så vi kan connecte til databasen
require_once "config.php";
 
// Deffinere de værdier vi skal bruge
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Få fat på data fra FORMS
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Tjek om username er tom
    if(empty(trim($_POST["username"]))){
        $username_err = "err";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Tjek om password er tom
    if(empty(trim($_POST["password"]))){
        $password_err = "err";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valider koder og navn med serveren
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM admin WHERE username = ?";

        
        // anti sql-injection - Bruger prepared statements til at 
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $username);
            

            //executer vores prepared statement
            if(mysqli_stmt_execute($stmt)){
         
                //gem brugernavnet sikkert til senere brug
                mysqli_stmt_store_result($stmt);
                
                // Tjek om brugernavnet eksister, hvis det gør så tjek password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
              
                        //binder id username og hashed_password sammen
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    //Få fat på password og tjek om det passer med password på serveren
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Hvis password er korrekt starter vi en ny session 
                            session_start();
                            
                            // Lager alt data i session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Send brugeren hend til welcome siden
                            header("location: admin.php");
                        } else{
                            // Hvis koden ikke var rigtig smid en error
                            $login_err = "Forkert brugernavn eller kode";
                        }
                    }
                } else{
                    // Hvis koden ikke var rigtig smid en error
                    $login_err = "Forkert brugernavn eller kode";
                }
            } else{
                //hvis severen fejler smid en error
                echo "Oops! Noget gik galt, prøv igen senere";
            }

           //luk for statements så der ikke kan blive fundet løse packets
            mysqli_stmt_close($stmt);
        }
    }
    
   //luk linke til severen
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function wrong()
    {
        alert('Wrong code');  
    }
    </script>
</head>
<body>

<section class="landing"> 

      <nav class="menu"> 
         <div id="nav-logo-section" class="nav-section">   
            <a class="logo-container" href="index.php">
               <img class="logo" src="img/logo.webp">
            </a>
         </div>
            <div id="nav-link-section" class="nav-section"> 
               <a href="index.php"><b>FORSIDE</b></a>
         </div>
      </nav>


    

        <div class="h1-text"><h1>Admin Login</h1></div>
       

    <div class="form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php 
        if(!empty($login_err)){
            echo '<div class="error">' . $login_err . '</div>';
           
        }     
        ?>
            <div class="form-group">
                <label for="username"><b>Brugernavn</b></label>
                <input id="username" type="text" name="username" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="password"><b>Kode</b></label>
                <input id="password" type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Login">
            </div>
        </form>
    </div>


    </section>
</body>

</script>
</html>
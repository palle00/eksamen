<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";

//Få fat på id så vi kan delete bestemte reservationer


    if(isset($_GET['id']))
    {
            $id=$_GET['id'];
            $delete = "DELETE FROM reservation WHERE ID=$id;";
            $svar = $link->query($delete);
    }



    //setup så vi kan vise reservationerne
$select ="select * from reservation ORDER BY Klok";
$query = $link->query($select);
$link -> close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
    <link rel="stylesheet" href="admin.css">

    <body>
    <section class="landing"> 
    <nav class="menu"> 
         
            <div id="nav-link-section" class="nav-section"> 
               <a href="index.php"><b>FORSIDE</b></a>   
               <a href="logout.php"><b>LOGUD</b></a>
         </div>
      </nav>

      <div> 
   
      </div>
      <div class='card-area'> 
<?php

//loop over alle reservationerne og display dem i en table
    $num=mysqli_num_rows($query);
    if($num>0)
    {
        while($result=mysqli_fetch_assoc($query))
        {
            echo "
        <div class='table-card'> 
            <div class='table-num'>
                <div class='table'><a>Bord " .$result["Bord"]."</a></div>
                <div class='fjern'><a OnClick=\"return confirm('Er du sikker på du vil slette reservationen');\" href='admin.php?id=".$result["ID"]."'>X</a></div>
            </div>
            <div class='table-info'>

            
        
                <p>Navn: <b>".$result["Navn"]."</b></p>
                <p>Kl: <b>".$result["Klok"]."</b></p>
                <p>Tlf: <b>".$result["Tlf"]."</b></p>
                <p>Antal: <b>".$result["Antal"]."</b></p>
                ";

                if(!$result["Laks"] == 0)
                echo "
                <p>Laks: <b>".$result["Laks"]."</b></p>
                ";

                if(!$result["Pasta_bolognese"] == 0)
                echo "
                <p>Pasta Bolognese: <b>".$result["Pasta_bolognese"]."</b></p>
                ";

                if(!$result["Steget_flæsk"] == 0)
                echo "
                <p>Steget Flæsk: <b>".$result["Steget_flæsk"]."</b></p>
                ";

                if(!$result["Bøf_med_løg"] == 0)
                echo "
                <p>Bøf med løg <b>".$result["Bøf_med_løg"]."</b></p>
                ";

                if(!$result["Muffin"] == 0)
                echo "
                <p>Muffin: <b>".$result["Muffin"]."</b></p>
                ";

                if(!$result["Vanilje_is"] == 0)
                echo "
                <p>Vanilje is: <b>".$result["Vanilje_is"]."</b></p>
                ";

                if(!strval($result["Allergi"]) == 0)
                echo "
                <p>Allergi: <b>".$result["Allergi"]."</b></p>
                ";
                
    echo "
            </div>
    
        </div>
    
                ";


                
        } 
    }
?>
</div>


    

</section>
</body>
<script src="admin.js"></script>
</html>
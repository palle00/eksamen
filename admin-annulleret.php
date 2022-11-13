<?php
// Initialize the session
session_start();
 
// Tjek om brugeren er logget ind, hvis ikke redirect dem til login siden
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//connect til databasen
require_once "config.php";

//Få fat på id så vi kan delete bestemte reservationer

if(isset($_GET['drop']))
{
    $delete = "DELETE FROM `reject` WHERE ID > 0";
    $svar = $link->query($delete);
    header("location: admin-annulleret.php");
}

    //setup så vi kan vise reservationerne
$select ="select * from reject ORDER BY Bord";
$query = $link->query($select);
$link -> close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="admin.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />     

    <body>
    <section class="all">

<div class="p-menu">
        <div class="p-menu-item" onclick="location.href='admin.php';" style="cursor:pointer;" style="cursor:pointer;">
        <i class="fa fa-list fa-2x"> </i>
            <a class="p-menu-text">Reservationer</a>
        </div>
        <div class="p-menu-item" onclick="location.href='admin-done.php';" style="cursor:pointer;">
            <i class="fa fa-check fa-2x"> </i>
            <a class="p-menu-text">Gennemført</a>
        </div>
        <div class="p-menu-item" onclick="location.href='admin-annulleret.php';" style="cursor:pointer;" id="active">
            <i class="fa fa-ban fa-2x"> </i>
            <a class="p-menu-text">Annulleret</a>
        </div>

        
        <script> 
                   
    function gotoUrl(){
                        swal({
                        title: "Slet alle annulleret reservationer?",
                        text: "Når de er slettet kan de ikke komme tilbage",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            
                            
                            location.href = "admin-annulleret.php?drop=";
                        } else {
                            
                        }
                        });
                    }
             </script>
           
                    <?php 

                        if(htmlspecialchars($_SESSION["username"]) == "super")
                     
                            echo"
                                <div class='p-menu-item' onClick='gotoUrl()' style='cursor:pointer;'>
                                    <i class='fa fa-trash fa-2x'> </i>
                                    <a class='p-menu-text'>Fjern alt</a>
                                </div>
                            ";
                    ?>
  


        <div class="p-menu-item" id="log" onclick="location.href='logout.php';" style="cursor:pointer;">
            <i class="fa fa-sign-out fa-2x"> </i>
            <a class="p-menu-text">Log Ud</a>
        </div>

</div>

      <div class='card-area'> 
<?php

//loop over alle reservationerne og display dem i en table, hvis de ikke er tomme
    $num=mysqli_num_rows($query);
    if($num>0)
    {
        while($result=mysqli_fetch_assoc($query))
        {
            echo "
        <div class='table-card'> 
            <div class='table-num' id='annulleret'>
                <div class='table'><a>Bord " .$result["Bord"]."</a></div>
            </div>
            <div class='table-info'>

                <p>Navn: <b>".$result["Navn"]."</b></p>
                <p>Antal: <b>".$result["Antal"]."</b></p>
                <p>Tlf: <b>".$result["Tlf"]."</b></p>
                ";
                
    echo "
            </div>
    
        </div>
    
                ";


                
        } 
    }
?>
</div>


    <div class="m-menu">
                <div class="m-menu-item" onclick="location.href='admin.php';" style="cursor:pointer;" >
                <i class="fa fa-list fa-2x"> </i>
                    <a class="m-menu-text">Reservationer</a>
                </div>
                <div class="m-menu-item" onclick="location.href='admin-done.php';" style="cursor:pointer;">
                    <i class="fa fa-check fa-2x"> </i>
                    <a class="p-menu-text">Gennemført</a>
                </div>
                <div class="m-menu-item" onclick="location.href='admin-annulleret.php';" style="cursor:pointer;" id="active">
                    <i class="fa fa-ban fa-2x"> </i>
                    <a class="m-menu-text">Annulleret</a>
                </div>

                    <?php 

                        if(htmlspecialchars($_SESSION["username"]) == "super")
                        
                         echo"
                                <div class='m-menu-item' onClick='gotoUrl()' style='cursor:pointer;'>
                                    <i class='fa fa-trash fa-2x'> </i>
                                    <a class='m-menu-text'>Fjern alt</a>
                                </div>
                            ";
                    ?>


             
                <div class="m-menu-item" id="log" onclick="location.href='logout.php';" style="cursor:pointer;">
                    <i class="fa fa-sign-out fa-2x"> </i>
                    <a class="m-menu-text">Log Ud</a>
                </div>
    </div>


</section>
</body>
</html>
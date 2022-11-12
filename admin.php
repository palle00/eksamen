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
    $delete = "DELETE FROM `reservation` WHERE ID > 0";
    $svar = $link->query($delete);
    header("location: admin.php");
}

if(isset($_GET['gennemført']))
{
$id=$_GET['id'];
$navn=$_GET['navn'];
$antal=$_GET['antal'];
$bord=$_GET['bord'];
$tlf=$_GET['tlf'];

$sql = "INSERT INTO `done`(`ID`, `Navn`, `Antal`, `Bord`, `Tlf`) 
VALUES (?, ?, ?, ?, ?)";

$stmt = $link->prepare($sql);
$stmt->bind_param("isiii", $id, $navn, $antal, $bord, $tlf);
$stmt->execute();

$delete = "DELETE FROM reservation WHERE ID=$id;";
$svar = $link->query($delete);



header("location: admin.php");
}



    if(isset($_GET['fjern']))
    {
    $id=$_GET['id'];
    $navn=$_GET['navn'];
    $antal=$_GET['antal'];
    $bord=$_GET['bord'];
    $tlf=$_GET['tlf'];

    $sql = "INSERT INTO `reject`(`ID`, `Navn`, `Antal`, `Bord`, `Tlf`) 
    VALUES (?, ?, ?, ?, ?)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("isiii", $id, $navn, $antal, $bord, $tlf);
    $stmt->execute();

    $delete = "DELETE FROM reservation WHERE ID=$id;";
    $svar = $link->query($delete);

    header("location: admin.php");
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
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="admin.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
    
<body>

    <section class="all">

        <div class="menu">
                <div class="menu-item" onclick="location.href='admin.php';" style="cursor:pointer;"  id="active">
                <i class="fa fa-list fa-2x"> </i>
                    <a class="menu-text">Reservationer</a>
                </div>
                <div class="menu-item" onclick="location.href='admin-done.php';" style="cursor:pointer;">
                    <i class="fa fa-check fa-2x"> </i>
                    <a class="menu-text">Gennemført</a>
                </div>
                <div class="menu-item" onclick="location.href='admin-annulleret.php';" style="cursor:pointer;">
                    <i class="fa fa-ban fa-2x"> </i>
                    <a class="menu-text">Annulleret</a>
                </div>



            <script> 
                    function gotoUrl(){
                    let text = 'Slet alle reservationer?'

                    if(confirm(text) == true){
                        location.href = "admin.php?drop=";
                    }
                }
             </script>

                    <?php 

                        if(htmlspecialchars($_SESSION["username"]) == "super")
                        
                         echo"
                                <div class='menu-item' onClick='gotoUrl()' style='cursor:pointer;'>
                                    <i class='fa fa-trash fa-2x'> </i>
                                    <a class='menu-text'>Fjern alt</a>
                                </div>
                            ";
                    ?>


             
                <div class="menu-item" id="log" onclick="location.href='logout.php';" style="cursor:pointer;">
                    <i class="fa fa-sign-out fa-2x"> </i>
                    <a class="menu-text">Log Ud</a>
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
                <div class='table-num'>
                    <div class='table'><a>Bord " .$result["Bord"]."</a></div>
                    <div><a OnClick=\"return confirm('Tilføj reservation til gennemført?');\" href='admin.php?id={$result['ID']}&navn={$result['Navn']}&antal={$result['Antal']}&bord={$result['Bord']}&tlf={$result['Tlf']}&gennemført='''> <i class='fa fa-check fa-lg'> </i></a></div>
                    <div><a OnClick=\"return confirm('Tilføj reservation til annulleret?');\" href='admin.php?id={$result['ID']}&navn={$result['Navn']}&antal={$result['Antal']}&bord={$result['Bord']}&tlf={$result['Tlf']}&fjern='''> <i class='fa fa-ban fa-lg'> </i></a></div>
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
</html>
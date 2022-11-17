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

//når der klikkes på fjern alt skal alt fra reservation fjernes
if(isset($_GET['drop']))
{
    $delete = "DELETE FROM `reservation` WHERE ID > 0";
    $svar = $link->query($delete);
    header("location: admin.php");
}

//når der klikkes på delete skal den bestemte reservation fjernes
if(isset($_GET['delete']))
{
    $id=htmlspecialchars($_GET['id']);
    $delete = "DELETE FROM `reservation` WHERE ID = $id";
    $svar = $link->query($delete);
    header("location: admin.php");
}

//når der klikkes på gennemført skal reservationen fjernes fra reservation table 
//og flyttes til done table
if(isset($_GET['gennemført']))
{
$id=htmlspecialchars($_GET['id']);
$navn=htmlspecialchars($_GET['navn']);
$antal=htmlspecialchars($_GET['antal']);
$bord=htmlspecialchars($_GET['bord']);
$tlf=htmlspecialchars($_GET['tlf']);

$sql = "INSERT INTO `done`(`ID`, `Navn`, `Antal`, `Bord`, `Tlf`) 
VALUES (?, ?, ?, ?, ?)";

$stmt = $link->prepare($sql);
$stmt->bind_param("isiii", $id, $navn, $antal, $bord, $tlf);
$stmt->execute();

$delete = "DELETE FROM reservation WHERE ID=$id;";
$svar = $link->query($delete);



header("location: admin.php");
}

//når der klikkes på annuller skal reservationen fjernes fra reservation table 
//og flyttes til annulleret table

    if(isset($_GET['fjern']))
    {
        $id=htmlspecialchars($_GET['id']);
        $navn=htmlspecialchars($_GET['navn']);
        $antal=htmlspecialchars($_GET['antal']);
        $bord=htmlspecialchars($_GET['bord']);
        $tlf=htmlspecialchars($_GET['tlf']);

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
    
<body>

    <section class="all">

        <div class="p-menu">
                <div class="p-menu-item" onclick="location.href='admin.php';" style="cursor:pointer;"  id="active">
                <i class="fa fa-list fa-2x"> </i>
                    <a class="p-menu-text">Reservationer</a>
                </div>
                <div class="p-menu-item" onclick="location.href='admin-done.php';" style="cursor:pointer;">
                    <i class="fa fa-check fa-2x"> </i>
                    <a class="p-menu-text">Gennemført</a>
                </div>
                <div class="p-menu-item" onclick="location.href='admin-annulleret.php';" style="cursor:pointer;">
                    <i class="fa fa-ban fa-2x"> </i>
                    <a class="p-menu-text">Annulleret</a>
                </div>

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
<script>
        function gotoUrl(){
    swal({
    title: "Slet alle reservationer?",
    text: "Når de er slettet kan de ikke komme tilbage",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {  
        location.href = "admin.php?drop=";
    } else {
        
    }
    });
}
   
</script>
        
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
                    <div class='table'><a>Bord ".$result["Bord"]."</a></div>
                    <div><a OnClick=\"return confirm('Tilføj reservation til gennemført?');\" href='admin.php?id={$result['ID']}&navn={$result['Navn']}&antal={$result['Antal']}&bord={$result['Bord']}&tlf={$result['Tlf']}&gennemført='''> <i class='fa fa-check fa-lg'> </i></a></div>
                    <div><a OnClick=\"return confirm('Tilføj reservation til annulleret?');\" href='admin.php?id={$result['ID']}&navn={$result['Navn']}&antal={$result['Antal']}&bord={$result['Bord']}&tlf={$result['Tlf']}&fjern='''> <i class='fa fa-ban fa-lg'> </i></a></div>
                   ";
                   if(htmlspecialchars($_SESSION["username"]) == "super")
                   echo "
                   <div><a OnClick=\"return confirm('Slet reservation?');\" href='admin.php?id={$result['ID']}&delete='''> <i class='fa fa-trash fa-lg'> </i></a></div>
                   ";
                   echo "
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
                    <p>Stegt Flæsk: <b>".$result["Steget_flæsk"]."</b></p>
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

    <div class="m-menu">
                <div class="m-menu-item" onclick="location.href='admin.php';" style="cursor:pointer;"  id="active">
                <i class="fa fa-list fa-2x"> </i>
                    <a class="m-menu-text">Reservationer</a>
                </div>
                <div class="m-menu-item" onclick="location.href='admin-done.php';" style="cursor:pointer;">
                    <i class="fa fa-check fa-2x"> </i>
                    <a class="p-menu-text">Gennemført</a>
                </div>
                <div class="m-menu-item" onclick="location.href='admin-annulleret.php';" style="cursor:pointer;">
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

                
        </div>
        

    </section>
    </body>
</html>
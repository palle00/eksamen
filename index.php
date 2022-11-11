<?php
//Tjekker om der er data fra vores post

if (!empty($_POST['Navn'])) 
{  
  include_once 'config.php'; 
   $result = $link->query("SELECT * FROM `reservation` 
   WHERE Klok = '".$_POST['Klok']."' AND Bord = '".$_POST['Bord']."'");
   
   if (mysqli_num_rows($result)==0)
   { 
    $navn = $_POST['Navn'];
    $tlf = $_POST['Tlf'];
    $klok = $_POST['Klok'];
    $bord = $_POST['Bord'];
    $laks = $_POST['Laks'];
    $pastab = $_POST['PB'];
    $stegetf = $_POST['SF'];
    $Bøfml = $_POST['BF'];
    $muffin = $_POST['Muffin'];
    $vanilje = $_POST['VS'];
    $allergi = $_POST['Allergi'];
    $antal = $_POST['Antal'];
    
   }
   else
   {
      //hvis bordet er booket på samme tidspunkt - lav en alert der informere brugeren 
   echo '<script type="text/javascript">alert("Reservationen ved bord: '.$_POST['Bord'].' Kl: '.$_POST['Klok'].' Er reseveret");
   window.location.href="index.php";
   </script>';
   }
//Prepared statement for at forhindre sql injection, samt sende data til databasen
    $sql = "INSERT INTO `reservation`(`Navn`, `Tlf`, `Klok`, `Bord`, `Laks`, `Pasta_bolognese`, `Steget_flæsk`, `Bøf_med_løg`, `Muffin`, `Vanilje_is`, `Allergi`, `Antal`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("sisiiiiiiisi", $navn, $tlf, $klok, $bord, $laks, $pastab, $stegetf
    ,$Bøfml, $muffin, $vanilje, $allergi, $antal);
    $stmt->execute();


    echo '<script type="text/javascript">alert("Reservationen ved bord: '.$_POST['Bord'].' Kl: '.$_POST['Klok'].' er nu reseveret");
    window.location.href="index.php";
    </script>';

    //reload og luk forbindelsen
      $link -> close();
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="index.css">
    <title>Trendsetter</title>
   
</head>
<body>
   <section class="landing"> 

      <nav class="nav"> 
         <div id="nav-logo-section" class="nav-section">   
            <a class="logo-container" alt="Link tilbage til forsidej" href="index.php">
               <img class="logo" src="img/logo.webp" alt="Website Logo">
            </a>
         </div>
            <div id="nav-link-section" class="nav-section"> 
               <a href="#menu" alt="Link til menuen"><b>MENU</b></a>   
               <a href="#f" alt="Link til bestilling"><b>BESTIL</b></a>
               <a href="login.php" alt="Link til admin login"><b>LOGIN</b></a>
         </div>
         
        
         
         <a href="https://www.facebook.com/" alt="Link til facebook"> <img alt="Facebook link" id="social-icon" class="facebook" src="img/Facebook.webp"></a>
     
         <a href="https://twitter.com/" alt="Link til twitter"><img id="social-icon" alt="Twitter link" class="twitter" src="img/Twitter.webp"></a>
    
         <a href="https://instagram.com/" alt="Link til instagram"><img id="social-icon" alt="Instagram link" class="instagram" src="img/Instagram.webp"></a>
        
   
   

      </nav>

      <div class="tag">
         <h1>Restaurant Trendsetter</h1>
         <h2>Nemt og hurtigt</h2>    
      </div>
      <div class="cta-div"><a class="cta" href="#f" alt="Link til bestille bord"><b>Bestil bord</b></a></div>
           
      <div class="V"><i class="fas fa-caret-down fa-5x" id="V"></i></div>
   
   </section>


   <section class="koncept">

      <div class=koncept-content>
      <div class="spacer"> </div>
         <h2> Vores koncept</h2>
         <p> Ved Restaurant trendsetter bestilles maden og bordet på forhånd, der kan kun bookes bord på selvsamme dag,
         det er nemt og hurtigt. I vores køkken står vores uddannede og erfarne
          kokke og personale klar til at give jer en uforpligtende oplevelse. 
          Du kan klare betalingen online når du bestiller og dermed kan i gå som det passer jer.</p>

          <div class="spacer"> </div>
      

   </section>

   <section id="menu" class="menu">
   <h2 id="menu-text">Menukort</h2>
   <div class="outerwrapper">
         <div class="foodmenu">
               <div  class="menuitem-container">
                  <div class="menuitem-img">
                     <img class="img" src="img/for.webp" alt="Billede af eksemple forret">    
                  </div>
                  <div class="menuitem-text">
                     <h3 class="text" id="menuer">Forretter</h3>
                        <h4 class="text" id="ret">Laks - 50kr</h4>
                        <p class="text" id="ret-beskrivelse"> <em>Laks med asparges, nye kartofler og citron sauce</em></p>
                     
                        <h4 class="text" id="ret">Pasta bolognese - 50kr</h4>
                        <p class="text" id="ret-beskrivelse"> <em>Frisk pasta med oksekød, tomatsovs, løg og champignon. Serveres med parmesanost</em></p>
                  </div>      
               </div>

               
               <div class="menuitem-container">
                  <div class="menuitem-text">
                    <h3 class="text" id="menuer">Hovedretter</h3>
                        <h4 class="text" id="ret">Stegt flæsk - 65kr</h4>
                        <p class="text" id="ret-beskrivelse"> <em>Klassisk stegt flæsk med persillesovs og nye danske kartofler</em></p>
                     
                        <h4 class="text" id="ret">Bøf med løge - 65kr</h4>
                        <p class="text" id="ret-beskrivelse"> <em>Hakkebøffer af oksekød stegt i løg. Serveres med pommes og bearnaisesauce</em></p>
                  </div>    
                  <div class="menuitem-img">
                     <img class="img" src="img/hov.webp" alt="Billede af eksemple hovedret">    
                  </div>  
               </div>

               <div class="menuitem-container">
                  <div class="menuitem-img">
                     <img class="img" src="img/des.webp" alt="Billede af eksemple dessert">    
                  </div>
                  <div class="menuitem-text">
                     <h3 class="text" id="menuer">Desserter</h3>
                     <h4 class="text" id="ret">Muffin - 20kr</h4>
                     <p class="text" id="ret-beskrivelse"> <em>Hjemmelavet chokolade eller vanilje muffins, serveres med kaffe.</em></p>
                     
                     <h4 class="text" id="ret">Vanilje is - 25kr</h4>
                     <p class="text" id="ret-beskrivelse"> <em>Hjemmelavet vanilje is. Serveres med frugt og chokoladesauce</em></p>
                  </div>      
               </div>
               </div>
         </div>
         <div class="spacer"> </div>
      </div>
   </section>

     
   


    <div class="spacer"> </div>
   
   <section class="form"> 
    <h2 class="text" id="head">Book bord</h2>
     
 
      <div class="progress"> 
         <div class="step-1" id="active">1 </div>
         <div class="line-2"> </div>
         <div class="step-2">2 </div>
         <div class="line-3"> </div>
         <div class="step-3">3</div>
         
      </div>
      
      
    <div class="form-box">
   
      <form id="f" action = "<?php $_PHP_SELF ?>" method = "POST">
    

      
      <p>Felter markeret med * skal udfyldes</p>   
      
      <div class="form-group" id="info">
      <label>
      <span>Navn*</span>
          <input id="navn" type = "text" require = "true" name = "Navn" placeholder="John" required/>
    </label>

    <label>
         <span>Tlf</span>
          <input  id="tlf" type = "tel" require = "true" name = "Tlf"  minlength="8" maxlength="8"
             placeholder="12345678" pattern="[0-9]{8}"/>
            </label>
      </div>



         <div class="form-group" id="info">
         
        
         <label>
               <span>Antal personer*</span>
               <input  id="antal"  type = "tel" name = "Antal" required/>
              </label>
            
       <label>
               <span>Bord Nr*</span>
               <select id="bord" type = "int" name = "Bord" value="true" required>
                     <option value="" disabled selected></option>
                     <option value="1">1</option>
                     <option value="2">2</option>
                     <option value="3">3</option>
                     <option value="4">4</option>   
                     <option value="5">5</option>   
                     <option value="6">6</option>   
                     <option value="7">7</option>   
               </select>
            </label>

          
             <label>
               <span>Kl*</span>
               <input  id="klok"  type = "time" name = "Klok" min="12:00" max="22:00" required/>
              </label>
           
        </div> 
        <div class="menu-select" id="food"> 
          <h3>Forret</h3> 
         </div>
        <div class="form-group" id="food">
              <label>
                  <span>Laks</span>
                  <input  id="Laks"  type = "number" name = "Laks" min="0" max="6" value="0" required/>
               </label>
               <label>
                  <span>Pasta bolognese</span>
                  <input  id="PB"  type = "number" name = "PB" min="0" max="6" value="0" required/>
              </label>
        </div> 


      

        <div class="menu-select" id="food"> 
         <h3>Hovedret</h3> 
      
        </div>
      
        <div class="form-group" id="food">
           
           <label>
               <span>Stegt Flæsk</span>
               <input  id="SF"  type = "number" name = "SF" min="0" max="6" value="0" required/>
            </label>
            <label>
               <span>Bøf med Løg</span>
               <input  id="BF"  type = "number" name = "BF" min="0" max="6" value="0" required/>
           </label>
     </div> 

     <div class="menu-select" id="food"> 
      <h3>Dessert</h3> 
     </div>
     <div class="form-group" id="food">
           
           <label>
               <span>Muffin </span> 
               <input  id="Muffin"  type = "number" name = "Muffin" min="0" max="6" value="0" required/>
            </label>
            <label>
               <span>Vanilje Is</span>
               <input  id="VS"  type = "number" name = "VS" min="0" max="6" value="0" required/>
           </label>
     </div> 
        


     <div class="form-group" id="allergi">
           
           <label>
               <span>Har du nogle allergier? </span> 
               <textarea id="Allergi" name="Allergi" rows="6" cols="78" maxlength="255"> </textarea>
            </label>
           
     </div>
     
            <div class="btns"> 
            <a class="btnb" id="Btnb">Tilbage</a>
            <a class="btnn" id="Btnn">Næste</a>
            <input class="btn" type = "submit"  value="Book bord"/>
   </div>
      </form>
   </div>
  </section>




   <section class="footer">

      <footer>
         <div class="footer-area">

            <div class="footer-content om"> 
                  <h5 class="footer-title">Om</h5>
                  <p class="footer-text">En rigtig god restaurant  hvor du kan spise noget lækkert.</p>
                  <p class="footer-text"></p>
                  <p class="footer-text"></p>
            </div>

            <div class="footer-content kontakt"> 
                  <h5 class="footer-title">Kontakt</h5>

                  <p class="footer-text"><i class="fas fa-map-marker fa-xs"> </i> Falskadresse 123, 7400 herning</p>
                  <p class="footer-text"><i class="fas fa-phone fa-xs"> </i> +45 55555555</p>
                  <p class="footer-text"><i class="fas fa-envelope fa-xs"> </i> trendsetterfalsk@mail.dk</p>
            </div>
            <div class="footer-content åbningstid"> 

                 <h5 class="footer-title">Åbningstider</h5>
                  <p class="footer-text"><i class="fas fa-clock-o fa-xs"></i> 12.00 - 22.00 alle dage</p>
                  <p class="footer-text"></p>
                  <p class="footer-text"></p>
               </div>

         </div>
      </footer>

   </section>

   </body>
   <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
   <script src="index.js"></script>
</html>
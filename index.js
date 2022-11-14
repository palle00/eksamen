
//Setup starts værdier
$(document).ready(function(){
  var index = 1;
  var ind1 = 1;

  //når knappen bliver trykket på tilføjer vi 1 til index og kalder change()
  $( "#Btnn" ).click(function() {
    index++;
   
   change();
});

//når knappen bliver trykket på fjerner vi 1 til index og kalder change()
$( "#Btnb" ).click(function() {
  index--;
 
 change();
});


function change()
{


  //switch case der tjekker index værdi og aktiverer/fjerner 
  //de html elementer der ikke skal være aktiv
  switch(index)
  {
    case 1:
      ind1 = index+1;
      $('[id="food"]').css("display", "flex");
      $('[id="allergi"]').css("display", "none");
      $(".step-"+index).attr('id', 'active');      
      $(".line-"+index).attr('id', 'active');
      $('[class="btnb"]').css("display", "none");

      $(".step-"+ind1).attr('id', 'inactive');      
      $(".line-"+ind1).attr('id', 'inactive');
    break;

    case 2:
      ind1 = index+1;
      $('[id="food"]').css("display", "none");
      $('[id="allergi"]').css("display", "flex");
      $(".step-"+index).attr('id', 'active');      
      $(".line-"+index).attr('id', 'active');
      $('[class="btnb"]').css("display", "flex");
      $('[class="btn"]').css("display", "none");
      $('[class="btnn"]').css("display", "flex");
      $('[id="info"]').css("display", "none");
    
      $(".step-"+ind1).attr('id', 'inactive');      
      $(".line-"+ind1).attr('id', 'inactive');
    break;

    case 3:    
      $('[id="info"]').css("display", "flex");
      $('[id="allergi"]').css("display", "none");
      $('[class="btn"]').css("display", "flex");
      $('[class="btnn"]').css("display", "none");

      $(".step-"+index).attr('id', 'active');
      $(".line-"+index).attr('id', 'active');
    break;

  }

}


//Interval der bliver kaldt en gang hver 2,5 sekunder (2500 millisekunder) 

setInterval(function() 
{

 
  //animation der får pilen på landingpage til at hoppe op og ned
  $("#V").animate({
      'marginBottom': '5px'});
         
          $("#V").animate({
            'marginBottom': '-15px'});

            
          $("#V").animate({
            'marginBottom': '-10px'});
          
}, 2500);


});
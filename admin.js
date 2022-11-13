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
   

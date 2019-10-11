window.mobilecheck = function() {
    var check = false;
    (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};

function showAutocomplete() {

    if (window.mobilecheck()) {
        $(".mobile-pop-pup").show()

    } else {
        $(".autocomplete-panel").css({
            opacity: 1
        });
    }
}


function closePopUp() {
    $(".mobile-pop-pup").hide()
}

function hideAutocomplete() {
    $(".autocomplete-panel").css({
        opacity: 0
    });
}


if ($("#input-address").length > 0) {
    google.maps.event.addDomListener(window, 'load', initialize('input-address'));
}

if ($("#input-address-create").length > 0) {
    google.maps.event.addDomListener(window, 'load', initializeCreate('input-address-create'));
}
if ($("#input-address-create-neighborhood").length > 0) {
    google.maps.event.addDomListener(window, 'load', initializeCreate('input-address-create-neighborhood'));
}

if ($("#input-address-navbar").length > 0) {
    google.maps.event.addDomListener(window, 'load', initializeNavbar('input-address-navbar'));
}



if ($("#input-address-mobile").length > 0) {
    google.maps.event.addDomListener(window, 'load', initialize('input-address-mobile'));
}

var placeComplete=null;
function initializeCreate(id) {
    var input = document.getElementById(id);
    var options = {
        componentRestrictions: {
            country: countrySearch
        }
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function() {
        
        $("#input-address-create-neighborhood").val("")
                $("#country").val("")
                $("#city").val("")

                $("#street_name").val("0")
                $("#street_number").val("0")

        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        var nameNeighboorHood = "";
        var isNeighboorHood = false;
        placeComplete=place;
        
        console.log(place);
                    $("#latitude").val(place.geometry.location.lat());
                    $("#longitude").val(place.geometry.location.lng());
        var propertiesSearch=[];
       for (var i = 0; i < place.address_components.length; i++) {
            var addressComponents = place.address_components[i].types;
            for (var a = 0; a < addressComponents.length; a++) {
                
                propertiesSearch[addressComponents[a]]=place.address_components[i].long_name;
                /*if(addressComponents[a]=="street_number"){
                    $("#street_number").val(place.address_components[i].long_name)
                    
                }
                
                
                if(addressComponents[a]=="neighborhood"){
                                       console.log("addd",place.address_components[i].long_name);

                    $("#input-address-create-neighborhood").val(place.address_components[i].long_name)
                }else{
                    if(addressComponents[a]=="sublocality_level_1"){
                    $("#input-address-create-neighborhood").val(place.address_components[i].long_name)
                    if(addressComponents[a]=="sublocality"){
                    $("#input-address-create-neighborhood").val(place.address_components[i].long_name)
                    }
                }
                
                 if(addressComponents[a]=="sublocality_level_1"){
                    $("#input-address-create-neighborhood").val(place.address_components[i].long_name)
                    if(addressComponents[a]=="sublocality"){
                    $("#input-address-create-neighborhood").val(place.address_components[i].long_name)
                    }
                }
                
                 if(addressComponents[a]=="locality"){
                    $("#input-address-create-neighborhood").val(place.address_components[i].long_name)
                   
                }
                }
                
                
                 
                if(addressComponents[a]=="administrative_area_level_1"){
                    $("#city").val(place.address_components[i].long_name)
                }
                
                  
                if(addressComponents[a]=="route"){
                    $("#street_name").val(place.address_components[i].long_name)
                }
                
                
                */
            }
        }
        
        
        for(searchp in propertiesSearch){
           console.log(searchp,propertiesSearch[searchp]);
           
           if(searchp=="route"){
                $("#street_name").val(propertiesSearch[searchp])
           }
            if(searchp=="street_name"){
                $("#street_name").val(propertiesSearch[searchp])
           }
           
            if(searchp=="street_number"){
                $("#street_number").val(propertiesSearch[searchp])
           }
           
           if(searchp=="neighborhood"){
                $("#input-address-create-neighborhood").val(propertiesSearch[searchp])
           }
            if(searchp=="political"){
                $("#country").val(propertiesSearch[searchp])
           }
           
            if(searchp=="locality"){
                $("#city").val(propertiesSearch[searchp])
           }
           
             if(searchp=="sublocality"){
                $("#city").val(propertiesSearch[searchp])
           }
            if(searchp=="sublocality_level_1"){
                $("#city").val(propertiesSearch[searchp])
           }
           
           
           if(searchp=="country"){
                $("#city").val(propertiesSearch[searchp])
           }
           
             if(searchp=="administrative_area_level_3"){
                $("#city").val(propertiesSearch[searchp])
           }
              if(searchp=="administrative_area_level_2"){
                $("#city").val(propertiesSearch[searchp])
           }
               if(searchp=="administrative_area_level_1"){
                $("#city").val(propertiesSearch[searchp])
           }
           
           if($("#input-address-create-neighborhood").val().length==0){
               
                 
            if($("#city").val().lenght==0){
                    $("#input-address-create-neighborhood").val($("#street_name").val())

            }else{
                $("#input-address-create-neighborhood").val($("#city").val())

            }
               
           }
           
           
        }
        
        console.log("resultddddd",propertiesSearch);
        
        /*if($("#neighborhood").val().length==0){
            
            if($("#city").val().lenght==0){
                            $("#neighborhood").val($("#street_name").val())

            }else{
                            $("#neighborhood").val($("#city").val())

            }
        }*/
        
    });
}



function initializeNavbar(id) {
    var input = document.getElementById(id);
    var options = {
        componentRestrictions: {
            country: countrySearch
        }
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        var nameNeighboorHood = "";
        var isNeighboorHood = false;
        for (var i = 0; i < place.address_components.length; i++) {
            var addressComponents = place.address_components[i].types;
            for (var a = 0; a < addressComponents.length; a++) {

                if (addressComponents[a] == "sublocality_level_1" ||
                    addressComponents[a] == "sublocality") {
                    if ((addressComponents[a] != "administrative_area_level_2") || (addressComponents[a] != "country")) {
                        isNeighboorHood = true;
                        nameNeighboorHood = place.address_components[i].short_name;
                    }

                }
            }
        }


        window.location="/search?sort=all&locationId="+lat+"|"+lng+"&nameN="+nameNeighboorHood   

        // place variable will have all the information you are looking for.
        $('#lat').val(place.geometry['location'].lat());
        $('#long').val(place.geometry['location'].lng());
    });
}

function initialize(id) {
    var input = document.getElementById(id);
    var options = {
        componentRestrictions: {
            country: countrySearch
        }
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        var nameNeighboorHood = "";
        var isNeighboorHood = false;
        for (var i = 0; i < place.address_components.length; i++) {
            var addressComponents = place.address_components[i].types;
            for (var a = 0; a < addressComponents.length; a++) {

                if (addressComponents[a] == "sublocality_level_1" ||
                    addressComponents[a] == "sublocality") {
                    if ((addressComponents[a] != "administrative_area_level_2") || (addressComponents[a] != "country")) {
                        isNeighboorHood = true;
                        nameNeighboorHood = place.address_components[i].short_name;
                    }

                }
            }
        }


        if (isNeighboorHood) {
        window.location="/search?sort=all&locationId="+lat+"|"+lng+"&nameN="+nameNeighboorHood   
        }
        // place variable will have all the information you are looking for.
        $('#lat').val(place.geometry['location'].lat());
        $('#long').val(place.geometry['location'].lng());
    });
}

function activeButton() {
    $(".inner-container-images-neighborhood button")
        .addClass("selected-button")
        .removeClass("no-selected-button")

}

function changeBackground(number) {
    for (var i = 1; i < 13; i++) {
        if (number == i) {
            $(".button_" + i)
                .addClass("selected-button")
                .removeClass("no-selected-button")
        } else {
            $(".button_" + i)
                .addClass("no-selected-button")
                .removeClass("selected-button")

        }
    }

    $(".image-effect")
        .animate({
            opacity: 0.8
        }, 'fast', function() {
            $(this)
                .css({
                    'background-image': "url(img/" + number + ".jpg)"
                })
                .animate({
                    opacity: 1
                });
        });
}

function scrollToAnchor(aid) {
    var aTag = $("a[name='" + aid + "']");
    $('html,body').animate({
        scrollTop: aTag.offset().top
    }, 'slow');
}

function closePopUpFilters() {
    $(".filters-containers").hide();
}

function showFilter() {
    $(".filters-containers").show();
}


function loginSocial() {
    $(".modalSocialLogin").modal("show")
}

function setLocation() {


    $("#locationId").val($("#location").val());
}

function searchFilter() {
    var radio = $("input[name='operation']:checked").val();
    var propertyType = $("input[name='property-type']:checked").val();
    setLocation();
    
     var favorite = [];
            $.each($("input[name='feature']:checked"), function(){            
                favorite.push($(this).val());
            });
            $("#features").val(favorite.join(","));
    $("#form-search-filter").submit();
}


function addFilter(name){
   $("#sort").val(name)
       $("#form-search-filter").submit();

}

function setNumberRooms(number) {
    $("#rooms").val(number)
    $("#form-search-filter").submit();
}

changeBackground(3);
activeButton();
setLocation();
$(document).ready(function() {

    if ($(".js-example-basic-single").length > 0) {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-single').on('select2:select', function(e) {
            setLocation();
            $("#form-search-filter").submit();
        });
    }


});


function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}


function showPosition(position) {
    
    window.location="/search?sort=all&locationId="+position.coords.latitude+"|"+position.coords.longitude    
}
var isShowingForm=false;

function showFormLocation(){
    if(isShowingForm){
        isShowingForm=false;
        $(".complete-information-direction").hide();
        $("#complete-direction").show()
    }else{
        isShowingForm=true;
        placeComplete=null;
        $(".complete-information-direction").show();
        $("#complete-direction").hide()


    }
}  

function nextStepAddress(){
    if(placeComplete==null){
        $("#error-location-message").show();
    }else{
        $(".step-one").hide();
        $(".step-two").show()

    }
}

function nextStepAddressManually(){


    if(placeComplete==null){
        $("#input-address-create-neighborhood").focus()
        $("#step-one-helper-error").html('<i class="fas fa-info-circle"></i> Por favor ingresar un barrio válido')
        $("#step-one-helper-error").show()
        return false;
    }
    
    if($("#street_name").val().length==0){
        $("#street_name").focus()
        $("#step-one-helper-error").html('<i class="fas fa-info-circle"></i> Por favor ingresar una calle válida')
        $("#step-one-helper-error").show()
        return false;

    }
    
     if($("#street_number").val().length==0){
                 $("#street_number").focus()

        $("#step-one-helper-error").html('<i class="fas fa-info-circle"></i> Por favor ingresar una número calle válida')
        $("#step-one-helper-error").show()
        return false;
    }
    
      $("#step-one-helper-error").html('')
        $("#step-one-helper-error").hide();
        
         $(".step-one").hide();
        $(".step-two").show()
}

function nextValidationImage(){
    
    if(imagesProperty.length<3){
          $("#step-two-helper-error").html('<i class="fas fa-info-circle"></i> Ingresa por lo menos 3 imágenes')
        $("#step-two-helper-error").show()
    }else{
        $("#step-two-helper-error").hide()
        $("#step-two-helper-error").html("")
        $(".step-two").hide()
        $(".step-three").show()
    }
    
}


function prevValidationImage(){
    
        $("#step-two-helper-error").hide()
        $("#step-two-helper-error").html("")
        $(".step-two").hide()
        $(".step-one").show()
    
}

function nextValidationDescription(){
    console.log($("#description").val());
    
    
    if($("#title").val().length==0){
                           $("#title").focus();

          $("#step-three-helper-error").html('<i class="fas fa-info-circle"></i> Ingresa el titulo del anuncio')
        $("#step-three-helper-error").show();
        return false;
    }
    
   
    
     if($("#description").val().length==0){
                   $("#description").focus();
            alert("Ingresa la descripción de la propiedad'");
          $("#step-three-helper-error").html('<i class="fas fa-info-circle"></i> Ingresa la descripción de la propiedad')
        $("#step-three-helper-error").show();
        return false;
    }
    
      if($("#price").val().length==0){
          $("#price").focus();
          $("#step-three-helper-error").html('<i class="fas fa-info-circle"></i> Ingresa el precio de la propiedad')
        $("#step-three-helper-error").show();
        return false;
    }
    
    
     $("#step-three-helper-error").hide()
        $("#step-three-helper-error").html("")
        $(".step-three").hide()
        $(".step-four").show()

        
}



function prevValidationDescription(){
    
        $("#step-three-helper-error").hide()
        $("#step-three-helper-error").html("")
        $(".step-three").hide()
        $(".step-two").show()
    
}




function prevfinishcreation(){
    
        $("#step-four-helper-error").hide()
        $("#step-four-helper-error").html("")
        $(".step-four").hide()
        $(".step-three").show()
    
}


function finishcreation (){
    var propertyType=$("#property-type").val();
    var operation=$("#operation").val();
    var ownerType=$("#owner-type").val();
    var streetName=$("#street_name").val();
    var streetNumber=$("#street_number").val();
    var title=$("#title").val()
    var description=$("#description").val()
    var currency=$("#currency").val();
    var price=$("#price").val();
    var number_of_rooms=$("#number_of_rooms").val()
    var email=$("#email").val();
    var city=$("#city").val();
    var title=$("#title").val();
    var phone=$("#phone").val()
    var neighborhood=$("#input-address-create-neighborhood").val();
    if($("#input-address-create-neighborhood").val().length==0){
        var neighborhood=$("#neighborhood").val();
    }
    var longitude=$("#longitude").val();
    var latitude=$("#latitude").val();
    var facebook_url=null;
    
    var ownername=$("#owner-name").val();
    if(($("#facebook_url").length && $("#facebook_url").val().length)){
     facebook_url=$("#facebook_url").val();
    }
    
         var favorite = [];
            $.each($("input[name='feature']:checked"), function(){            
                favorite.push($(this).val());
            });

    var data={
        propertyType:propertyType,
        operation:operation,
        ownerType:ownerType,
        streetName:streetName,
        streetNumber:streetNumber,
        title:title,
        description:description,
        currency:currency,
        price:price,
        number_of_rooms:number_of_rooms,
        email:email,
        title:title,
        favorite:favorite,
        neighborhood:neighborhood,
        city:city,
        images:imagesProperty,
        phone:phone,
        longitude:longitude,
        latitude:latitude,
        facebook_url:facebook_url,
        ownername:ownername
    };
    
    finishcreationPost(data);
    
}


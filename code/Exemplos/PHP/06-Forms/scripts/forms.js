// Check to see if e-mail isn't blank and is well formed
// Read more at http://www.marketingtechblog.com/javascript-regex-emailaddress/#ixzz1p1ZDMNZe
var filter;
var filterupdate;
//Temos aqui um exemplo de filtros aplicados na validacao podemos criar um extra e usar em cada um
filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,3})$/;
//filter = /^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})$/i;
filterupdate  = /^[a-zA-Z0-9_.-]*$/;

// Validate the login form
function FormLoginValidator(theForm, regex) {
  // Check to see if name isn't blank
  if ( theForm.name.value === "" ) {
    alert("You must enter a VALID name.");
    theForm.name.focus();
    return false;
  }
  
  if (!regex.test( theForm.email.value)) {
    alert('Please provide a valid e-mail address');
    theForm.email.focus();
    return false;
  }
  
  return true;
}

function FormUpdateProfileValidator(theForm,regex) {
  if(!regex.test(theForm.alias.value)){
      alert('Please provide a valid alias!');
      theForm.alias.focus();
      return false;
  }  
  if(!regex.test(theForm.password.value)){
      alert('Please provide a valid password!');
      theForm.password.focus();
      return false;
  } 
  
  return true;
}

var xmlHttp;

function GetXmlHttpObject() {
  try {
    return new ActiveXObject("Msxml2.XMLHTTP");
  } catch(e) {} // Internet Explorer
  try {
    return new ActiveXObject("Microsoft.XMLHTTP");
  } catch(e) {} // Internet Explorer
  try {
    return new XMLHttpRequest();
  } catch(e) {} // Firefox, Opera 8.0+, Safari
  alert("XMLHttpRequest not supported");
  return null;
}

// The District Select has change
function SelectDistrictChange(theSelect) {
  // The new option
  var selectedDistrict = theSelect.value;
  
  // The new image to display
  var districtImageFile = "images/distritos/" + selectedDistrict + ".gif";
  document.getElementById("imgDistrict").src = districtImageFile;

  // Preparing the arguments to request the counties
  var args = "district="+selectedDistrict;
  
  // With HTTP GET method
  xmlHttp = GetXmlHttpObject();
  xmlHttp.open("GET", "getCounties.php?"+args, true);
  xmlHttp.onreadystatechange=SelectDistrictHandleReply;
  xmlHttp.send(null);
}

//Fill in the counties for the new district
function SelectDistrictHandleReply() {
  
  //alert( xmlHttp.readyState );
  
  if( xmlHttp.readyState === 4 ) {
    var countySelect=document.getElementById("county");

    countySelect.options.length = 0;

    //alert( xmlHttp.responseText );
    
    var counties = JSON.parse( xmlHttp.responseText );
    
    //alert( counties );

    for (i=0; i<counties.length; i++) {
      var currentCounty = counties[i];
      
      var value  = currentCounty.idCounty;
      var option = currentCounty.nameCounty;
	  
      try{
        countySelect.add( new Option("", value), null);
      }
      catch(e) {
        countySelect.add( new Option("", value) );
      }
      
      countySelect.options[i].innerHTML = option;
    }
  }
}

//The County Select has change
function SelectCountyChange(theSelect) {
  // The new option
  var selectedCounty = theSelect.value;
  
  var selectedDistrict = document.getElementById( "district" ).value;
  
  // Preparing the arguments to request the zip codes
  var args = "county=" + selectedCounty + "&district=" + selectedDistrict;
  
  xmlHttp = GetXmlHttpObject();
  
  // Using HTTP GET method
  xmlHttp.open("GET", "getZips.php?"+args, true);
  xmlHttp.onreadystatechange=SelectCountyHandleReply;
  xmlHttp.send( null );
  
  // Using HTTP POST method
  //xmlHttp.open("POST", "getZips.php", true);
  //xmlHttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded");
  //xmlHttp.onreadystatechange=SelectCountyHandleReply;
  // ensure args is encoded!
  //xmlHttp.send( args ); 
}

//Fill in the Zips for the new county
function SelectCountyHandleReply() {
  if( xmlHttp.readyState === 4 ) {
    var zipSelect=document.getElementById("zip");

    zipSelect.options.length = 0;

    var zips = JSON.parse( xmlHttp.responseText );
    
    for (i=0; i<zips.length; i++) {

      var currentZip = zips[i];
      
      var value  = currentZip.idLocation;
      var option = currentZip.postalCode;

      try{
        zipSelect.add( new Option(option, value), null);
      }
      catch(e) {
        zipSelect.add( new Option(option, value) );
      }
    }
  }
}

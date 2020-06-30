function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      document.getElementById("geo").innerHTML = ("Geolocation is not supported by this browser.");
    }
  }
  
  function showPosition(position) {
    document.getElementById("geo").innerHTML = ("Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude); 
  }


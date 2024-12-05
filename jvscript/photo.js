function displayPics() {

  if ( document.getElementById('galerie_mini') != null ) {

    var photos = document.getElementById('galerie_mini') ;
    var liens = photos.getElementsByTagName('a') ;
    var big_photo = document.getElementById('big_pict') ;
  
    for (var i = 0 ; i < liens.length ; ++i) {
      liens[i].onclick = function() {
        big_photo.src = this.href;
        return false;
      };
    }
  } else return ;
}

window.onload = displayPics;


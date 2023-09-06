window.onclick = function (event) {
  var modal = document.getElementById("modal");
  if (typeof modal != "undefined" && modal != null && event.target == modal) {
    modal.style.display = "none";
  }
};


$(document).ready(function(){
  $('.modal-toggle').on('click', function() {
    document.getElementById("modal").style.display = "block";
  });

  $('.modal-close').on('click', function() {
    document.getElementById("modal").style.display = "none";
  });
 
});
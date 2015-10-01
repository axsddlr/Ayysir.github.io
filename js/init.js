(function($){
  $(function(){

  $('.button-collapse').sideNav({
      menuWidth: 205, // Default is 240
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
    }
  );

$(document).ready(function(){               
  $('.materialboxed').materialbox();
});
$(document).ready(function(){
  $('.materialboxed').materialbox();
});

$(".dropdown-button").dropdown();
  }); // end of document ready
})(jQuery); // end of jQuery name space

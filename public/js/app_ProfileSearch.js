/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This file contains JavaScript code for app.blade.php. Performs a search for profiles that match a criteria.

*/

// CSRF Token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

(function($){
  $(document).ready(function()
  {
    // Autocompletes input text box with profiles names.
    $( "#profileSearch" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url:"/profile/getProfiles/",
          type: 'post',
          dataType: "json",
          data: {
           _token: CSRF_TOKEN,
           search: request.term
          },
          success: function( data ) {
             response( data );
          }
        });
      },

      select: function (event, ui) {
        // Set selection
        $('#profileSearch').val(ui.item.label); // display the selected text
        // When user clicks on search button, He will be redirected to chosen profile's page.
         document.getElementById("selectedProfile").href= "/profile/" + ui.item.value;
        return false;
      }
    });
  });
})(jQuery);

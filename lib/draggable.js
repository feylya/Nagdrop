/**
 * Sets up divs to be draggable so we can click on them and drop them onto
 * objects
 * 
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 30 December 2009
 */
$(document).ready(function() {
  // Setup the draggable elements and darken the background
    $(".draggable").draggable( {
      revert : true,
      start : function(event, ui) {
        $('body').css("background-color", "#494949");
      },
      stop : function(event, ui) {
        $('body').css("background-color", "#ffffff");
      }
    });
  });
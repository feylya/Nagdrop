/**
 * Main javascript file Holds all functions for the drag and drop functionality
 * Including functions to add and remove divs for services, hosts, etc
 * 
 * @author Paul O'Connor
 * @date 28 December 2009
 */

$(document).ready(
  function() {
  $("#topMenuLowerRight").click(
    function() {
    $("#hs_menu_background").toggle("blind");
    $("#topMenuLowerText").toggle();
    $("#groups").toggleClass('bigMargin');
    $("#config_arrow").toggleClass(
      'ui-icon-circle-triangle-s')
      .toggleClass(
        'ui-icon-circle-triangle-n');
    });

  // Hide the menu at the top - deprecated
  $("#hs_menu_background").hide();

  // Remove the render class from the menu - deprecated
  $("#hs_menu_background").removeClass("render");

  var name = "#holder";
  var menuYloc = null;

  $(document).ready(
    function() {
    menuYloc = parseInt($(name).css("top")
      .substring(0, $(name).css("top").indexOf("px")))
    $(window).scroll(
      function() {
        var offset = menuYloc + $(document).scrollTop() + "px";
        $(name).animate( {
        top : offset
        }, {
        duration : 500,
        queue : false
        });
      });
    });

  // Setup the draggable elements and darken the background
  $(".draggable").draggable( {
  revert : true,
  start : function(event, ui) {
    $('#mainBody').css("background-color", "#bebebe");
  },
  stop : function(event, ui) {
    $('#mainBody').css("background-color", "#ffffff");
  }
  });

  // Setup the holder to be draggable - deprecated
  $(".draggableHolder").draggable( {
  revert : false
  });

  // Set up the droppable elements (hosts, hostgroups etc)
  $(".droppable")
  .droppable(
    {
      activeClass : 'drop',
    accept : '.draggable',
    hoverClass : 'ui-state-active',
    over : function(event, ui) {
      // We're gonna need to call an ajax
      // compare here
      // See if the machine accepts the
      // service etc
      var drop_data = event.target.id;
      var drag_data = ui.draggable.context.id;
    },
    drop : function(event, ui) {
      var drop_data = event.target.id;
      var drag_data = ui.draggable.context.id;
      // $(ui.draggable.context).("highlight",
      // {}, 3000);
      // alert (drop_data + " " +
      // drag_data);
      $.post(base_url + "index.php/modify/add",
      {
      drop : drop_data,
      drag : drag_data
      },
      function(data) {
      if (data.Success == true) {
        // $("#status").animate({opacity:
        // 0}, 200,
        // function
        // (){$("#status").html(status[state]).css({background:
        // background[state]}).animate({opacity:
        // 1},
        // 200)});
        success(data.Message);
        dropJSON = eval('(' + drop_data + ')');
        dragJSON = eval('(' + drag_data + ')');
        switch (dragJSON.type) {
        case 'service':
        $.post(base_url
          + "index.php/service/getHost/"
          + dropJSON.id,
          function(data) {
          // Lots of lovely HTML...
          $('#services' + dropJSON.id).html(data)
          });
        break;
        case 'host':
        $.post(base_url
          + "index.php/hostgroup/getHosts/"
          + dropJSON.id,
          function(data) {
          // Lots of lovely HTML...
          $('#hostgroups' + dropJSON.id).html(data)
          });
        $("#topMenuLowerText").html("");
        }
  
      } else if (data.Success == false) {
        failure(data.Message);
      }
  
      }, 'json')
    }
  });

  // Setup the dialog for Hosts
  // Need to change this to be a global dialog
  $("#dialogHost").dialog(
  {
    bgiframe : true,
    autoOpen : false,
    draggable : false,
    width : 750,
    modal : true,
    buttons : {
    'Update host' : function() {
      var str = $("#hostForm").serialize();
      $.post(base_url + "index.php/popup/setHost",
      {
        data : str
      });
      $(this).dialog('close');

    },
    'Delete' : function() {
      var id = $("#host_id").attr(
        'value');
      if (confirm('Do you want to delete this host?')) {
      $.post(base_url
        + "index.php/popup/deleteHost/"
        + id);
      $(this).dialog('close');
      }
    },
    Cancel : function() {
      $(this).dialog('close');
    }
    },
    close : function() {
    // allFields.val('').removeClass('ui-state-error');
  }
  });

  // Open the dialog for a new host - possibly deprecate
  $('#newHost').click(function() {
  $('#dialogHost').dialog('open');
  })

});

// False the top of the page to display an error message
function failure(message) {
  $("#topMenuLowerText").html(message);
  $("#topMenuLowerBar").animate( {
  backgroundColor : "red"
  }, 3000).animate( {
  backgroundColor : "white"
  }, 1000);
  setTimeout(function() {
  $("#topMenuLowerText").html("");
  }, 4000);
}

// False the top of the page to display a success message
function success(message) {
  $("#topMenuLowerText").html(message);
  $("#topMenuLowerBar").animate( {
  backgroundColor : "green"
  }, 3000).animate( {
  backgroundColor : "white"
  }, 1000);
  setTimeout(function() {
  $("#topMenuLowerText").html("");
  }, 4000);
}

function hostShowServices(id, hostId) {
  var item = document.getElementById(id);
  // $("#" + id).show();
  $("#" + id).toggle(
    function() {
    alert("show " + hostId);
    $('icon' + hostId).toggleClass('ui-icon-circle-triangle-s')
      .toggleClass('ui-icon-circle-triangle-n');
    $.post(base_url + "index.php/service/getHost/" + hostId,
      function(data) {
        // Lots of lovely HTML...
      $("#" + id).html(data);
      });
    $("#" + id).show();
    },
    function() {
    alert("hide " + hostId);
    $('icon' + hostId).toggleClass('ui-icon-circle-triangle-s')
      .toggleClass('ui-icon-circle-triangle-n');
    $("#" + id).hide();
    });

}

// Filter the elements that are displayed for dragging
function search(textBox, elementName) {
  var searchString = $("input:text[name=" + textBox + "]").val();
  // searchString = searchString.toLowerCase();
  $("." + elementName).show();
  // jQuery doesn't have a case insensitive :contains
  // so search for both
  $("." + elementName + ":not(:contains('" + searchString + "'))").hide();

}

// Deprecated - not sure what I was using this for
function filter(value, elementName) {
  var searchString = $("input:text[name=" + textBox + "]").val();
  // searchString = searchString.toLowerCase();
  $("." + elementName).show();
  $("." + elementName + ").attr('title'):not(:contains('"
          + searchString + "'))").hide();
}

// Remove a service from a host
// TODO: Change alerting function
function removeService(id) {
  var item = document.getElementById(id);
  $.post(base_url + "index.php/modify/removeServiceHost", {
  id : id
  }, function(data) {
  if (data.Success == true) {
    $("div#topMenuLowerText").html("BLEH");
    $("#topMenuLowerBar").effect("highlight", {}, 3000);
    $("div#topMenuLowerText").text("");
  }
  }, 'json');
  $(item).remove();
  // alert($(item).parent().attr('id)'));
  $(item).parent().hide();
  // $(item).parent().show();
}

function removeServiceFromHostgroup(id) {
  // var item = document.getElementById('host'+id);
  $.post(base_url + "index.php/modify/removeHostHostgroup", {
  id : id
  }, function(data) {
  if (data.Success == true) {
    $("div#topMenuLowerText").html("BLEH");
    $("#topMenuLowerBar").effect("highlight", {}, 3000);
    // $("div#topMenuLowerText").text("");
  }
  }, 'json');
  $('#host' + id).remove();
}

// Load hosts into the menu
function loadHosts() {
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' 
      + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/hosts/", function(data) {
  // Lots of lovely HTML...
    $('#holder').html(data);
    $('#holder').show();
    setupDraggable();
  });
}

// Load services into the menu
function loadServices() {
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' 
    + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/services/", function(data) {
  // Lots of lovely HTML...
    $('#holder').html(data);
    $('#holder').show();
    setupDraggable();
  });

}

// Load hostgroups into the menu
function loadHostgroups() {
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' 
    + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/hostgroups/", function(data) {
  // Lots of lovely HTML...
    $('#holder').html(data);
    $('#holder').show();
    // Setup the draggable elements and darken the background
    setupDraggable();
  });
}

// Load hostgroups into the menu
function loadServicegroups() {
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' 
    + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/servicegroups/", function(data) {
  // Lots of lovely HTML...
    $('#holder').html(data);
    $('#holder').show();
    // Setup the draggable elements and darken the background
    setupDraggable();
  });
}

function setupDraggable() {
  $(".draggable").draggable( {
  revert : true,
  start : function(event, ui) {
    $('#mainBody').css("background-color", "#bebebe");
  },
  stop : function(event, ui) {
    $('#mainBody').css("background-color", "#ffffff");
  }
  });
}

// Load a specific host into the dialog
function editHost(id) {
  $.post(base_url + "index.php/popup/getHost/" + id, function(data) {
  //Lots of lovely HTML...
    $('#dialogHost').html(data);
    $('#dialogHost').dialog('open');
  });
}

//Remove t_ which dictates it's inherited from a template
function removeT(id) {
  if (id.substr(0, 2) == "t_") {
  $("#" + id).attr("name", id.substr(2));
  $("#" + id).attr("id", id.substr(2));
  }
}

/**
 * File: core.js
 * 
 * 
 * Main javascript file Holds most functions for the drag and drop functionality
 * Core setup functions are in droppable.js and draggable.js These are called
 * repeatedly - needed to keep filesize down Including functions to add and
 * remove divs for services, hosts, etc
 * 
 * @author Paul O'Connor 
 * @date 28 December 2009
 */

// Global variable goodness
var alertTimerId = 0;

$(document).ready(function() {
  // Setup the dialog for Hosts
  // Need to change this to be a global dialog
  $("#dialogHost").dialog({
    bgiframe : true,
    autoOpen : false,
    draggable : false,
    width : 750,
    modal : true,
    buttons : {
      'Update host' : function() {
        var str = "";
        // jQuery's .serialize() function ignores empty checkboxes but we need them 
        // Step through every checkbox, see if it's unchecked and starts with 't_'
        $('input[type=checkbox]').each(
          function() {
            if ($(this).is(':checked')) {
            } else {
              if ($(this).attr('id').substr(0,2) != "t_") 
              {
                name = $(this).attr('name');
                str += name + '=0&';
              }
            }
          });
        str += $("#hostForm").serialize();
        $.post(base_url + "index.php/popup/setHost", {
            data : str
            }, function(data) {
              //WE need this to run once the DB is updated
                  $.post(base_url + "index.php/home/hosts/", 
                		  {t:'t'},
                    function(data) {
                      // Lots of lovely HTML...
                      $('#groups').html(data);
                    });
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
              });
        $(this).dialog('close');
  
      },
      'Delete' : function() {
        var id = $("#host_id").attr('value');
        if (confirm('Do you want to delete this host?')) {
          $.post(base_url + "index.php/popup/deleteHost/" + id,
              function(data) {
                $('#host'+id).remove();  
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
              });
  
          $('#host' + id).remove();
          $(this).dialog('close');
        }
      },
      Cancel : function() {
        var id = $("#host_id").attr('value');
        var host_name = $("#display_name").attr('value');
        if (host_name == 'CHANGEME') {
          $.post(base_url + "index.php/popup/deleteHost/" + id,
            function(data) {
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
            });
        }
        $(this).dialog('close');
      }
    },
    close : function() {
    }
  });

  // Setup the dialog for Host Templates
  // Need to change this to be a global dialog
  $("#dialogHostTemplate").dialog(
  {
    bgiframe : true,
    autoOpen : false,
    draggable : false,
    width : 750,
    modal : true,
    buttons : {
      'Update Host Template' : function() {
        var str = "";
        // jQuery's .serialize() function ignores empty checkboxes but we need them 
        // Step through every checkbox, see if it's unchecked
        $('input[type=checkbox]').each(
            function() {
              if ($(this).is(':checked')) {
              } else {
                name = $(this).attr('name');
                str += name + '=0&';
              }
            });
        str += $("#hostForm").serialize();
        $.post(base_url + "index.php/popup/setHostTemplate",
          {
            data : str
          }, function(data) {
            //We need this to run once the DB is updated
                $.post(base_url + "index.php/home/thosts/", 
                  {t:'t'},
                    function(data) {
                      // Lots of lovely HTML...
                    $('#groups').html(data);
                  });
            // We need to stop any previous write and restart
            clearTimeout(alertTimerId);
            // Let's wait 5 seconds before writing and restarting
            // This allows extra changes and shouldn't hit a previous instance
            alertTimerId = setTimeout("checkRestart()",5000);
        });
        
        $(this).dialog('close');

      },
      Cancel : function() {
        var id = $("#thost_id").attr(
            'value');
        var host_name = $("#thost_name")
            .attr('value');
        if (host_name == 'CHANGEME') {
          $.post(base_url + "index.php/popup/deleteHostTemplate/" + id,
            function(data) {
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
            });
        }
        $(this).dialog('close');
      }
    },
    close : function() {
    }
  });

  // Setup the dialog for Hostgroups
  $("#dialogHostgroup").dialog(
  {
    bgiframe : true,
    autoOpen : false,
    draggable : false,
    width : 750,
    modal : true,
    buttons : {
      'Update hostgroup' : function() {
        var str = $("#hostgroupForm").serialize();
        $.post(base_url + "index.php/popup/setHostgroup",
        {
          data : str
        }, function(data) {
          //We need this to fire after the DB has been updated
              $.post(base_url + "index.php/home/hostgroups/", 
                {t:'t'},
                  function(data) {
                    // Lots of lovely HTML...
                  $('#groups').html(data);
                });
          // We need to stop any previous write and restart
          clearTimeout(alertTimerId);
          // Let's wait 5 seconds before writing and restarting
          // This allows extra changes and shouldn't hit a previous instance
          alertTimerId = setTimeout("checkRestart()",5000);
      });

        $(this).dialog('close');

      },
      'Delete' : function() {
        var id = $("#hostgroup_id").attr(
            'value');
        if (confirm('Do you want to delete this hostgroup?')) {
          $.post(base_url + "index.php/popup/deleteHostgroup/" + id,
            function(data) {
              $('#hostgroup'+id).remove();  
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
            });
          $('#hostgroup' + id).remove();
          $(this).dialog('close');
        }
      },
      Cancel : function() {
        var id = $("#hostgroup_id").attr(
            'value');
        var alias = $("#alias").attr(
            'value');
        if (alias == 'CHANGEME') {
          $.post(base_url + "index.php/popup/deleteHostgroup/" + id,
            function(data) {
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
            });
        }
        $(this).dialog('close');
      }
    },
    close : function() {
    }
  });
  
  // Setup the dialog for Hosts
  // Need to change this to be a global dialog
  $("#dialogService").dialog({
    bgiframe : true,
    autoOpen : false,
    draggable : false,
    width : 750,
    modal : true,
    buttons : {
      'Update service' : function() {
        var str = "";
        // jQuery's .serialize() function ignores empty checkboxes but we need them 
        // Step through every checkbox, see if it's unchecked and starts with 't_'
        $('input[type=checkbox]').each(
            function() {
              if ($(this).is(':checked')) {
              } else {
                if ($(this).attr('id').substr(0,2) != "t_") 
                {
                  name = $(this).attr('name');
                  str += name + '=0&';
                }
              }
            });
        str += $("#serviceForm").serialize();
        $.post(base_url + "index.php/popup/setService", {
            data : str
            }, function(data) {
              //We need this to fire after the DB is updated
                  $.post(base_url + "index.php/home/services/", 
                    {t:'t'},
                      function(data) {
                        // Lots of lovely HTML...
                      $('#groups').html(data);
                    });
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
              });
        
        $(this).dialog('close');

      },
      'Delete' : function() {
        var id = $("#service_id").attr('value');
        if (confirm('Do you want to delete this service?')) {
          $.post(base_url + "index.php/popup/deleteService/" + id,
              function(data) {
                $('#service'+id).remove();  
                // We need to stop any previous write and restart
                clearTimeout(alertTimerId);
                // Let's wait 5 seconds before writing and restarting
                // This allows extra changes and shouldn't hit a previous instance
                alertTimerId = setTimeout("checkRestart()",5000);
              });

          $('#host' + id).remove();
          $(this).dialog('close');
        }
      },
      Cancel : function() {
        var id = $("#host_id").attr('value');
        var host_name = $("#display_name").attr('value');
        if (host_name == 'CHANGEME') {
          $.post(base_url + "index.php/popup/deleteService/" + id,
            function(data) {
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
            });
        }
        $(this).dialog('close');
      }
    },
    close : function() {
    }
  });
  
  // Setup the dialog for Host Templates
  // Need to change this to be a global dialog
  $("#dialogServiceTemplate").dialog(
  {
    bgiframe : true,
    autoOpen : false,
    draggable : false,
    width : 750,
    modal : true,
    buttons : {
      'Update Service Template' : function() {
        var str = "";
        // jQuery's .serialize() function ignores empty checkboxes but we need them 
        // Step through every checkbox, see if it's unchecked
        $('input[type=checkbox]').each(
            function() {
              if ($(this).is(':checked')) {
              } else {
                name = $(this).attr('name');
                str += name + '=0&';
              }
            });
        str += $("#serviceTemplateForm").serialize();
        $.post(base_url + "index.php/popup/setServiceTemplate",
          {
            data : str
          }, function(data) {
            // We need to stop any previous write and restart
            clearTimeout(alertTimerId);
            // Let's wait 5 seconds before writing and restarting
            // This allows extra changes and shouldn't hit a previous instance
            alertTimerId = setTimeout("checkRestart()",5000);
        });
        //Wrapper this in a timer to wait 100ms before requesting the just written information
        $.post(base_url + "index.php/home/tservices/", 
          {t:'t'},
            function(data) {
              // Lots of lovely HTML...
            $('#groups').html(data);
          });
        $(this).dialog('close');

      },
      Cancel : function() {
        var id = $("#tservice_id").attr('value');
        var host_name = $("#display_name").attr('value');
        if (host_name == 'CHANGEME') {
          $.post(base_url + "index.php/popup/deleteServiceTemplate/" + id,
            function(data) {
              // We need to stop any previous write and restart
              clearTimeout(alertTimerId);
              // Let's wait 5 seconds before writing and restarting
              // This allows extra changes and shouldn't hit a previous instance
              alertTimerId = setTimeout("checkRestart()",5000);
            });
        }
        $(this).dialog('close');
      }
    },
    close : function() {
    }
  });

  // Open the dialog for a new host - possibly deprecated
  // Moved to a <a href=''> link
  /*
   $('#newHost').click(function(){
   $('#dialogHost').dialog('open'); })
   */

});

/**
 * Function to call the Restart section of the files controller Writes all
 * configuration files and then restart Nagios
 * 
 * @return null
 */
function checkRestart() {
  $.post(base_url + 'index.php/files/write',
      function(data) {
        if (data.Success == true) {
          success("Configuration files written - Nagios restarted",
              'FALSE');
        } else {
          failure("Something failed during sanity check or restart",
              'FALSE');
        }
      }, 'json'); // Update files and restart Nagios
}

/**
 * Load up information about a host into a popup so that we can edit it
 * 
 * @return null
 */
function editHost(id) {
  $.post(base_url + "index.php/popup/getHost/" + id, function(data) {
    // Lots of lovely HTML...
      $('#dialogHost').html(data);
      $('#dialogHost').dialog('open');
    });
}

/**
 * Load up information about a host template into a popup so that we can edit it
 * 
 * @return null
 */
function editHostTemplate(id) {
  $.post(base_url + "index.php/popup/getHostTemplate/" + id, function(data) {
    // Lots of lovely HTML...
      $('#dialogHostTemplate').html(data);
      $('#dialogHostTemplate').dialog('open');
    });
}

/**
 * Load up information about a hostgroup into a popup so that we can edit it
 * 
 * @return null
 */
function editHostgroup(id) {
  $.post(base_url + "index.php/popup/getHostgroup/" + id, function(data) {
    // Lots of lovely HTML...
      $('#dialogHostgroup').html(data);
      $('#dialogHostgroup').dialog('open');
    });
}

/**
 * Load up information about a service into a popup so that we can edit it
 * 
 * @return null
 */
function editService(id) {
  $.post(base_url + "index.php/popup/getService/" + id, function(data) {
    // Lots of lovely HTML...
      $('#dialogService').html(data);
      $('#dialogService').dialog('open');
    });
}

/**
 * Load up information about a service template into a popup so that we can edit it
 * 
 * @return null
 */
function editServiceTemplate(id) {
  $.post(base_url + "index.php/popup/getServiceTemplate/" + id, function(data) {
    // Lots of lovely HTML...
      $('#dialogServiceTemplate').html(data);
      $('#dialogServiceTemplate').dialog('open');
    });
}


/**
 * Displays error message in notification bar at the top of the screen
 * 
 * @return null
 */
function failure(message) {
  $("#topMenuLowerText").html(message);
  $("#topMenuLowerBar").animate( {
    backgroundColor : "red"
  }, 4000).animate( {
    backgroundColor : "white"
  }, 1000);
  setTimeout(function() {
    $("#topMenuLowerText").html("");
  }, 5000);
  $("#topMenuLowerBar").animate( {
    backgroundColor : "white"
  }, 1); /* Need to force the background to white */
}

/**
 * Deprecated - Filter the elements in a menu for dragging
 * 
 * @return null
 */
function filter(value, elementName) {
  var searchString = $("input:text[name=" + textBox + "]").val();
  // searchString = searchString.toLowerCase();
  $("." + elementName).show();
  $("." + elementName + ").attr('title'):not(:contains('"  + searchString + "'))").hide();
}

/**
 * Load all the hostgroups for a particular host and display them in the div
 * that is identified by id
 * 
 * @return null
 */
function hostShowHostgroups(id, hostId) {
  $.post(base_url + "index.php/host/getHostgroups/" + hostId, function(data) {
    // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

/**
 * Load all the services for a particular host and display them in the div that
 * is identified by id
 * 
 * @return null
 */
function hostShowServices(id, hostId) {
  $.post(base_url + "index.php/host/getServices/" + hostId, function(data) {
    // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

/**
 * Load all the hosts for a particular hostgroup and display them in the div
 * that is identified by id
 * 
 * @return null
 */
function hostgroupShowHosts(id, hostgroupId) {
  $.post(base_url + "index.php/hostgroup/getHosts/" + hostgroupId, function(
      data) {
    // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

/**
 * Load all the services for a particular hostgroup and display them in the div
 * that is identified by id
 * 
 * @return null
 */
function hostgroupShowServices(id, hostgroupId) {
  $.post(base_url + "index.php/hostgroup/getServices/" + hostgroupId,
      function(data) {
        // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

/**
 * Load the list of hostgroups into the menu div that's at the side of the
 * screen Loads up a little animation while the content is being loaded in the
 * background The animation is replaced with the content when it's ready
 * 
 * @return null
 */
function loadHostgroups(x) {
  $('#groups').addClass('move');
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/hostgroups/" + x, function(data) {
    // Lots of lovely HTML...
      $('#holder').html(data);
      $('#holder').show();
      // Setup the draggable elements and darken the background
      setupDraggable();
    });
}

/**
 * Load the list of hosts into the menu div that's at the side of the screen
 * Loads up a little animation while the content is being loaded in the
 * background The animation is replaced with the content when it's ready
 * 
 * @return null
 */
function loadHosts(x) {
  $('#groups').addClass('move');
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/hosts/" + x, function(data) {
    // Lots of lovely HTML...
      $('#holder').html(data);
      $('#holder').show();
      setupDraggable();
    });
}

/**
 * Load the list of servicegroups into the menu div that's at the side of the
 * screen Loads up a little animation while the content is being loaded in the
 * background The animation is replaced with the content when it's ready
 * 
 * @return null
 */
function loadServicegroups(x) {
  $('#groups').addClass('move');
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/servicegroups/" + x, function(data) {
    // Lots of lovely HTML...
      $('#holder').html(data);
      $('#holder').show();
      // Setup the draggable elements and darken the background
      setupDraggable();
    });
}

/**
 * Load the list of service into the menu div that's at the side of the screen
 * Loads up a little animation while the content is being loaded in the
 * background The animation is replaced with the content when it's ready
 * 
 * @return null
 */
function loadServices(x) {
  $('#groups').addClass('move');
  $('#holder').hide();
  $('#holder').html('<center><br /><br /><br /><br /><img src="' + base_url + 'images/ajax_loader.gif" /></center>');
  $('#holder').show();
  $.post(base_url + "index.php/menu/services/" + x, function(data) {
    // Lots of lovely HTML...
      $('#holder').html(data);
      $('#holder').show();
      setupDraggable();
    });

}

/**
 * A null function that exists only to stop the browser complaining about a
 * function not being defined
 * 
 * @return null
 */
function none() {
  return null;
}

/**
 * Remove a host from a hostgroup, right it to the database and remove it from
 * the UI Could modify removeHostgroupFromHost to do the same things but this is
 * cleaner if longer
 * 
 * @return null
 */
function removeHostFromHostgroup(div, id, hg_id) {
  $.post(base_url + "index.php/modify/removeHostFromHostgroup", {
    id : hg_id
  }, function(data) {
    if (data.Success == true) {
      success("Host Removed");
      $('#' + div).remove();
    }
  }, 'json');
}

/**
 * Remove a host from a service, right it to the database and remove it from the
 * UI Could modify removeServiceFromHost to do the same things but this is
 * cleaner if longer
 * 
 * id here is the value of nagdrop_services_hosts.service_host_id
 * 
 * @return null
 */
function removeHostFromService(div, id, service_id) {
  $.post(base_url + "index.php/modify/removeHostFromService", {
    id : service_id
  }, function(data) {
    if (data.Success == true) {
      success("Host Removed");
      $('#' + div).remove();
    }
  }, 'json');
}

/**
 * Remove a hostgroup from a host, right it to the database and remove it from
 * the UI
 * 
 * @return null
 */
function removeHostgroupFromHost(div, id, hg_id) {
  $.post(base_url + "index.php/modify/removeHostFromHostgroup", {
    id : id,
    hg_id : hg_id
  }, function(data) {
    if (data.Success == true) {
      success("Hostgroup Removed");
      $('#' + div).remove();
    }
  }, 'json');
}

/**
 * Remove a service from a host, right it to the database and remove it from the
 * UI
 * 
 * @return null
 */
function removeServiceFromHost(div, id, host_id) {
  var item = document.getElementById(id);
  $.post(base_url + "index.php/modify/removeServiceHost", {
    id : id
  }, function(data) {
    if (data.Success == true) {
      success("Service Removed");
      $('#' + div).remove();
    }
  }, 'json');
}

/**
 * Remove a service from a hostgroup, right it to the database and remove it
 * from the UI
 * 
 * @return null
 */
function removeServiceFromHostgroup(div, id, hg_id) {
  // var item = document.getElementById('host'+id);
  $.post(base_url + "index.php/modify/removeServiceFromHostgroup", {
    id : id,
    hg_id : hg_id
  }, function(data) {
    if (data.Success == true) {
      success("Service Removed");
      $('#' + div).remove();
    }
  }, 'json');
}

/**
 * Remove t_ which dictates it's inherited from a template
 * 
 * @return null
 */
function removeT(id) {
  if (id.substr(0, 2) == "t_") {
    $("#" + id).attr("name", id.substr(2));
    $("#" + id).attr("id", id.substr(2));
  }
}

/**
 * Deprecated - Was going to have a search box for the menu popup Search the
 * elements that are displayed for dragging
 * 
 * @return null
 */
function search(textBox, elementName) {
  var searchString = $("input:text[name=" + textBox + "]").val();
  // searchString = searchString.toLowerCase();
  $("." + elementName).show();
  // jQuery doesn't have a case insensitive :contains
  // so search for both
  $("." + elementName + ":not(:contains('" + searchString + "'))").hide();

}

/**
 * Load all the hostgroups for a particular service and display them in the div
 * that is identified by id
 * 
 * @return null
 */
function serviceShowHostgroups(id, serviceId) {
  $.post(base_url + "index.php/service/getHostgroups/" + serviceId, function(
      data) {
    // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

/**
 * Load all the hosts for a particular service and display them in the div that
 * is identified by id
 * 
 * @return null
 */
function serviceShowHosts(id, serviceId) {
  $.post(base_url + "index.php/service/getHosts/" + serviceId,
      function(data) {
        // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

/**
 * Make any divs with the class .draggable able to be moved around the screen
 * Darkens the background to make the targets a bit more obvious
 * 
 * @return null
 */
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

/**
 * Displays success message in the notification bar at the top of the screen
 * 
 * @return null
 */
function success(message, restart) {
  $("#topMenuLowerText").html(message);
  $("#topMenuLowerBar").animate( {
    backgroundColor : "green"
  }, 4000).animate( {
    backgroundColor : "white"
  }, 1000);
  setTimeout(function() {
    $("#topMenuLowerText").html("");
  }, 5000);
  $("#topMenuLowerBar").css('backgroundColor', "white"); // Need to force the background to white
  if (!restart) {
    // We need to stop any previous write and restart
    clearTimeout(alertTimerId);
    // Let's wait 5 seconds before writing and restarting
    // This allows extra changes and shouldn't hit a previous instance
    alertTimerId = setTimeout("checkRestart()", 5000);
  }
}

/**
 * Load all the host that are using a particular template and display them in
 * the div that is identified by id
 * 
 * @return null
 */
function thostShowHosts(id, templateId) {
  $.post(base_url + "index.php/thost/getHosts/" + templateId, function(data) {
    // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

/**
 * Load all the host that are using a particular template and display them in
 * the div that is identified by id
 * 
 * @return null
 */
function tserviceShowServices(id, templateId) {
  $.post(base_url + "index.php/tservice/getServices/" + templateId, function(data) {
    // Lots of lovely HTML...
      $('#' + id).html(data);
    });
}

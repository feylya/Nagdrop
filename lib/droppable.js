/**
 * Grab the objects that have been dropped onto and dragged Parse them and send
 * them to the backend to process.
 * 
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 30 December 2009
 */
$(document).ready(function() {
  // Set up the droppable elements (hosts, hostgroups etc)
    $(".droppable").droppable(
        {
          activeClass : 'drop',
          accept : '.draggable',
          hoverClass : 'ui-state-active',
          over : function(event, ui) {
            // We're gonna need to call an ajax compare here
          // See if the machine accepts the service etc
          var drop_data = event.target.id;
          var drag_data = ui.draggable.context.id;
        },
          drop : function(event, ui) {
            var drop_data = event.target.id;
            var drag_data = ui.draggable.context.id;
            $.post(base_url + "index.php/modify/add", {
              drop : drop_data,
              drag : drag_data
            }, function(data) {
              if (data.Success == true) {
                success(data.Message);
                dropJSON = eval('(' + drop_data + ')');
                dragJSON = eval('(' + drag_data + ')');
                switch (dragJSON.type) {
                case 'service':
                  $.post(base_url + "index.php/"
                      + dropJSON.type + "/getServices/"
                      + dropJSON.id, function(data) {
                    // Lots of lovely HTML...
                      $('#services' + dropJSON.id).html(
                          data)
                    });
                  break;
                case 'host':
                  $.post(base_url + "index.php/"
                      + dropJSON.type + "/getHosts/"
                      + dropJSON.id, function(data) {
                    // Lots of lovely HTML...
                      $('#hosts' + dropJSON.id)
                          .html(data)
                    });
                  break;
                case 'hostgroup':
                  $.post(base_url + "index.php/"
                      + dropJSON.type + "/getHostgroups/"
                      + dropJSON.id, function(data) {
                    // Lots of lovely HTML...
                      $('#hostgroups' + dropJSON.id)
                          .html(data)
                    });
                }
              } else if (data.Success == false) {
                failure(data.Message);
              }
            }, 'json')
          }
        });
  });
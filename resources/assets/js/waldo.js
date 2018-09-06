var waldo = {};

var helpers = window.Helpers;

/**
 * Breaks the room code ('SH0270' or 'JD1622C') into its components: ('SH', '270', '') or ('JD', '1622' 'C')
 * @param roomCode (String)
 * @return object
 */
waldo.decomposeRoomCode = function decomposeRoomCode(roomCode) {
    matches = /([A-Z]+)(0*)([0-9]+)([A-Z0-9]*)/g.exec(roomCode);
    // matches[0] is just a copy of the room code.
    let building = matches[1];
    // matches[2] is the leading leading zeros to the number. we don't want them.
    let number = matches[3];
    let suffix = matches[4];
    return {
        building: building,
        number: number,
        suffix: suffix
    };
}

/**
 * Show the map, if it is available, else show an error.
 * @param mapData
 */
waldo.showMapModal = function showMapModal (mapData) {
  // An error has occurred
  if("error" in mapData) {
        $('#waldo-map-message').text(mapData['error']);
    } else {
        // Check to see if the #room-map container exists in the DOM
        if($('#room-map').length == 0) {
          $('#waldo-map-message').after("<div id=\"room-map\"></div>");
        }
        // Grab the collection from the data returned from waldo.
        mapData = mapData['rooms'][0];
        // Leaflet api is picky about map height.
        $('#room-map').css({
            'height':'40em',
            'width': '100%',
        });
        // An object separating the components of the room code.
        let room = waldo.decomposeRoomCode(mapData['room_number']);

        // An object containing beautifully formatted strings to display, keyed by its display purpose.
        let displayPretty = {
            title: String.format("Map of: {0} ({1}) {2}{3}",mapData['building_name'], room.building, room.number, room.suffix),
            popup: String.format("{0} {1}{2}", room.building, room.number, room.suffix)
        };
        $('#waldo-map-message').text(displayPretty.title);
        let coordinates = [mapData['latitude'],mapData['longitude']];
        let zoom = 18;
        showMapModal.map = L.map('room-map').setView(coordinates, zoom);
        L.marker(coordinates).addTo(showMapModal.map).bindPopup(displayPretty.popup);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(showMapModal.map);

        // Since the modal animations take some time, we need to refresh the map size after the modal appears.
        modalId = $('#show-waldo-map-modal').data('target');
        $(modalId).on('shown.bs.modal', function(){
            setTimeout(function() {
                showMapModal.map.invalidateSize();
            }, 10);
        });

        // We destroy the #room-map container from the DOM on modal close.
        $(modalId).on('hidden.bs.modal', function() {
          $('#room-map').remove();
        });
    }
    //Show the modal.
    $('#show-waldo-map-modal').click();
}

/**
 * Shows a map of the room using waldo webservice. Best used on a button or anchor tag.
 */
waldo.walDo = function walDo (thisElement = null) {
    if(thisElement === null) {
        thisElement = $(this);
    }

    // Send the room text to waldo webservice, and if waldo finds the longitude and latitude, then it will dynamically
    // populate the map modal and show it.

    let room = thisElement.text();
    let url = String.format("{0}rooms?{1}", helpers.env.waldoUrl, $.param({room: room}));
    if(sessionStorage.getItem('room:'+room)) {
      roomString = sessionStorage.getItem('room:'+room);
      waldo.showMapModal(JSON.parse(roomString));
    } else {
      $.ajax({
        method: "GET",
        dataType: "json",
        url: url,
        success: function (data) {
          if(data['success'] === 'false') {
            data['error'] = "Location data not found.";
          } else {
            sessionStorage.setItem('room:'+room, JSON.stringify(data));
          }
          waldo.showMapModal(data);
        },
        error: function () {
          let data = [];
          data['error'] = "Map service unavailable.";
          waldo.showMapModal(data);
          $('[data-waldo-event-trigger]').each(function(){
            $(this).off(thisElement.data('waldo-event-trigger'));
            helpers.elementToSpan($(this));
          });
        }
      });
    }
}
/**
 * Call this function on Document.ready for pages that need waldo maps.
 * In the HTML, add the data attribute "data-waldo-listener" to an element whose inner html is the location
 * to show on the map. Set these attributes to the type of event that you want to trigger the map being shown.
 * Also don't forget to include the map modal.
 */
waldo.setAllWaldoListeners = function setAllWaldoListeners(tagType = 'a') {
    $(tagType+'[data-waldo-event-trigger]').each(function(){
        let thisElement = $(this);
        // Get the type of listener we on which we are showing the waldo map. For example: "onclick".
        let eventType = thisElement.data('waldo-event-trigger');
        // Remove the existing event listener. This is very important.
        thisElement.off(eventType);
        // Set a listener for waldo.
        thisElement.on(eventType,function(e){
            // Prevents link-following / page-reloading on some browsers.
            e.preventDefault();
            // The actual functionality we want to do on this event.
            waldo.walDo(thisElement);
            // Prevents link-following / page-reloading on other browsers.
            return false;
        });
    });
}

module.exports = waldo;
module.exports.default = waldo;
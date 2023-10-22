var map, marker, unitID, unitEventID, polyline, mapWaypts = []; // global variables

// Print message to log
function msg(text) { $("#log").prepend(text + "<br/>"); }

function init() { // Execute after login succeed
	var sess = wialon.core.Session.getInstance(); // get instance of current Session
	// specify what kind of data should be returned
	var flags = wialon.item.Item.dataFlag.base;

	sess.loadLibrary("itemIcon"); // load Icon Library 
	sess.updateDataFlags( // load items to current session
		[{type: "type", data: "avl_unit", flags: flags, mode: 0}], // items specification
		function (code) { // updateDataFlags callback
			if (code) { msg(wialon.core.Errors.getErrorText(code)); return; } // exit if error code
			
			var units = sess.getItems("avl_unit"); // get loaded 'avl_resource's items
			if (!units || !units.length){ msg("No units found"); return; } // check if units found
			for (var i = 0; i< units.length; i++) // construct Select list using found resources
				$("#units").append("<option value='"+ units[i].getId() +"'>"+ units[i].getName()+ "</option>");
			// bind action to select change event
			$("#units").change( showUnit );
	});
}

function showUnit(){ // show selected unit on map
	var val = $("#units").val(); // get selected unit id
	if (!val) return; // exit if no unit selected
	var sess = wialon.core.Session.getInstance(); // get instance of current Session
	// specify what kind of data should be returned
	var flags = wialon.item.Unit.dataFlag.lastMessage;
	var unit = null;
	if (unitID) { // check if we already have previous unit
		unit = sess.getItem(unitID);
		sess.updateDataFlags( // remove previous item from current session
			[{type: "id", data: unitID, flags: flags, mode: 2}], // item specification
			function(code) {
				if (code) { msg(wialon.core.Errors.getErrorText(code)); return; }
			
				if (unitEventID) unit.removeListenerById(unitEventID); // unbinding event from this unit
		});
	}

	unitID = val;
	unitEventID = null; // empty event ID
	mapWaypts = []; // remove all old checkpoints if they were here

	sess.updateDataFlags( // load item with necessary flags to current session
		[{type: "id", data: unitID, flags: flags, mode: 1}], // item specification
		function(code) {
			if (code) { msg(wialon.core.Errors.getErrorText(code)); return; }

			unit = wialon.core.Session.getInstance().getItem(val); // get unit by id
			if(!unit) return; // exit if no unit
            var position = unit.getPosition(); // get unit position
			if (!position) return; // exit if no position 
			if (map) { // check if map created and we can detect position of unit

                var icon = L.icon({
                    iconUrl: unit.getIconUrl(32),
                    iconAnchor: [16, 16]
                });
                if (!marker) {
                    marker = L.marker({lat: position.y, lng: position.x}, {icon: icon}).addTo(map);
                } else {
                    marker.setLatLng({lat: position.y, lng: position.x});
                    marker.setIcon(icon);
                }
                map.setView({lat: position.y, lng: position.x});

                if (!polyline) {
                    polyline = L.polyline([{lat: position.y, lng: position.x}], {color: 'blue'}).addTo(map);
                }

//				if (polyline) polyline.setMap(null); // if there is alreday path of map - remove it
//				mapWaypts.push(latlon); // adding point to path array
			}

			msg("You chose unit: " + unit.getName());

			unitEventID = unit.addListener("messageRegistered", showData); // register event when we will receive message
	});
}

function showData(event) {
	var data = event.getData(); // get data from event
	
	if (!data.pos) return; // exit if no position 

	var appended = ''; // here we will put all required information
	var position = { // get unit position 
		x: data.pos.x,
		y: data.pos.y
	};
	appended += "Position (x: " + data.pos.x + "; y: " + data.pos.y +")"; // printing position
	if (data.t) appended += ", time " + wialon.util.DateTime.formatTime(data.t, 1); // printing event time (return user time)
	msg(appended); // writing to log message about this event

	if (map) { // check if map created

        marker.setLatLng({lat: position.y, lng: position.x});

        if (polyline) {
            polyline.addLatLng({lat: position.y, lng: position.x});
        }
        map.setView({lat: position.y, lng: position.x});

	}
}

function initMap() {
    // create a map in the "map" div, set the view to a given place and zoom
    map = L.map('map').setView([45.8, 15.98], 13);

    // add an OpenStreetMap tile layer
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://gurtam.com">Gurtam</a>'
    }).addTo(map);
}

// execute when DOM ready
$(document).ready(function () {

	wialon.core.Session.getInstance().initSession("https://hst-api.wialon.com"); // init session
	// For more info about how to generate token check
    // http://sdk.wialon.com/playground/demo/app_auth_token
	wialon.core.Session.getInstance().loginToken("8c1bd42eac5b62d2a012fb8db70bb727CFE0B15A5A7D99B7CD57C94F5BA25BEC2B458E23", "", // try to login
		function (code) { // login callback
			// if error code - print error message
			if (code) { msg(wialon.core.Errors.getErrorText(code)); return; }
			msg("Logged successfully");
            initMap();
            init(); // when login suceed then run init() function
	});
});
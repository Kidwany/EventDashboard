<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0h_0sd5Dj3UoCAoZc8a3iAH8_VGBXE8o&callback=initMap&libraries=&v=weekly"
        defer
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

{{--Firebase Tasks--}}
<!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
         https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-database.js"></script>

    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>


</head>
<body>

<script>
    "use strict";

    let map;
    let eventLat = {{$event->location->latitude}};
    let eventLong = {{$event->location->longitude}};
    function initMap() {
        var myLatLng = {lat: eventLat,
            lng: eventLong};
        map = new google.maps.Map(document.getElementById("map"), {
            center: myLatLng,
            zoom: 17,
            //mapTypeId: 'satellite'
        });


        // new google.maps.Marker({
        //     position: {
        //         lat:24.638068,
        //         lng:46.65314
        //     },
        //     title: 'Hello World!',
        //     icon: {
        //         path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
        //         strokeColor: "#006695",
        //         scale: 4
        //     },
        //     map:map
        // });
        // marker.setMap(map);
    }
    //firebase
    // Initialize Firebase
    var config = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        databaseURL: "{{ config('services.firebase.database_url') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}",
        measurementId: "{{ config('services.firebase.measurement_id') }}"
    };
    firebase.initializeApp(config);
    firebase.analytics();

    var database = firebase.database();

    var lastIndex = 0;
    let markers = [];
    // Get Data
    let eventId = {{$event->id}};
    let groupId = "Group_20";
    let dbfireref = "Tracking/Event_"+eventId+"/";
        firebase.database().ref(dbfireref).on('value', function (snapshot) {
        var value = snapshot.val();
            console.log("this snapshot",value);
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        $.each(value, function (index, value) {
            if (value) {
                $.each(value, function (key, subvalue) {
                    console.log("this value another",subvalue);
                    var userkey =  new google.maps.Marker({
                        position: {
                            lat:subvalue['lat'],
                            lng:subvalue['lang']
                        },
                        title: subvalue['name'],
                        // label: {
                        //     color: subvalue['color'],
                        //     fontWeight: 'bold',
                        //     text: subvalue['name'],
                        // },
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            strokeColor: subvalue['color'],
                            scale: 4
                        },
                        map:map
                    });
                    markers.push(userkey);
                    // google.maps.event.addListener(userkey, 'click', function() {
                    //     //$('#myModal').modal('show');
                    //     alert(key);
                    // });
                });

                console.log("this value",value);
                // google.maps.event.addListener(marker_1, 'click', function() {
                //     $('#myModal').modal('show');
                // });
                // index.setPosition({
                //     lat: value['lat'],
                //     lng: value['lang']
                // });
                //index.setMap(map);
            }

        });


    });
</script>

{{--{{$event}}--}}
<div id="map"></div>
</body>
</html>

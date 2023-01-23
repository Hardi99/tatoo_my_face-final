/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// loads the jquery package from node_modules
import $ from 'jquery';
import moment from 'moment';
import { FullCalendar } from '../components/fullcalendar/dist/fullcalendar';
import 'slick-carousel'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'



// Script Calendrier

$(document).ready(function() {
    $('[data-slider]').slick()
    console.log("jQuery is ready!");
    let salonId = document.getElementById("calendar").dataset.salonId;
    $('#calendar').fullCalendar({
        events: '/appointments/get-events/'+salonId,
        eventColor: '#3788d8',
        eventTextColor: 'white',
        locale: 'fr',
        minTime: "09:00:00",
        maxTime: "18:00:00",
        timeFormat: 'HH:mm',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        unselectAuto: true,
        select: function(start, end, allDay, jsEvent, view) {
            if (start < new Date()) {
                alert('Cette date est déja passée');
            }
            else {
                var startDate = start.format('YYYY-MM-DD');
                var startTime = start.format('HH:mm');
                
                // Calculate 30 minutes after start time
                var endTime = new Date(start);
                endTime.setMinutes(endTime.getMinutes() + 30);
                endTime = endTime.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'});
                
                $("#appointment_appointmentAt").val(startDate);
                $("#appointment_start").val(startTime);
                $("#appointment_end").val(endTime);                        
            }
        },
        error: function() {
            console.log("Une erreur est survenue lors de la récupération des données de rendez-vous");
        }
    });
});

// Script Recherche Adresse

$("#search_address").keyup(function(event) {
    // Stop la propagation par défaut
        event.preventDefault();
        event.stopPropagation();

    let adresse = $("#search_address").val();

    $.get(`https://api-adresse.data.gouv.fr/search`, {
        q: adresse,
        limit: 1,
        autocomplete: 1

    }, function (data, status, xhr) {
        let liste = "";
        $.each(data.features, function(i, obj) {
            console.log(obj.properties);
            // données phase 1 (obj.properties.label) & phase 2 : name, postcode, city
            // J'ajoute chaque élément dans une liste
            liste += '<li><a href="#" name="'+obj.properties.label+'" data-name="'+obj.properties.name+'" data-postcode="'+obj.properties.postcode+'" data-city="'+obj.properties.city+'">'+obj.properties.label+'</a></li>';
        });
        $('.adress-feedback ul').html(liste);

        // ToDo: Au clic du lien voulu, on envoie l'info en $_POST
        $('.adress-feedback ul> li').on("click","a", function(event) {
            // Stop la propagation par défaut
            event.preventDefault();
            event.stopPropagation();

            $("#search_address").val($(this).attr("data-name"));

            $('.adress-feedback ul').empty();
                
            // Création de l'objet XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Ouverture d'une requête GET vers l'API de géocodage de l'État
            xhr.open("GET", "https://api-adresse.data.gouv.fr/search/?q=" + encodeURIComponent(adresse));
            xhr.send();

            // Gestion de la réponse
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Récupération des éléments de formulaire pour la latitude et la longitude
                    var latitudeField = document.getElementById("lat");
                    var longitudeField = document.getElementById("lng");

                    let coord = response.features[0].geometry.coordinates;
                    var lon = coord[0];
                    var lat = coord[1];

                    // Affectation des valeurs de latitude et longitude aux champs de formulaire
                    latitudeField.value = lat;
                    longitudeField.value = lon;
                }};
        });

    }).error(function () {
        // alert( "error" );
    }).always(function () {
        // alert( "finished" );
    }, 'json');
});

// Script Recherche Adresse Admin

$("#salon_address").keyup(function(event) {
    // Stop la propagation par défaut
        event.preventDefault();
        event.stopPropagation();

    let rue = $("#salon_address").val();

    $.get(`https://api-adresse.data.gouv.fr/search`, {
        q: rue,
        limit: 1,
        autocomplete: 1

    }, function (data, status, xhr) {
        let liste = "";
        $.each(data.features, function(i, obj) {
            console.log(obj.properties);
            // données phase 1 (obj.properties.label) & phase 2 : name, postcode, city
            // J'ajoute chaque élément dans une liste
            liste += '<li><a href="#" name="'+obj.properties.label+'" data-name="'+obj.properties.name+'" data-postcode="'+obj.properties.postcode+'" data-city="'+obj.properties.city+'">'+obj.properties.label+'</a></li>';
        });
        $('.adress-feedback ul').html(liste);

        // ToDo: Au clic du lien voulu, on envoie l'info en $_POST
        $('.adress-feedback ul> li').on("click","a", function(event) {
            // Stop la propagation par défaut
            event.preventDefault();
            event.stopPropagation();

            $("#salon_address").val($(this).attr("data-name"));
            $("#salon_postal_code").val($(this).attr("data-postcode"));
            $("#salon_city").val($(this).attr("data-city"));

            $('.adress-feedback ul').empty();
                
            // Création de l'objet XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Ouverture d'une requête GET vers l'API de géocodage de l'État
            xhr.open("GET", "https://api-adresse.data.gouv.fr/search/?q=" + encodeURIComponent(rue));
            xhr.send();

            // Gestion de la réponse
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Récupération des éléments de formulaire pour la latitude et la longitude
                    var latitudeField = document.getElementById("salon_lat");
                    var longitudeField = document.getElementById("salon_lng");

                    let coord = response.features[0].geometry.coordinates;
                    var lon = coord[0];
                    var lat = coord[1];

                    // Affectation des valeurs de latitude et longitude aux champs de formulaire
                    latitudeField.value = lat;
                    longitudeField.value = lon;
                }};
        });

    }).error(function () {
        // alert( "error" );
    }).always(function () {
        // alert( "finished" );
    }, 'json');
});

// Script Carte

let carte = document.querySelector('#map')

mapboxgl.accessToken = 'pk.eyJ1IjoiaGFyZGk5OSIsImEiOiJjbGJ4ZG5pcWQwMDRpM3ZueGNxYXVvbnFvIn0.-BF104Lza9qZQf7HdYFlyQ';
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [carte.dataset.lng, carte.dataset.lat],
    zoom: 15
});

// Création d'un marqueur à un emplacement spécifié
new mapboxgl.Marker({
color: 'orange'
}).setLngLat([carte.dataset.lng, carte.dataset.lat]).addTo(map); 

// Script suppression des éléments
document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        fetch(a.getAttribute('href'), {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({'_token': a.dataset.token})
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
            a.parentNode.parentNode.removeChild(a.parentNode)
            } else {
            alert(data.error)
            }
        })
        .catch(e => alert(e))
    })
});
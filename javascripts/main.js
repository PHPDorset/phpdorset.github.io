/* global $,document */
$( document ).ready(function () {

    "use strict";

    $(function () {

        var formatTime = function (time) {
          var time_string = '';
          var minutes = time.getMinutes();
          var hours = time.getHours();
          var ampm = 'am';
          if( minutes < 10 ){
            minutes = '0' + minutes;
          }
          if( hours === 0 ){
            hours = 12;
          } else if ( hours >= 12 ){
            ampm = 'pm';
            if( hours !== 12){
              hours = hours - 12;
            }
          }
          return time_string += hours + ':' + minutes + ampm;
        };

        $.ajax({
            url: 'https://developer.eventbrite.com/json/organizer_list_events',
            dataType: 'jsonp',
            type: 'GET',
            data: { app_key: 'FWSQJTPIYNRWXF45K4', id: '5284449005', only_display: 'start_date,status,title,description,end_date,tickets,venue,url' },
            success: function (result) {

                if (result.contents.events === undefined) {
                    return;
                }

                var latestEvent = result.contents.events.pop().event,
                    startDate = new Date(latestEvent.start_date),
                    endDate = new Date(latestEvent.end_date),
                    venue = latestEvent.venue.name
                        + ', ' + latestEvent.venue.address
                        + ', ' + latestEvent.venue.city
                        + ', ' + latestEvent.venue.country,
                    message = 'Next meetup ' + startDate.toDateString() 
                                + ' from ' + formatTime(startDate) 
                                + ' to ' + formatTime(endDate) 
                                + ' @ ' + venue,
                    eventUrl = latestEvent.url;

                $('h2#next-event')
                .text(message)
                .css({
                    opacity: 0,
                    visibility: "visible"
                })
                .animate({
                    opacity: 1
                }, 400)
                .click(function (e) {
                    e.preventDefault();
                    window.open(eventUrl, '_blank');
                });
            },
            beforeSend: function(xhrObj) {
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Accept","application/json");
            }
          });
    }(jQuery));
});

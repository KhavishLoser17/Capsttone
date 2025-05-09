// Schedule Calendar

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('schedule');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridDay' 
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            axios.get('/schedule') 
                .then(function(response) {
                    successCallback(response.data);
                })
                .catch(function(error) {
                    console.error('Error fetching events:', error);
                });
        },
        dateClick: function(info) {
            calendar.changeView('timeGridDay', info.dateStr);
        },
        eventClick: function(info) {
            // Display event details in an alert
            alert('Event: ' + info.event.title + '\nDescription: ' + info.event.extendedProps.description);
        },
        slotMinTime: '08:00:00', 
        slotMaxTime: '18:00:00', 
    });
    calendar.render();
  });
  
  // Timesheet Calendar
  
  
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('timesheet');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridDay' 
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            axios.get('/timesheet') 
                .then(function(response) {
                    successCallback(response.data);
                })
                .catch(function(error) {
                    console.error('Error fetching events:', error);
                });
        },
        dateClick: function(info) {
            calendar.changeView('timeGridDay', info.dateStr);
        },
        eventClick: function(info) {
            // Display event details in an alert
            alert('Status: ' 
                    + 
                    info.event.title 
                    + 
                    '\nStart: ' 
                    + 
                    info.event.start
                    + 
                    '\nEnd: ' 
                    + 
                    info.event.end
                );
        },
        slotMinTime: '08:00:00', 
        slotMaxTime: '18:00:00', 
    });
    calendar.render();
  });
  
  
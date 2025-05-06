let calendar;
const Calendar = FullCalendar.Calendar;
let events = [];

// Convert user input into JSON-safe format
function safeJSON(value) {
    return JSON.stringify({ description: value }).replace(/\\n/g, "\\n"); // Ensure newlines are properly escaped
}

$(function () {
    if (scheds) {
        Object.keys(scheds).forEach((k) => {
            const row = scheds[k];
            events.push({
                id: row.id,
                title: row.title,
                start: row.start_datetime,
                end: row.end_datetime,
            });
        });
    }

    calendar = new Calendar(document.getElementById("calendar"), {
        headerToolbar: {
            left: "prev,next today",
            right: "dayGridMonth,dayGridWeek,list",
            center: "title",
        },
        selectable: true,
        themeSystem: "bootstrap",
        events: events,
        eventClick: function(info) {
            const _details = $("#event-details-modal");
            const id = info.event.id;
        
            if (scheds[id]) {
                _details.find("#title").text(scheds[id].title);
                
                // Ensure newlines are displayed correctly
                _details.find("#description").html(scheds[id].description.replace(/\n/g, "<br>"));  
        
                _details.find("#start").text(scheds[id].sdate);
                _details.find("#end").text(scheds[id].edate);
                _details.find("#edit,#delete").attr("data-id", id);
                _details.modal("show");
            } else {
                alert("Event is undefined");
            }
        },
        editable: true,
    });

    calendar.render();

    // Reset form listener
    $("#schedule-form").on("reset", function () {
        $(this).find("input:hidden").val("");
        $(this).find("input:visible").first().focus();
    });
    
    $("#edit").click(function () {
        const id = $(this).attr("data-id");
    
        if (scheds[id]) {
            const _form = $("#schedule-form");
    
            _form.find('[name="id"]').val(id);
            _form.find('[name="title"]').val(scheds[id].title);
            
            // Use `.val()` for `<textarea>`, ensuring newlines persist
            _form.find('[name="description"]').val(scheds[id].description.replace(/<br\s*\/?>/g, "\n"));  
    
            _form.find('[name="start_datetime"]').val(scheds[id].start_datetime.replace(" ", "T"));
            _form.find('[name="end_datetime"]').val(scheds[id].end_datetime.replace(" ", "T"));
    
            $("#event-details-modal").modal("hide");
            _form.find('[name="title"]').focus();
        } else {
            alert("Event is undefined");
        }
    });

    // Delete Button
    $("#delete").click(function () {
        const id = $(this).attr("data-id");

        if (scheds[id]) {
            const _conf = confirm("Are you sure you want to delete this scheduled event?");
            if (_conf) {
                location.href = `./delete_schedule.php?id=${id}`;
            }
        } else {
            alert("Event is undefined");
        }
    });
});
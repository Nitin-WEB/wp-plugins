jQuery(document).ready(function($){
    function fetchTracker() {
        let formData = {
            action: "ltt_tracker",
            transport_type: $("#ltt-form [name='transport_type']").val(),
            transport_number: $("#ltt-form [name='transport_number']").val()
        };
        $("#ltt-result").html("Loading...");

        $.post(lttAjax.ajax_url, formData, function(response){
            if(response.success){
                let html = "<table class='ltt-table'><thead><tr>";
                html += "<th>Field</th><th>Value</th></tr></thead><tbody>";

                // Dynamically generate table rows
                for(let key in response.data){
                    html += "<tr><td>"+key+"</td><td>"+JSON.stringify(response.data[key])+"</td></tr>";
                }
                html += "</tbody></table>";
                $("#ltt-result").html(html);
            } else {
                $("#ltt-result").html("Error: "+response.data);
            }
        });
    }

    // Initial fetch
    $("#ltt-form").on("submit", function(e){
        e.preventDefault();
        fetchTracker();
        clearInterval(window.lttInterval);
        window.lttInterval = setInterval(fetchTracker, lttAjax.refresh_interval);
    });
});

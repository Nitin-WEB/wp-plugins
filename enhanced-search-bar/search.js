jQuery(document).ready(function($){
    function performSearch(){
        let data = {
            action: 'esb_search',
            query: $('#esb-query').val(),
            post_type: $('#esb-post-type').val(),
            category: $('#esb-category').val()
        };
        $('#esb-results').html('Searching...');
        $.post(esbAjax.ajax_url, data, function(res){
            if(res.success){
                let html = '<ul>';
                if(res.data.length === 0){
                    html += '<li>No results found</li>';
                } else {
                    res.data.forEach(function(item){
                        html += `<li><a href="${item.link}">${item.title}</a><p>${item.excerpt}</p></li>`;
                    });
                }
                html += '</ul>';
                $('#esb-results').html(html);
            } else {
                $('#esb-results').html('Error fetching results');
            }
        });
    }

    $('#esb-query').on('keyup', function(e){
        if(e.keyCode != 13) performSearch();
    });
    $('#esb-post-type, #esb-category').on('change', performSearch);

    // Voice recognition (if supported)
    $('#esb-voice').on('click', function(){
        if(!('webkitSpeechRecognition' in window)) return alert('Voice not supported');
        let recognition = new webkitSpeechRecognition();
        recognition.lang = 'en-US';
        recognition.start();
        recognition.onresult = function(event){
            let transcript = event.results[0][0].transcript;
            $('#esb-query').val(transcript);
            performSearch();
        }
    });
});

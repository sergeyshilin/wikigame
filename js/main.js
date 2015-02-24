function loadContent(page) {
    $.ajax({
        dataType:'json',
        type:'POST',
        headers: { 'Api-User-Agent': 'Example/1.0' },
        url: 'http://en.wikipedia.org/w/api.php?format=jsonfm&action=query&prop=extracts&exintro=&explaintext=&titles=' + page,
        success: function(result) {
            console.log(result);
        },
        error: function() {
            /**
             * nothing to do
             */
        }
    });
}
var hashes = [];

$(document).ready(function() {
	$(function () {
	    $('input[type="checkbox"]').change(function (e) {
	       if(this.className == 'all')
	       {
	           $('.check').prop('checked', this.checked);
	       }
	        else
	        {
	            $('.all').prop('checked', $('.check:checked').length == $('.check').length);
	        }
	    });
	});
});

function saveAllInCat(cat) {
	var _verify = $('.all').prop('checked') ? 1 : 0;

	$.ajax({
        url: "actions/updateVerification.php",
        data: {verify: _verify, category: cat},
        type: 'POST',
        success: function(data) {
        	location.reload();
        },
        error: function() {
            /**
             * nothing to do
             */
        }
    });
}

function deleteWay(hash) {
	$.ajax({
        url: "actions/deleteWay.php",
        data: {hash: hash},
        type: 'POST',
        success: function(data) {
        	$(document.getElementById(hash)).remove();
        },
        error: function() {
            /**
             * nothing to do
             */
        }
    });
}
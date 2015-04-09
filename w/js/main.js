var hashes = [];

$(document).ready(function() {
    enableListeners();
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

function enableListeners() {
    listenLikes();
    listenDislikes();
}

function listenLikes() {
    $(".like").click(function() {
        $fa = $(this).children(".fa");
        if($fa.hasClass("fa-thumbs-o-up"))
            $.ajax({
                url: "/actions/like.php",
                data: 
                    {
                        like: 1
                    },
                type: 'POST',
                success: function(data) {
                    if($fa.hasClass("fa-thumbs-o-up")) {
                        $fa.removeClass("fa-thumbs-o-up");
                        $fa.addClass("fa-thumbs-up");
                        $(".dislike").children(".fa").removeClass("fa-thumbs-down");
                        $(".dislike").children(".fa").addClass("fa-thumbs-o-down");
                    }
                },
                error: function() {
                }
            });
    });
}

function listenDislikes() {
    $(".dislike").click(function() {
        $fa = $(this).children(".fa");
        if($fa.hasClass("fa-thumbs-o-down"))
            $.ajax({
                url: "/actions/like.php",
                data: 
                    {
                        like: -1
                    },
                type: 'POST',
                success: function(data) {
                    if($fa.hasClass("fa-thumbs-o-down")) {
                        $fa.removeClass("fa-thumbs-o-down");
                        $fa.addClass("fa-thumbs-down");
                        $(".like").children(".fa").removeClass("fa-thumbs-up");
                        $(".like").children(".fa").addClass("fa-thumbs-o-up");
                    }
                },
                error: function() {
                }
            });
    });
}

function loadLike() {
    $.ajax({
        url: "/actions/loadlike.php",
        data: {post: 1},
        type: 'POST',
        success: function(data) {
            if(data == 1) {
                $fa = $(".like").children(".fa");
                $fa.removeClass("fa-thumbs-o-up");
                $fa.addClass("fa-thumbs-up");
            } else if(data == -1) {
                $fa = $(".dislike").children(".fa");
                $fa.removeClass("fa-thumbs-o-down");
                $fa.addClass("fa-thumbs-down");
            }
        },
        error: function() {
            /**
             * nothing to do
             */
        }
    });
}

function saveAllInCat(cat) {
	var _verify = $('.all').prop('checked') ? 1 : 0;

	$.ajax({
        url: "/actions/updateVerification.php",
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
        url: "/actions/deleteWay.php",
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
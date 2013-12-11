// key events
var ENTER_KEY = 13;
var COMMA_KEY = 188;

$(document).ready(function($){
	$('#distritos').change(function(){
				var con = $('#concelhos');
				con.empty();
				con.append('<option value="">Escolha um concelho</option>');
				return $.ajax({
				  type: "POST",
				  url: "getconcelhos",
				  data: {did: $("#distritos").val()},
				  success: function(data) {
					for (var i=0;i<data.length;i++)
					{
							con.append('<option value="' + data[i][0] + '">' + data[i][1] + '</option>');
					}
					return true;
				  },
				  error: function(response) {
					return alert("ERROR:" + response.responseText);
				  }
				});
	});
});

// pageCreateFixRequestJS();

$(document).ready(function(){

	$('#buttonLogin').click(function(){
		$('#signInModal').ready(function(){
			$('#buttonForgotPass').click(function(){
				console.log("FAIL");
				$('#signInModal').modal('hide');
			});
		});
    });

    // fix request photo lightbox
    $(".fancybox").fancybox();

    // open fix request if click on index page
    $(".fixrequests .panel").each(function(){
        $(this).click(function(){
            var url = $(this).find("h4 a").attr('href');
            window.location.href = url;
        });
    });
});


// to remove the 300ms tap delay on smartphones
window.addEventListener('load', function() {
    new FastClick(document.body);
}, false);


// TODO validate
function markFixerAsFavorite(star) {
star = $(star);
    if(star.hasClass('favorite-fixer1')) {
        var id = $(".promotionpage-details").attr('data-promotionpage-id');

        star.removeClass('favorite-fixer1').addClass('favorite-fixer2');
        $.ajax({
            url: "../../users/favorite/" + id,
            context: document
        });
    }
    else {
        star.removeClass('favorite-fixer2').addClass('favorite-fixer1');

    }
}


// TODO not functional for now
function pageCreateFixRequestJS() {
    var tagsInput = $('.bootstrap-tagsinput > input');
    tagsInput.tagsinput({
        maxTags: 5,
        confirmKeys: [ENTER_KEY, COMMA_KEY],
    });
}

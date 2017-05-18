$(document).ready(function () {

	$(document).ready(function () {
		$("time.timeago").timeago();
	});

	// http://localhost:8888/pub-quiz/api.php?type=getLeaderboards

	var theUrl = document.location.href.match(/[^\/]+$/)[0];

	if (theUrl.indexOf("leaderboards.php") >= 0) {
		loadLeaderboards("api.php?type=getLeaderboards");
	}


});


function loadLeaderboards(url) {
	$.ajax({
		url: url,
		success: function (data) {
			handleLeaderboards(data);
		},
		error: function (jqXHR, exception) {
			var msg = '';
			if (jqXHR.status === 0) {
				msg = 'Not connect.\n Verify Network.';
			} else if (jqXHR.status == 404) {
				msg = 'Requested page not found. [404]';
			} else if (jqXHR.status == 500) {
				msg = 'Internal Server Error [500].';
			} else if (exception === 'parsererror') {
				msg = 'Requested JSON parse failed.';
			} else if (exception === 'timeout') {
				msg = 'Time out error.';
			} else if (exception === 'abort') {
				msg = 'Ajax request aborted.';
			} else {
				msg = 'Uncaught Error.\n' + jqXHR.responseText;
			}

			$("#lb-loader").html("Unable to load the leaderboards - " + msg);
			console.error(msg);
		}
	});
}

function handleLeaderboards(data) {
	console.log(data.meta.success);

	var leaders = data.meta.success;
	categories = swap(categories);

	/**
	 * --
	 * @param {int} key
	 * @param {object} leader
	 * @param {int} leader.lb_category
	 * @param {timestamp} leader.lb_date
	 * @param {int} leader.lb_score
	 * @param {int} leader.rank
	 * @param {string} leader.user_email
	 * @param {string} leader.user_name
	 * @param {string} leader.user_picture
	 * @param {string} leader.user_social_type
	 */
	$.each(leaders, function (key, leader) {

		var icon = "";
		var rankIcon = "";

		if (leader.user_social_type == "facebook") {
			icon = '<i class="fab fab-facebook"></i>';
		} else if (leader.user_social_type == "twitter") {
			icon = '<i class="fab fab-twitter"></i>';
		} else if (leader.user_social_type == "google") {
			icon = '<i class="fab fab-google"></i>';
		} else if (leader.user_social_type == "instagram") {
			icon = '<i class="fab fab-instagram"></i>';
		} else if (leader.user_social_type == "tumblr") {
			icon = '<i class="fab fab-tumblr"></i>';
		} else if (leader.user_social_type == "reddit") {
			icon = '<i class="fab fab-reddit"></i>';
		}

		if (leader.rank == 1) {
			rankIcon = '<i class="gold btl bt-trophy"></i>';
		} else if (leader.rank == 2) {
			rankIcon = '<i class="silver btl bt-trophy"></i>';
		}
		if (leader.rank == 3) {
			rankIcon = '<i class="bronze btl bt-trophy"></i>';
		}

		// TODO: fix timestamp -6 hours issue
		$("tbody").append("<tr class='leader' style='display: none'>" +
			"<td>" + leader.rank + " " + rankIcon + "</td>" +
			"<td><img src='" + leader.user_picture + "'>" + leader.user_name + " " + icon + "</td>" +
			"<td>" + categories[leader.lb_category] + "</td>" +
			"<td>" + $.timeago(leader.lb_date) + "</td>" +
			"<td class='score'>" + leader.lb_score + "</td>" +
			"</tr>");

	});


	$("#lb-loader").fadeOut(800);
	$("#first-tr").fadeOut(800);
	$(".leader").delay(800).fadeIn(800);

}

function swap(json) {
	var ret = {};
	for (var key in json) {
		ret[json[key]] = key;
	}
	return ret;
}
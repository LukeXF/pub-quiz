$(document).ready(function () {
	//console.log($.urlParam("category"));

	var category = $.urlParam("category");
	var difficulty = $.urlParam("difficulty");
	var type = $.urlParam("type");

	var categoryUrl = "";
	var difficultyUrl = "";
	var typeUrl = "";

	if (category != null) {
		categoryUrl = "&category=" + category;
	}

	if (difficulty != null) {
		difficultyUrl = "&difficulty=" + difficulty
	}

	if (type != null) {
		typeUrl = "&type=" + type
	}

	var fullUrl = "https://opentdb.com/api.php?amount=20" + categoryUrl + difficultyUrl + typeUrl;
	console.log(fullUrl);
	getQuizData(fullUrl);


});


function getQuizData(fullUrl) {
	$.ajax({
		url: fullUrl,
		success: function (data) {
			handleData(data);
		}
	});
}

/**
 * --
 * @param {object} data -
 * @param {object} data.results -
 */
function handleData(data) {
	//console.log(data);
	//console.log(data.results);

	var currentQuestion = 0;
	var chosenAnswers = [];

	/**
	 * --
	 * @param {int} key -
	 * @param {object} val -
	 * @param {object} val.incorrect_answers -
	 * @param {object} val.correct_answer -
	 * @param {string} val.question -
	 */
	$.each(data.results, function (key, val) {

		$("#tile-question-" + key + " .question-title").html(val.question);
		$("#tile-result-" + key + " .question-title").html(val.question);


		//console.log(val.incorrect_answers, val.correct_answer);
		var answers = $.merge(val.incorrect_answers, [val.correct_answer]);

		// place correct answer into the result section
		$("#result-correct-answer-" + key + " .answer-title").html(val.correct_answer);

		$.each(answers, function (answerKey, answer) {
			$("#tile-answers-" + key).append(
				"<div class='answer-tile'>" +
				"<h2 class='answer-answer'>Answer " + String.fromCharCode(65 + answerKey) + "</h5>" +
				"<h4 class='answer-title'>" + answer + "</h3>" +
				"</div>"
			);
			//console.log($(".tile-answers#" + key).html());
			//console.log(key);
		});
		//console.log("---");
	});

	$("#loader").fadeOut(800);
	$("#tile-question-0").delay(800).fadeIn(800);
	$(".progress").delay(800).fadeIn(800);

	setTimeout(function () {
		$('.progress .progress-bar').css("width",
			function () {
				return $(this).attr("aria-valuenow") + "%";
			}
		);
	}, 1600);

	var time_out;
	var forceMoveOn;

	$(".answer-title").click(function () {

		clearTimeout(time_out);
		time_out = setTimeout(nextQuestion(this), 800);

		if (currentQuestion >= 2) {
			results();
		}
	});


	forceMoveOn = setTimeout(function () {
		nextQuestion(null)
	}, 20000 + 1600);

	function nextQuestion(thing) {
		chosenAnswers.push($(thing).html());
		//console.log(chosenAnswers);

		var currentQuestionTile = "#tile-question-" + currentQuestion;
		var progress = ".progress";
		var progressBar = ".progress .progress-bar";

		$(currentQuestionTile).fadeOut(800);
		currentQuestion++;
		currentQuestionTile = "#tile-question-" + currentQuestion;


		$(progress).fadeOut(800);

		setTimeout(function () {
			$(progressBar).removeClass("progress-bar-animation");
			$(progressBar).css("width", "100%");
			$(progressBar).addClass("progress-bar-animation");

			setTimeout(function () {
				$(".progress .progress-bar").css("width", "0%");
			}, 1600);
		}, 800);

		$(progress).delay(800).fadeIn(800);

		$(currentQuestionTile).delay(800).fadeIn(800);
		clearTimeout(forceMoveOn);
		forceMoveOn = setTimeout(function () {
			nextQuestion(null)
		}, 20000 + 2400);
	}

	function results() {
		console.log("FINISHED");
		clearTimeout(forceMoveOn);
		$(".progress").fadeOut(800);
		$(".tile-question").fadeOut(800);
		$(".tile-results").delay(800).fadeIn(800);
		$(".tile-overview").delay(800).fadeIn(800);


		loadLeaderboards("api.php?type=getLeaderboards");
		$("#leaderboards-results").delay(800).fadeIn(800);

		$.each(chosenAnswers, function (key, answer) {

			var correctAnswer = $("#result-correct-answer-" + key + " .answer-title").html();

			if (correctAnswer == answer) {
				$("#tile-result-" + key).addClass("tile-green");
			} else {
				$("#tile-result-" + key).addClass("tile-red");
			}

			$("#result-your-answer-" + key + " .answer-title").html(answer);
		});

		var amountRight = $(".tile-green").length;
		$("#tile-final-amount-right h2").html(amountRight + "/20");


		var difficulty = $.urlParam("difficulty");

		var multiplier = 1;
		if (difficulty == "easy") {
			multiplier = 0.5;
		} else if (difficulty == "hard") {
			multiplier = 1.5;
		}

		var score = amountRight * multiplier * 150;
		$("#tile-final-score h2").html(score);
		sendResults($.urlParam("category"), score);

	}

	function sendResults(category, score) {

		$.ajax({
			type: "POST",
			url: "api.php",
			// The key needs to match your method's input parameter (case-sensitive).
			data: {"type": "addScore", "category": category, "score": score},
			dataType: "json",
			success: function (data) {
				console.log(data);
			},
			error: function (errMsg) {
				console.log(errMsg);
			}


		});
	}
}


$.urlParam = function (name) {
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	if (results == null) {
		return null;
	}
	else {
		return results[1] || 0;
	}
};

$( document ).ready(function() {
	console.log( "ready!" );

	var category = "any";
	var difficulty = "medium";
	var type = "multiple";

	$(".box-category").click(function () {
		category = this.id;
		$(".box-category").removeClass("selected");
		$(this).addClass("selected");
		$("#final-category span").html($(this).html());
	});
	$(".box-difficulty").click(function () {
		difficulty = this.id;
		$(".box-difficulty").removeClass("selected");
		$(this).addClass("selected");
		$("#final-difficulty span").html($(this).html());
	});
	$(".box-type").click(function () {
		type = this.id;
		$(".box-type").removeClass("selected");
		$(this).addClass("selected");
		$("#final-type span").html($(this).html());
	});

	$("#begin").click(function () {
		console.log("https://opentdb.com/api.php?amount=10&category=" + category + "&difficulty=" + difficulty + "&type=" + type);
	});


});
var selected = 0;
var prevImg;

// Muudab valitud pildi borderi paksuks ja punaseks. Eelnevalt valitud pildi borderi muudab tagasi defaulti.
$('#images').on("click", "img", function (e) {
	e.preventDefault();
	
	$(this).css("border", "solid 3px red");
	
	if (selected == 1 && e.target.id != prevImg) {
		$("#"+prevImg).css("border", "solid 1px black");
	} else if (selected == 0) {
		// Seni kuni pole ühtegi pilti valitud, ei saa postitada.
		$("#btn_post").removeAttr("disabled");
	}
	
	prevImg = e.target.id;
	selected = 1;
	// Paneb valitud pildi laePost formis hidden inputi väärtuseks, et saaks andmebaasi edastada
	$("#pic").val(e.target.src);
});
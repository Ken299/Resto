var selected = 0;
var prevImg;

// Changes the selected picture's button's border thick and red. The previously selected picture's border is changed to a thin black again.
$('#images').on("click", "img", function (e) {
	e.preventDefault();
	
	$(this).css("border", "solid 3px red");
	
	if (selected == 1 && e.target.id != prevImg) {
		$("#"+prevImg).css("border", "solid 1px black");
	} else if (selected == 0) {
		// Until no pictures has been selected, the post can't be submitted
		validation(1);
	}
	
	prevImg = e.target.id;
	selected = 1;
	// Puts the source of the selected picture as the value of a hidden input for form submission
	$("#pic").val(e.target.src);
});
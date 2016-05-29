
function insertbbcodecontent(bbcode) {
	if (document.formnews.content.createTextRange && document.formnews.content.caretPos) {
		var caretPos = document.formnews.content.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? bbcode + ' ' : bbcode;
		document.formnews.content.focus();
	} else {
		document.formnews.content.value+=bbcode;
		document.formnews.content.focus();
	}
}
		
function insertbbcodearticle(bbcode) {
	if (document.form.article.createTextRange && document.form.article.caretPos) {
		var caretPos = document.form.article.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? bbcode + ' ' : bbcode;
		document.form.article.focus();
	} else {
		document.form.article.value+=bbcode;
		document.form.article.focus();
	}
}
		
function openpopup(){
	var popurl="comments.php?news_id=$news_id"
	winpops=window.open(popurl,"","width=400,height=500,status,scrollbars,resizable,")
}
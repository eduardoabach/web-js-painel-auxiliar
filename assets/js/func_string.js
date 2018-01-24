
// generate a random 20 character string 
function get_random_caracteres(intQtdCaract){
	if(!(intQtdCaract > 0))
		return false;

	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz",
	  rnum, str;

	for (var i = 0; i < 20; i++) {
		rnum = Math.floor(Math.random() * 61);
		str += chars.substring(rnum, rnum + 1);
	}
	return str;
}

// only for-loop declaration with concatenation 
function string_reverse(s) {
	//str.split("").reverse().join(""); // é possível fazer assim, mas é muito menos eficiente em processamento
	for (var i = s.length - 1, o = ''; i >= 0; o += s[i--]) { }
	return o;
}

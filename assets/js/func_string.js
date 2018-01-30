
// Gerar um texto random
function get_random_caracteres(intQtdCaract, dicionario){
	var rnum = '';
	var str = '';

	if(!(intQtdCaract > 0))
		return false;

	if(dicionario == undefined || dicionario == '')
		dicionario = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
		
	for (var i = 0; i < 20; i++) {
		rnum = Math.floor(Math.random() * 61);
		str += dicionario.substring(rnum, rnum + 1);
	}
	return str;
}

// Embaralhar texto
function string_shuffle(str) {
    var a = str.split(""),
        n = a.length;

    for(var i = n - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var tmp = a[i];
        a[i] = a[j];
        a[j] = tmp;
    }
    return a.join("");
}

// Inverter ordem do texto
function string_reverse(s) {
	//str.split("").reverse().join(""); // é possível fazer assim, mas é muito menos eficiente em processamento
	for (var i = s.length - 1, o = ''; i >= 0; o += s[i--]) { }
	return o;
}

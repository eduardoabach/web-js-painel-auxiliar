function RelogioTool(){
	var hora = 0;
	var minuto = 0;
	var segundo = 0;

	this.Init = function(vHora, vMinuto, vSegundo){
		this.hora = vHora;
		this.minuto = vMinuto;
		this.segundo = vSegundo;
		this.CicloTempoUp();
	}

	this.CicloTempoUp = function(){
		var self = this;
		setTimeout( function request(){
			self.TempoUp();
			self.CicloTempoUp(); // chama ele novamente para refazer processo, criando loop
		}, 1000); //milisegundos
	}
	
	this.TempoUp = function(){
		this.segundo += 1;

		if(this.segundo >= 60){
			this.segundo = 0;
			this.minuto++;
		}

		if(this.minuto >= 60){
			this.minuto = 0;
			this.hora++;
		}

		if(this.hora >= 24){
			this.hora = 0;
		}
	}

}
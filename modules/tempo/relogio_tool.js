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

	this.CicloTempoUp = function(tempFim){
		var self = this;
		var dtAtual = new Date();
		var tempIni = dtAtual.getTime();

		var tempoCiclo = 1000;
		if(tempFim != undefined){
			tempoCiclo -= tempIni-tempFim;
		}

		self.TempoUp();
		setTimeout( function request(){	
			self.CicloTempoUp(tempIni+tempoCiclo); // chama ele novamente para refazer processo, criando loop
		}, tempoCiclo); //milisegundos
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
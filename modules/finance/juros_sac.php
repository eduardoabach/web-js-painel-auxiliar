<div class="row">
	<div class="col-lg-12">
		<?php
		function numeroBR($numero){
			return number_format($numero,2,',','.');
		}

                //config
                $inflacaoMediaAno = 7; //%
                
                $valorFinanciamento = 144000;
                $aluguelAtual = 880;
                $meses = 360;
                $jurosAoAno = 9.5;
                
                // sys
                
                $inflacaoMediaMes = ($inflacaoMediaAno / 12) / 100;
                $totalAluguel = 0;
                
                $valorFaltante = $valorFinanciamento;
                $jurosAoMes = ($jurosAoAno / 12) / 100;
                $amortizacao = $valorFinanciamento / $meses;
                $totalFinal = 0;
                
                $anoRef = date('Y');
                $mesRef = date('m');
                
                for($i = 1; $i <= $meses; $i++){
                        $parcela = $amortizacao + ($jurosAoMes * $valorFaltante);
                        $totalFinal += $parcela;
                        $valorFaltante -= $amortizacao;
                        
                        $aluguelAtual += $aluguelAtual * $inflacaoMediaMes;
                        $totalAluguel += $aluguelAtual;
                        
                        if($mesRef == 12 || $i == 1){
                                echo "<br><b>#$mesRef/$anoRef n°$i</b>";
                                echo "<br>Parcela Financiamento: R$ ".numeroBR($parcela)." / total: R$ ".numeroBR($totalFinal);
                                echo "<br>Aluguel: R$ ".numeroBR($aluguelAtual)." / total: R$ ".numeroBR($totalAluguel);
                        }
                        
                        if($mesRef == 12){
                                $mesRef = 1;
                                $anoRef++;
                        } else {
                                $mesRef++;
                        }
                }
                
                $difTotaleFinanciado = $totalFinal - $valorFinanciamento;     
                $percentDifTotaleFinanciado = ($difTotaleFinanciado / $valorFinanciamento) * 100;
                $parcelaMedia = $totalFinal / $meses;
                
                $aluguelMedio = $totalAluguel / $meses;
                
                echo "<br><br>Total financiado: R$ ".numeroBR($valorFinanciamento);
                echo "<br>Total pago: R$ ".numeroBR($totalFinal);
                echo "<br>Juros sobre financiamento: R$ ".numeroBR($difTotaleFinanciado).", (+ ".number_format($percentDifTotaleFinanciado,1,',','')."%)";
                echo "<br>Parcela Média: R$ ".numeroBR($parcelaMedia);
		echo "<br>Amortização por parcela: R$ ".numeroBR($amortizacao);
                
                echo "<br><br>Total aluguel: R$ ".numeroBR($totalAluguel);
                echo "<br>Aluguel Médio: R$ ".numeroBR($aluguelMedio);
		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
	    <input class="form-control" id="cript-text" placeholder="Texto">
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <button type="button" class="btn btn-info" id="cript-act-e">Encode 64</button> 
	    <button type="button" class="btn btn-info" id="cript-act-d">Decode 64</button> 
    </div>
</div>




<form id="form-file-reader" method="POST" class="form-horizontal" action="<?=site_url('file_reader/read') ?>" target="iframe-file-read" enctype="multipart/form-data" >
    <input type="hidden" name="sessionToken" value="<?php echo set_val($sessionToken); ?>">
    <div class="control-group">
        <label class="span3 control-label-span3" for="arquivo">Arquivo de Origem</label>
        <div class="controls">
                <input type="file" tabindex="6" name='fg_sisobi[arquivo]' class="input-large" id="arquivo"/>
        </div>
    </div>
    <div class="form-buttons-box">
        <!-- Button -->
        <div>
            <!-- Button -->
            <button class="btn btn-success ver-layout pull-right" style="margin-left: 10px" type="submit">Ver Layout</button>
            <button class="btn btn-success salvar pull-right" type="submit" tabindex="11">Importar</button>
        </div>
    </div>
    <br>
    <div class="panel panel-default" style="margin-top: -24px">
            <!--<div class="panel-heading">Status da importação</div>-->
            <div class="panel-body no-padding">
                    <iframe id="iframe-file-read" name="iframe-file-read" width="100%" height="120px" frameborder="0">
                    </iframe>
            </div>
    </div>
</form>
<div class="row-fluid cadastrosMesmaMatricula show-result" style="display: none">
    <div class="span12">
        <h4>Erros Encontrados</h4>
        <table class="table table-bordered table-striped table-header table-hover" id="tabela-geral-assentamentos_tce">
            <thead>
                <tr>
                    <th class="text-left" width="130">Número da Linha</th>
                    <th class="text-left">Conteúdo da Linha</th>
                </tr>
            </thead>
            <tbody class="recebeMatricula"></tbody>
        </table>
    </div>
</div>

<?php defined('_JEXEC') or die;?>
<div class="row">
  <section class="col-lg-12">
    <div class="box box-success">
      <div class="box-header">
        <i class="fa fa-th"></i>
		<!-- Título de la vista -->
        <h3 class="box-title">Validación</h3>
		
        <!-- Algunos botones si son necesarios -->        
      </div>
      <div class="box-body">
        <? if(!$_POST){?>
            <form method="post" enctype="multipart/form-data" name="form" id="form">
              <div class="box-body">
              	<div class="form-group">
                  <label for="categoria" class="col-sm-3 control-label">
                    Texto
                    <em class="fa fa-asterisk text-red"></em>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" name="texto" id="texto" class="form-control validate[required]">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">
                    <em class="fa fa-save"></em>
                    Verificar texto
                </button>
              </div>
            </form>
            <? 
			}else{
				$val = validaTXT();
				if($val == 1)
					echo 'El texto ya esta siendo utilizado';
					else
					echo 'El texto esta disponible';
					?>
				<p>
					<a class="btn btn-info" href="index.php?option=com_erp&view=erp&layout=valida">
						<em class="fa fa-arrow-left"></em>
						Volver
					</a>
				</p>
				<?
                }?>
      </div>
    </div>
  </section>
</div>
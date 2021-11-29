// JavaScript Document
function superUsuario(){
	if(jQuery("#su_1").is(':checked'))  
        jQuery('.extensiones').slideUp();
        else
		jQuery('.extensiones').slideDown();
	}
function intMonto(evt){
	var key = evt.which || event.keyCode; // Código de tecla. 
	if(key == 188)
		alert('hola')
	if ((key < 48 || key > 57) && key != 8 && (key == 188 || key != 110)){ // Si no es número o retroceso
		if (evt.preventDefault) {
			evt.preventDefault();
		} else {
			event.returnValue = false;
		}
	}
}
jQuery(document).on('ready', function(){
    //boton del calendario
    var limite=4;
    /*agregando Correos*/
    if(jQuery('.correomail').length>0){
        var cont_mail = jQuery('.correomail').length;
    }else{
        var cont_mail = 0;
    }
    var cmail, lim_correo = 40;
    jQuery('#agregarmail').on('click', function(){
        if(cont_mail<limite){
            cont_mail++;                
            if(cont_mail==limite){
                jQuery(this).hide(500);
            }else{
                jQuery(this).show(500);
            }
            cmail = cont_mail;
            while(cmail>0){
                cmail--;
                jQuery('[data-btnmail='+cmail+']').hide();
            }
            jQuery(this).parent().before('<label for="" class="col-xs-12 col-md-4 control-label mail_'+cont_mail+'" style="margin-top:15px;">'+
                                            'Correo-e <i class="fa fa-asterisk text-red"></i>'+
                                         '</label>'+
                                         '<div class="col-xs-11 col-md-7 margen-top-d mail_'+cont_mail+'">'+
                                              '<input type="email" name="correoe[]" id="correoe_'+cont_mail+'" class="form-control validate[required, custom[email],maxSize['+lim_correo+']]" placeholder="Correo Electrónico">'+
                                          '</div>'+
                                         '<div class="row col-xs-1 margen-top-d mail_'+cont_mail+'">'+
                                              '<button type="button" class="btn btn-danger btn-md correomail" data-btnmail="'+cont_mail+'"><i class="fa fa-trash"></i></button>'+                                          
                                          '</div>'                                    
                                        );
        }
    });
    jQuery('form').on('click','.correomail',function(){
        jQuery('.mail_'+cont_mail).remove();
        cont_mail--;
        jQuery('[data-btnmail='+cont_mail+']').show();
        if(cont_mail<limite){
            jQuery('#agregarmail').show(500);
        }
    })
    /*Agregando teléfonos*/
    if(jQuery('.telef').length>0){
        var cont_telf = jQuery('.telef').length;
    }else{
        var cont_telf = 0;
    }
    var ctelf, lim_tel = 10;    
    jQuery('#agregartelf').on('click', function(){  
        if(cont_telf<limite){
        cont_telf++;
            if(cont_telf==limite){
                jQuery(this).hide(500);
            }else{
                jQuery(this).show(500);
            }
            ctelf = cont_telf;
            while(ctelf>0){
                ctelf--;
                jQuery('[data-btntelef='+ctelf+']').hide();
            }
            jQuery(this).parent().before('<label for="" class="col-xs-12 col-md-4 control-label telef_'+cont_telf+'" style="margin-top:15px;">'+
                                            'Teléfono <i class="fa fa-asterisk text-red"></i>'+
                                         '</label>'+
                                         '<div class="col-xs-9 col-md-5 margen-top-d telef_'+cont_telf+'">'+
                                              '<input type="text" name="telefono[]" id="telefono_'+cont_telf+'" class="form-control validate[required, custom[phone], maxSize['+lim_tel+']]" placeholder="Teléfono">'+
                                          '</div>'+
                                         '<div class="col-xs-2 margen-top-d telef_'+cont_telf+'">'+
                                              '<input type="text" name="extension[]" id="extension_'+cont_telf+'" class="form-control validate[required,maxSize['+lim_phono+']]" placeholder="Ext">'+
                                         '</div>'+
                                         '<div class="row col-xs-1 margen-top-d telef_'+cont_telf+'">'+
                                              '<button type="button" class="btn btn-danger btn-md telef" data-btntelef="'+cont_telf+'"><i class="fa fa-trash"></i></button>'+
                                          '</div>'
                                        );
            }
    })
    jQuery('form').on('click','.telef',function(){
        jQuery('.telef_'+cont_telf).remove();
        cont_telf--;
        jQuery('[data-btntelef='+cont_telf+']').show();
        if(cont_telf<limite){
            jQuery('#agregartelf').show(500);
        }
    })
    /*limpiado el campo ciudad en casod e cambiar ciudad*/
    jQuery('#id_estado').on('change', function(){
        jQuery('#ciudad').val('');
    })
    /*------Campos dinámicos de Contactos en clientes nuevaempresa*/
    /*Correo electrónico*/    
    if(jQuery('.mailc').length>0){
        var ecomn = jQuery('.mailc').length;
    }else{
        var ecomn = 0;
    }
    var cemail, lim_mail = 40;
    jQuery('#agregarmailcontact').on('click', function(){
        if(ecomn<limite){
        ecomn++;
            if(ecomn==limite){
                jQuery(this).hide(500);
            }else{
                jQuery(this).show(500);
            }
            cemail = ecomn;
            while(cemail>0){
                cemail--;
                jQuery('[data-btnemail='+cemail+']').hide();
            }
            jQuery(this).parent().before('<label for="" class="col-xs-12 col-md-4 control-label email_'+ecomn+'" style="margin-top:15px;">'+
                                            'Correo-e <i class="fa fa-asterisk text-red"></i>'+
                                         '</label>'+
                                         '<div class="col-xs-10 col-md-7 margen-top-d email_'+ecomn+'">'+
                                              '<input type="email" name="econtact[]" id="econtact_'+ecomn+'" class="form-control validate[required,custom[email], maxSize['+lim_mail+']]" placeholder="Correo Electrónico">'+
                                          '</div>'+
                                         '<div class="row col-xs-1 margen-top-d email_'+ecomn+'">'+
                                              '<button type="button" class="btn btn-danger btn-md mailc" data-btnemail="'+ecomn+'"><i class="fa fa-trash"></i></button>'+
                                          '</div>'
                                        );
            }
    });
    jQuery('form').on('click','.mailc',function(){
        jQuery('.email_'+ecomn).remove();
        ecomn--;
        jQuery('[data-btnemail='+ecomn+']').show();
        if(ecomn<limite){
            jQuery('#agregarmailcontact').show(500);
        }
    })
    /*telefóno*/
    if(jQuery('.telfc').length>0){
        var telf_cont = jQuery('.telfc').length;
    }else{
        var telf_cont = 0;
    } 
    var cphono, lim_phono = 10;
    jQuery('#agregartelfcontact').on('click', function(){
        if(telf_cont<limite){
        telf_cont++;
            if(telf_cont==limite){
                jQuery(this).hide(500);
            }else{
                jQuery(this).show(500);
            }
            cphono = telf_cont;
            while(cphono>0){
                cphono--;
                jQuery('[data-btnphono='+cphono+']').hide();
            }
            jQuery(this).parent().before('<label for="" class="col-xs-12 col-md-4 control-label ctelf_'+telf_cont+'" style="margin-top:15px;">'+
                                            'Teléfono <i class="fa fa-asterisk text-red"></i>'+
                                         '</label>'+
                                         '<div class="col-xs-9 col-md-5 margen-top-d ctelf_'+telf_cont+'">'+
                                              '<input type="text" name="telfcontact[]" id="telfcontact_'+telf_cont+'" class="form-control validate[required,custom[phone], maxSize['+lim_phono+']]" placeholder="Teléfono">'+
                                          '</div>'+
                                         '<div class="col-xs-2 margen-top-d ctelf_'+telf_cont+'">'+
                                              '<input type="text" name="extensionc[]" id="extensionc_'+telf_cont+'" class="form-control validate[maxSize['+telf_cont+']]" placeholder="Ext">'+
                                         '</div>'+
                                         '<div class="row col-xs-1 margen-top-d ctelf_'+telf_cont+'">'+
                                              '<button type="button" class="btn btn-danger btn-md telfc" data-btnphono="'+telf_cont+'"><i class="fa fa-trash"></button>'+
                                          '</div>'
                                        );
            }
    })
    jQuery('form').on('click','.telfc',function(){
        jQuery('.ctelf_'+telf_cont).remove();
        telf_cont--;
        jQuery('[data-btnphono='+telf_cont+']').show();
        if(telf_cont<limite){
            jQuery('#agregartelfcontact').show(500);
        }
    })
    /*Celular*/
    if(jQuery('.celc').length>0){
        var cel_cont = jQuery('.celc').length;
    }else{
        var cel_cont = 0;
    }    
    var ccel, lim_cel = 10;
    jQuery('#agregarcelcontact').on('click', function(){
        if(cel_cont<limite){
        cel_cont++;
            if(cel_cont==limite){
                jQuery(this).hide(500);
            }else{
                jQuery(this).show(500);
            }
            ccel = cel_cont;
            while(ccel>0){
                ccel--;
                jQuery('[data-btncel='+ccel+']').hide();
            }
            jQuery(this).parent().before('<label for="" class="col-xs-12 col-md-4 control-label cel_'+cel_cont+'" style="margin-top:15px;">'+
                                            'Celular <i class="fa fa-asterisk text-red"></i>'+
                                         '</label>'+
                                         '<div class="col-xs-10 col-md-7 margen-top-d cel_'+cel_cont+'">'+
                                              '<input type="text" name="celcontact[]" id="celcontact_'+cel_cont+'" class="form-control validate[required,custom[phone], maxSize['+lim_cel+']]" placeholder="Celular">'+
                                          '</div>'+
                                         '<div class="row col-xs-1 margen-top-d cel_'+cel_cont+'">'+
                                              '<button type="button" class="btn btn-danger btn-md celc" data-btncel="'+cel_cont+'"><i class="fa fa-trash"></button>'+
                                          '</div>'
                                        );
            }
    })
    jQuery('form').on('click','.celc',function(){
        jQuery('.cel_'+cel_cont).remove();
        cel_cont--;
        jQuery('[data-btncel='+cel_cont+']').show();
        if(cel_cont<limite){
            jQuery('#agregarcelcontact').show(500);
        }
    })
    /*Precio Descripción*/
    if(jQuery('.p_del').length>0){
        var conta_precio = jQuery('.p_del').length;
    }else{
        var conta_precio = 0;
    }
    var  ccprecio, lim_nom = 50 , prec = 6;
    jQuery('#agregarprecionom').on('click', function(){
        if(conta_precio<limite){
        conta_precio++;
            if(conta_precio==limite){
                jQuery(this).hide(500);
            }else{
                jQuery(this).show(500);
            }
            ccprecio = conta_precio;
            while(ccprecio>0){
                ccprecio--;
                jQuery('[data-btnpre='+ccprecio+']').hide();
            }
            jQuery(this).parent().before('<label for="" class="col-xs-12 col-sm-4 cp_'+conta_precio+'" style="margin-top:15px;">'+
                                            'Precio <i class="fa fa-asterisk text-red"></i>'+
                                         '</label>'+                                         
                                         '<div class="col-xs-12 col-sm-7 pdes cp_'+conta_precio+'" style="margin-top:15px;">'+
                                            '<input name="p_descripcion[]" type="text" id="p_descipcion_'+conta_precio+'" class="form-control validate[required, maxSize['+lim_nom+']]" placeholder="Nombre o Descripción">'+
                                            '<input name="precio_base[]" type="number" step="any" id="precio_base_'+conta_precio+'" class="precio form-control validate[required, maxSize['+prec+']]" placeholder="0.00">'+
                                         '</div>'+
                                         '<div class="row col-xs-1 margen-top-d cp_'+conta_precio+'">'+
                                              '<button type="button" class="btn btn-danger btn-sm p_del" data-btnpre="'+conta_precio+'"><i class="fa fa-trash"></i></button>'+
                                          '</div>'
                                        );
            }
    })
    jQuery('form').on('click','.p_del',function(){
        jQuery('.cp_'+conta_precio).remove();
        conta_precio--;        
        jQuery('[data-btnpre='+conta_precio+']').show();
        if(conta_precio<limite){
            jQuery('#agregarprecionom').show(500);
        }
    })
    /*Adicionando botones para adjuntar testimonio*/
    var cont_btn = 0;
    jQuery('.adiciona').on('click',function(){
        if(cont_btn<5){            
            cont_btn++;
            jQuery(this).before('<div class="col-xs-12 adjuntostest" style="padding:0;margin-top:15px;" id="mat'+cont_btn+'">'+
                                 '<button type="button" class="btn btn-danger btn-md col-xs-12 col-md-1 pull-right del_arch"><i class="fa fa-trash"></i></button>'+
                                 '<button type="button" class="btn btn-warning btn-md col-xs-12 col-md-6 pull-right adjunta validate[required]"><i class="fa fa-paperclip"></i> Adjuntar Testimonio</button>'+
                                 '<input type="file" name="file_testimonio_'+cont_btn+'" id="file_testimonio_'+cont_btn+'" class="testim" style="display:none">'+
                               '</div>');
        }
        if(cont_btn==4){
            jQuery(this).hide(500);
        }
        caux = cont_btn;
        caux--;
        while(caux>0){
            jQuery('#mat'+caux).children('.del_arch').hide();
            caux--;
        }
    })
    //eliminando los archivos cargados de testimonio
    jQuery('form').on('click', '.del_arch', function(){
        /*var nombre_arch = jQuery(this).siblings('[type=file]').val();
        jQuery.ajax({
            url:'index.php?option=com_erp&view=clientes&layout=delfile&tmpl=blank',
            type:'POST',
            data:{nombre:nombre_arch},
        })*/
        jQuery(this).parent().remove();
        cont_btn--;        
        jQuery('#mat'+cont_btn).children('.del_arch').show();
        if(cont_btn<4){
            jQuery('.adiciona').show(500);
        }
        
    })
    jQuery('.del_test').on('click',function(){
        jQuery('.adjuntostest').remove();
        jQuery(this).prev().before('<div class="col-xs-12" style="padding:0">'+
                                        '<button type="button" class="btn btn-warning btn-md col-xs-12 col-md-6 pull-right adjunta"><i class="fa fa-paperclip"></i> Adjuntar Testimonio</button>'+
                                        '<input type="file" name="file_testimonio_0" id="file_testimonio_0" class="testim" style="display:none">'+
                                    '</div>');
        jQuery(this).remove();
        jQuery('.adiciona').show();
    })
    /*cargando documentos de asociado*/
    jQuery('form').on('click', '.adjunta', function(){
        jQuery(this).siblings('[type=file]').trigger('click');
    })
    /*Visualizacion de que el campo fue adjuntado*/
    /*jQuery('form').on('change', '#file_nit, #file_matricula, #file_poder', function(){        
        jQuery(this).siblings('.adjunta').removeClass('btn-warning');
        jQuery(this).siblings('.adjunta').removeClass('validate[required]');
        jQuery(this).siblings('.adjunta').addClass('bg-green-active');
        jQuery(this).siblings('.adjunta').html('<i class="fa fa-check"></i> Adjuntado');
    })*/
    /*----marcando los checkbox que esten cuando hacemos click en la letra*/
    jQuery('.tickea').on('click',function(){
        jQuery(this).siblings().trigger('click');
    });
    //carga archivos en la parte de asociados
    jQuery('form').on('click', '#cargafile', function(){
        jQuery(this).siblings('[type=file]').trigger('click');
    })
    //var filespdf;
    ///-----------ENVIAR PDFS
    /*function enviarPDFS(objeto){
        //alert('hola')
        
    }*/
    jQuery('#files').on('change',function(){        
        filespdf = document.getElementById('files').files;//obtenemos todos los archivos en la variable
        var pdfs = new FormData();
        var sw = 1, type, extension, conta;        
        for(var i = 0; i < filespdf.length; i++){          
            type = filespdf[i].type;
            extension = type.split('/');
            if(extension[1]!='pdf'){
                sw = 0;
            }
            conta = i;
		}
        if(sw==1){
            jQuery('#mensaje').hide(500);
            for(var i = 0; i < filespdf.length; i++){
                var id = jQuery('#id').val()
                var tamk = (filespdf[i].size / 1024);
                var tamm = (tamk/1024);
                pdfs.append('archivo',filespdf[i]); //Añadimos cada archivo a el array "pdfs" con un indice direfente
                pdfs.append('id',id); //Añadimos id
                jQuery('#cargafile').removeClass('btn-warning');
                jQuery('#cargafile').addClass('btn-success');
                jQuery('#cargafile').html('<i class="fa fa-refresh fa-spin"></i> Cargando PDF');
                jQuery('#cargafile').attr('disabled','disabled');                    
                jQuery.ajax({
                    url: 'index.php?option=com_erp&view=clientes&layout=insertaarchivos&tmpl=blank',
                    type: 'POST',
                    contentType:false, //Debe estar en false para que pase el objeto sin procesar
                    data: pdfs,
                    processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
                    cache:false,
                })
                .done(function(data){
                    //alert(data);
                    conta--;                    
                    jQuery('#listapdfs').append('<tr><td><i class="fa fa-file-pdf-o"></i> '+data+'</td><td></td><td><button type="button" class="btn bg-olive"><i class="fa fa-file-pdf-o"></i> Archivo Cargado</button></td></tr>');
                    if(conta<0){
                        jQuery('#cargafile').addClass('btn-warning');
                        jQuery('#cargafile').removeClass('btn-success');
                        jQuery('#cargafile').html('<i class="fa fa-file-pdf-o"></i> Subir PDF <i class="fa fa-upload"></i>');
                        jQuery('#cargafile').removeAttr('disabled');
                    }
                })
            }
        }else{
            jQuery('#mensaje').show(500);
            jQuery('#mensaje').html('<h4 class="alert alert-warning">NO SE HA CARGADO NINGUN ARCHIVO, SOLO SE ACEPTAN ARCHIVOS PDF</h4>');
        }
        //alert(filespdf[1].name)
    })
    //limpiar formulario
    jQuery('[type=reset]').on('click',function(){
        jQuery.ajax({
                url: 'index.php?option=com_erp&view=clientes&layout=sessionout&tmpl=blank',
                type: 'POST',
                data: {ok:1},
            })
    })
    var inputfile,id_file,tipo,cadena;// variable para obtener archivos
    jQuery('form').on('change', '.testim, #file_nit, #file_matricula, #file_poder', function(){        
                
        id_file=jQuery(this).attr('id');
        inputfile = document.getElementById(id_file).files;//obtenemos todos los archivos en la variable
        for (var i = 0; i < inputfile.length; i++) {
            var type = inputfile[i].type;            
        }
        var extension = type.split('/');
        //validando        
        if(extension[1] == 'pdf' || extension[1] == 'jpg' || extension[1] == 'png' || extension[1] == 'jpeg'){
            jQuery(this).siblings('.adjunta').removeClass('btn-warning');
            jQuery(this).siblings('.adjunta').removeClass('validate[required]');
            jQuery(this).siblings('.adjunta').addClass('btn-primary');
            jQuery(this).siblings('.adjunta').html('<i class="fa fa-refresh fa-spin"></i> Cargando...');
            var archivos = new FormData();
            for(i=0; i<inputfile.length; i++){
              archivos.append('archivo',inputfile[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }
            archivos.append('id',jQuery(this).attr('id'));
            cadena = jQuery(this).attr('id');
            tipo = cadena.split('_');
            archivos.append('tipo',tipo[1]);
            archivos.append('extension',extension[1]);
            
            jQuery('[type=submit]').attr('disabled','disabled');
            jQuery.ajax({
                url: 'index.php?option=com_erp&view=clientes&layout=insertfiles&tmpl=blank',
                type: 'POST',
                contentType:false, //Debe estar en false para que pase el objeto sin procesar
                data: archivos,
                processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
                cache:false,
            })
            .done(function(data){
                //alert(data);                
                jQuery('#'+data).siblings('.adjunta').removeClass('btn-primary');
                jQuery('#'+data).siblings('.adjunta').addClass('bg-green-active');
                jQuery('#'+data).siblings('.adjunta').html('<i class="fa fa-check"></i> Adjuntado');
                jQuery('#'+data).siblings('.adjunta').attr('disabled','disabled');
                jQuery('#'+data).remove();
                jQuery('[type=submit]').removeAttr('disabled');
            })
        }else{
            jQuery(this).siblings('.adjunta').removeClass('btn-warning');            
            jQuery(this).siblings('.adjunta').addClass('btn-danger');
            jQuery(this).siblings('.adjunta').html('<i class="fa fa-remove"></i> Archivo No Permitido');
            setTimeout(function(){//Retardando el Tiempo de Ejecucion
                jQuery('#'+id_file).siblings('.adjunta').removeClass('btn-danger');
                jQuery('#'+id_file).siblings('.adjunta').addClass('btn-warning');
                jQuery('#'+id_file).siblings('.adjunta').html('<i class="fa fa-paperclip"></i> Adjuntar Nuevamente');
            },3000);
        }
    })
});
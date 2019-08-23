<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
//include("inc/fun-ini.php");

$clSistema = new clSis();
session_start();

$select = "	SELECT 
	ci.*
FROM
	BitCursos ci
	
WHERE ci.eCodCurso = ".$_GET['v1'];
//echo $select;
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.js"></script>
	<script type="text/javascript">
		function readURL(input,destino) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#falseinput').attr('src', e.target.result);
					$('#base').val(e.target.result);
          document.getElementById(destino).value=e.target.result;
                    document.getElementById('bFichero').value="";
          //llenar();
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
   
function validar()
{
var bandera = false;

   
    
    if(!bandera)
    {
        guardar();
    }
    else
    {
        alert("<- Los campos en rojo son obligatorios ->")
    }
}
   
</script>
    
<div class="row">
    <div class="col-lg-12">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="eCodCurso" name="eCodCurso" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
        <input type="hidden" name="eCodEntidad" id="eCodEntidad" value="<?=$_SESSION['sessionAdmin']['eCodEntidad'];?>">
                            <div class="col-lg-12">
								<h2 class="title-1 m-b-25"><?=$_GET['v1'] ? 'Actualizar ' : '+ '?>Curso</h2>
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
                                        <div class="form-group">
              
           </div>
           <div class="form-group">
              <label>Fecha del Curso</label>
              <input type="text" class="form-control" name="fhFechaCurso" id="fhFechaCurso" placeholder="Fecha (dd-mm-YYYY HH:mm)" value="<?=($rPublicacion{'fhFechaCurso'})?>" >
           </div>
           <div class="form-group">
              <label>T&iacute;tulo</label>
              <input type="text" class="form-control" name="tTitulo" id="tTitulo" placeholder="Título" value="<?=($rPublicacion{'tTitulo'})?>" >
           </div>
           <div class="form-group">
              <label>Objetivo</label>
              <textarea class="form-control" name="tObjetivo" id="tObjetivo" placeholder="Objetivo"><?=($rPublicacion{'tObjetivo'})?></textarea>
           </div>
           <div class="form-group">
              <label>Descripci&oacute;n</label>
              <textarea class="form-control" name="tDescripcion" id="tDescripcion" placeholder="Descripci&oacute;n"><?=($rPublicacion{'tDescripcion'})?></textarea>
           </div>
           <div class="form-group">
              <label>Horas totales</label>
              <input type="text" class="form-control" name="eHoras" id="eHoras" placeholder="Horas totales" value="<?=($rPublicacion{'eHoras'})?>" >
           </div>
           <div class="form-group">
              <label>Ubicaci&oacute;n</label>
              <textarea class="form-control" name="tUbicacion" id="tUbicacion" placeholder="Ubicaci&oacute;n"><?=($rPublicacion{'tUbicacion'})?></textarea>
           </div>
                                        
           <div class="form-group" style="overflow-x: scroll;">
              <label>Modalidades</label>
              <table width="100%" style="min-width:500px;">
              <?
                if($rPublicacion{'eCodCurso'})
                {
                $select = "SELECT 
                                cm.eCodModalidad codigoModalidad, 
                                cm.tNombre Modalidad, 
                                rcm.eCodModalidad codigoCurso, 
                                rcm.* 
                            FROM CatModalidades cm 
                            LEFT JOIN RelCursosModalidades rcm ON rcm.eCodModalidad=cm.eCodModalidad ".(($rPublicacion{'eCodCurso'}) ? " AND rcm.eCodCurso=".$rPublicacion{'eCodCurso'} : "" )."
                            WHERE 1=1  ORDER BY eCodModalidad ASC";
                }
               else
               {
               $select = "SELECT 
                                cm.eCodModalidad codigoModalidad, 
                                cm.tNombre Modalidad
                            FROM CatModalidades cm 
                            WHERE 1=1  ORDER BY eCodModalidad ASC";
               }
                $rsModalidades = mysql_query($select);
                $i=0;
                while($rModalidad = mysql_fetch_array($rsModalidades))
                {?> 
                <tr>
                    <td>
                <input type="checkbox" name="modalidad[<?=$i;?>][eCodModalidad]" id="modalidad[<?=$i;?>][eCodModalidad]" value="<?=$rModalidad{'codigoModalidad'}?>" <?=(($rModalidad{'codigoCurso'}) ? 'checked' : '' );?>>
                    </td>
                    <td>
                        <?=utf8_encode($rModalidad{'Modalidad'});?>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modalidad[<?=$i;?>][eLugares]" id="modalidad[<?=$i;?>][eLugares]" placeholder="Lugares disponibles" value="<?=$rModalidad{'eLugares'};?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modalidad[<?=$i;?>][dPrecio]" id="modalidad[<?=$i;?>][dPrecio]" placeholder="Precio" value="<?=$rModalidad{'dPrecio'};?>">
                    </td>
                  </tr>
                <? $i++; ?>
                <? } ?>
               </table>
           </div>
                                        
           <div class="form-group">
              <label>M&oacute;dulos</label>
              <table width="100%" id="tblModulos" cellspacing="1">
              <?
                $select = "SELECT * FROM RelCursosModulos WHERE eCodCurso = ".$rPublicacion{'eCodCurso'}." ORDER BY fhFechaModulo ASC";
                $rsModulos = mysql_query($select);
                $i=1;
                while($rModulo = mysql_fetch_array($rsModulos))
                {?> 
                <tr id="fila<?=$i;?>">
                    <td style="padding:5px;">
                        <i class="far fa-trash-alt" onclick="deleteRow(<?=$i;?>)"></i>
                        <input type="hidden" name="modulos[<?=$i;?>][eCodRegistro]" id="modulos[<?=$i;?>][eCodRegistro]" value="<?=$rModulo{'eCodRegistro'};?>">
                <input type="hidden" name="modulos[<?=$i;?>][eModulo]" id="modulos[<?=$i;?>][eModulo]" value="<?=$rModulo{'eModulo'};?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][tNombre]" id="modulos[<?=$i;?>][tNombre]" placeholder="Título" value="<?=$rModulo{'tNombre'};?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][fhFechaModulo]" id="modulos[<?=$i;?>][fhFechaModulo]" placeholder="Fecha (dd-mm-YYYY HH:mm)" value="<?=date('d-m-Y H:i',strtotime($rModulo{'fhFechaModulo'}));?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][eHoras]" id="modulos[<?=$i;?>][eHoras]" placeholder="Horas" value="<?=$rModulo{'eHoras'};?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][tEmbed]" id="modulos[<?=$i;?>][tEmbed]" placeholder="Enlace" value="<?=$rModulo{'tEmbed'};?>">
                    </td>
                  </tr>
                <? $i++; ?>
                <? } ?>
                  <tr id="fila<?=$i;?>">
                    <td>
                        <i class="far fa-trash-alt" onclick="deleteRow(<?=$i;?>)"></i>
                        <input type="hidden" name="modulos[<?=$i;?>][eCodRegistro]" id="modulos[<?=$i;?>][eCodRegistro]">
                <input type="hidden" name="modulos[<?=$i;?>][eModulo]" id="modulos[<?=$i;?>][eModulo]" value="<?=$i;?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][tNombre]" id="modulos[<?=$i;?>][tNombre]" placeholder="Título" onchange="nvaFila(<?=$i;?>)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][fhFechaModulo]" id="modulos[<?=$i;?>][fhFechaModulo]" placeholder="Fecha (dd-mm-YYYY HH:mm)" onchange="nvaFila(<?=$i;?>)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][eHoras]" id="modulos[<?=$i;?>][eHoras]" placeholder="Horas" onchange="nvaFila(<?=$i;?>)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="modulos[<?=$i;?>][tEmbed]" id="modulos[<?=$i;?>][tEmbed]" placeholder="Enlace">
                    </td>
                  </tr>
               </table>
               <input type="hidden" name="eFilas" id="eFilas" value="<?=($i+1);?>">
           </div>

           <div class="form-group">
              <label>Imagen Pauta</label>
              <input type="file" class="form-control" name="tFlyer" id="tFlyer" onchange="readURL(this,'tImagen')">
			   <input type="hidden" id="tImagen" name="tImagen" value="<?=base64_decode($rPublicacion{'tFlyer'})?>">
               <input type="hidden" id="tFicheroFlyer" name="tFicheroFlyer" value="<?=$rPublicacion{'tFlyer'}?>">
               <input type="hidden" id="bFicheroFlyer" name="bFicheroFlyer" value="<?=$rPublicacion{'tFlyer'} ? 1 : 0?>">
               <img src="<?=obtenerURL();?>cla/<?=$rPublicacion{'tFlyer'}?>" width="250" height="250" <?=(!$rPublicacion{'tFlyer'} ? 'style="display:none;"' : '')?>>
           </div>
           <div class="form-group">
              <label>Imagen Slider</label>
              <input type="file" class="form-control" name="tSlider" id="tSlider" onchange="readURL(this,'tImagen2')">
			   <input type="hidden" id="tImagen2" name="tImagen2" value="<?=base64_decode($rPublicacion{'tSlider'})?>">
               <input type="hidden" id="tFicheroSlider" name="tFicheroSlider" value="<?=$rPublicacion{'tSlider'}?>">
               <input type="hidden" id="bFicheroSlider" name="bFicheroSlider" value="<?=$rPublicacion{'tSlider'} ? 1 : 0?>">
               <img src="<?=obtenerURL();?>cla/<?=$rPublicacion{'tSlider'}?>" width="250" height="250" <?=(!$rPublicacion{'tSlider'} ? 'style="display:none;"' : '')?>>
           </div>
           
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>

<script>
//tabla
    function nvaFila(indice) {
		var nombre		=	document.getElementById('modulos['+indice+'][tNombre]');
		var fecha		=	document.getElementById('modulos['+indice+'][fhFechaModulo]');
		var horas		=	document.getElementById('modulos['+indice+'][eHoras]');
    	
        
        if(nombre.value!="" && fecha.value!="" && horas.value!="")
        {

		var x = document.getElementById("tblModulos").rows.length;
            var nIndice = document.getElementById('eFilas').value;
    var table = document.getElementById("tblModulos");
    var row = table.insertRow(x);
    row.id="fila"+(nIndice);
    row.innerHTML = '<td style="padding:5px;"><i class="far fa-trash-alt" onclick="deleteRow('+nIndice+')"></i><input type="hidden" name="modulos['+nIndice+'][eCodRegistro]" id="modulos['+nIndice+'][eCodRegistro]"><input type="hidden" name="modulos['+nIndice+'][eModulo]" id="modulos['+nIndice+'][eModulo]" value="'+nIndice+'"></td>';
    row.innerHTML += '<td><input type="text" class="form-control" name="modulos['+nIndice+'][tNombre]" id="modulos['+nIndice+'][tNombre]" placeholder="Título" onchange="nvaFila('+nIndice+')"></td>';
    row.innerHTML += '<td><input type="text" class="form-control" name="modulos['+nIndice+'][fhFechaModulo]" id="modulos['+nIndice+'][fhFechaModulo]" placeholder="Fecha (dd-mm-YYYY HH:mm)" onchange="nvaFila('+nIndice+')"></td>';
    row.innerHTML += '<td><input type="text" class="form-control" name="modulos['+nIndice+'][eHoras]" id="modulos['+nIndice+'][eHoras]" placeholder="Horas" onchange="nvaFila('+nIndice+')"></td>';
    row.innerHTML += '<td><input type="text" class="form-control" name="modulos['+nIndice+'][tEmbed]" id="modulos['+nIndice+'][tEmbed]" placeholder="Enlace"></td>';

    nIndice++;

    document.getElementById('eFilas').value = nIndice;

            
    }
}
    
    function deleteRow(rowid)  {   
    var row = document.getElementById('fila'+rowid);
    row.parentNode.removeChild(row);
     
}
</script>
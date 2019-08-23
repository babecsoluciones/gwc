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

    
<div class="row">
    <div class="col-lg-12">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="eCodCurso" name="eCodCurso" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								<h2 class="title-1 m-b-25">Detalle del Curso</h2>
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
                                        <div class="form-group">
              
           </div>
           <div class="form-group">
              <label>Fecha</label>
               <div class="form-control" name="fhFechaCurso" id="fhFechaCurso">  <?=date('d/m/Y H:i',strtotime($rPublicacion{'fhFechaCurso'}))?> </div>
           </div>
           <div class="form-group">
              <label>T&iacute;tulo</label>
              <div class="form-control" name="tTitulo" id="tTitulo">  <?=($rPublicacion{'tTitulo'})?> </div>
           </div>
           <div class="form-group">
              <label>Objetivo</label>
              <div class="form-control" name="tObjetivo" id="tObjetivo" ><?=($rPublicacion{'tObjetivo'})?></div>
           </div>
           <div class="form-group">
              <label>Descripci&oacute;n</label>
              <div class="form-control" name="tDescripcion" id="tDescripcion" ><?=($rPublicacion{'tDescripcion'})?></div>
           </div>
           <div class="form-group">
              <label>Horas totales</label>
              <div class="form-control" name="eHoras" id="eHoras" ><?=($rPublicacion{'eHoras'})?></div>
           </div>
           <div class="form-group">
              <label>Ubicaci&oacute;n</label>
              <div class="form-control" name="tUbicacion" id="tUbicacion" ><?=($rPublicacion{'tUbicacion'})?></div>
           </div>
                                        
           <div class="form-group">
              <label>Modalidades</label>
              <table width="100%">
                  <tr>
                    <td>
                        <b>Modalidad</b>
                    </td>
                    <td>
                        <b>Lugares disponibles</b>
                    </td>
                    <td>
                        <b>Precio</b>
                    </td>
                  </tr>
              <?
                $select = "SELECT cm.eCodModalidad codigoModalidad, cm.tNombre Modalidad, rcm.* FROM CatModalidades cm INNER JOIN RelCursosModalidades rcm ON rcm.eCodModalidad=cm.eCodModalidad WHERE 1=1  AND rcm.eCodCurso=".$rPublicacion{'eCodCurso'}." ORDER BY eCodModalidad ASC";
                $rsModalidades = mysql_query($select);
                $i=0;
                while($rModalidad = mysql_fetch_array($rsModalidades))
                {?> 
                <tr>
                    <td>
                        <?=utf8_encode($rModalidad{'Modalidad'});?>
                    </td>
                    <td>
                        <?=$rModalidad{'eLugares'};?>
                    </td>
                    <td>
                        <?=$rModalidad{'dPrecio'};?>
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
                    <td>
                        <?=$rModulo{'tNombre'};?>
                    </td>
                    <td>
                        <?=date('d/m/Y H:i',strtotime($rModulo{'fhFechaModulo'}));?>
                    </td>
                    <td>
                        <?=$rModulo{'eHoras'};?>
                    </td>
                  </tr>
                <? $i++; ?>
                <? } ?>
                 
               </table>
               <input type="hidden" name="eFilas" id="eFilas" value="<?=($i+1);?>">
           </div>

           <div class="form-group">
              Imagen Flyer<br>
               <img src="<?=obtenerURL();?>cla/<?=$rPublicacion{'tFlyer'}?>" width="250" height="250">
           </div>
           <div class="form-group">
              Imagen Slider<br>
               <img src="<?=obtenerURL();?>cla/<?=$rPublicacion{'tSlider'}?>" width="250" height="250">
           </div>
           
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>


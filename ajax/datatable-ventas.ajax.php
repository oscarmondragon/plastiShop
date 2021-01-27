<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class TablaProductosVentas{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaProductosVentas(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
 		
  		if(count($productos) == 0){

  			echo '{"data": []}';

		  	return;
  		}	
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($productos); $i++){

		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 

		  	$imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";

		  	/*=============================================
 	 		STOCK
  			=============================================*/ 

  			if($productos[$i]["stock"] <= 50){

  				$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";

  			}else if($productos[$i]["stock"] > 51 && $productos[$i]["stock"] <= 100){

  				$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";

  			}else{

  				$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";

  			}

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
  			$botones =  "<div class='btn-group'><button class='btn btn-primary btnEditarProducto agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'>Agregar</button><select  id=".$productos[$i]["id"]." class='btn btn-default agregarProducto recuperarBoton'>";
  			//Filtramos los precios segun el producto. si los precios son 0 no se pmostraran en el select
  			$filtroPrecios ="";


        if($productos[$i]["precio_venta"] <> 0){
          $filtroPrecios.= "<option value='1' idProducto='".$productos[$i]["id"]."'>Mayoreo</option>";
        } 

        if($productos[$i]["precio_menudeo"] <> 0) {
          $filtroPrecios.= "<option value='0' idProducto='".$productos[$i]["id"]."'>Menudeo</option>";
        }


  			if($productos[$i]["precio_especial"] <> 0) {
  				$filtroPrecios.= "<option value='2' idProducto='".$productos[$i]["id"]."'>Especial</option>";
  			}

  			if($productos[$i]["precio_credito"] <> 0) {
  				$filtroPrecios.= "<option value='3' idProducto='".$productos[$i]["id"]."'>Crédito</option>";
  			}

        if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador"){

        $filtroPrecios.= "<option value='4' idProducto='".$productos[$i]["id"]."' >Traspaso</option>";
	
  			}

			$botonesCierre ="</select></div>";

			$botones= $botones."".$filtroPrecios."".$botonesCierre;

		  	/*$botones =  "<div class='btn-group'><button class='btn btn-primary btnEditarProducto agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'>Agregar</button><div class='btn-group'><select class='btn btn-warning agregarProducto recuperarBoton' ><option value='0' idProducto='".$productos[$i]["id"]."'>Mayoreo</option><option value='1' idProducto='".$productos[$i]["id"]."'>Especial</option><option value='2' idProducto='".$productos[$i]["id"]."'>Por Bulto</option><option value='3' idProducto='".$productos[$i]["id"]."'>Crédito</option></select></div>"; */

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["codigo"].'",
			      "'.$productos[$i]["descripcion"].'",
			      "$ '.$productos[$i]["precio_venta"].'",
			      "'.$stock.'",
			      "'.$botones.'"
			    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}


}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarProductosVentas = new TablaProductosVentas();
$activarProductosVentas -> mostrarTablaProductosVentas();


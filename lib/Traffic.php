<?php


namespace Intratum\Facturas;

//['acc', 0, 'nbfwaiunbgiuwa']
//$id = 'acc_'.base64_encode('0:'.nbfwaiunbgiuwa);

class Traffic{
	
	 public static function get($url, $data = null){
		
		$urlpath = explode('?', $url);
		$urlpath2 = explode('/', $urlpath[0]);
		
		$urlpath[0] = rtrim($urlpath[0], '/');
		
		$paths = [
			'/' => 'src/home/index.php',
			'' => 'src/home/index.php',

			'/terminos-y-condiciones' => 'src/terminos/terminos.php',

			'/productos' => 'src/producto/index.php',
			'/productos/nuevo' => 'src/producto/form_producto.php',
			'/productos/ed' => 'src/producto/edit_form_producto.php',
			'/productos/del' => 'src/producto/del_producto.php',

			'/clientes' => 'src/clientes/index.php',
			'/clientes/nuevo' => 'src/clientes/form_clientes.php',
			'/clientes/ed' => 'src/clientes/edit_form_clientes.php',
			'/clientes/del' => 'src/clientes/del_clientes.php',

			'/proveedores' => 'src/proveedores/index.php',
			'/proveedores/nuevo' => 'src/proveedores/form_proveedores.php',
			'/proveedores/ed' => 'src/proveedores/edit_form_proveedores.php',
			'/proveedores/del' => 'src/proveedores/del_proveedores.php',

			'/gastos' => 'src/gastos/index.php',
			'/gastos/nuevo' => 'src/gastos/form_gasto.php',

			'/facturas' => 'src/facturas/index.php',
			'/facturas/nuevo' => 'src/facturas/form_factura.php',
			'/facturas/ed' => 'src/facturas/edit_form_factura.php',
			'/facturas/del' => 'src/facturas/del_factura.php',


			'/presupuestos' => 'src/presupuestos/index.php',
			'/presupuestos/nuevo' => 'src/presupuestos/form_presupuesto.php',
			'/presupuestos/ed' => 'src/facturas/edit_form_factura.php',
			'/presupuestos/del' => 'src/presupuestos/del_presupuesto.php',
			
			'/register' => 'src/register/form_register.php',

			'/login' => 'src/login/form_login.php',

			'/logout' => 'src/login/logout.php',

			'/configuracion/seriales' => 'src/configuration/seriales/index.php',
			'/configuracion/seriales/nuevo' => 'src/configuration/seriales/form_serial.php',
			'/configuracion/seriales/ed' => 'src/configuration/seriales/edit_form_serial.php',
			'/configuracion/seriales/del' => 'src/configuration/seriales/del_serial.php',

			'/configuracion/impuestos' => 'src/configuration/tax/index.php',
			'/configuracion/impuestos/nuevo' => 'src/configuration/tax/form_tax.php',
			'/configuracion/impuestos/ed' => 'src/configuration/tax/edit_form_tax.php',
			'/configuracion/impuestos/del' => 'src/configuration/tax/del_tax.php',

			'/pdf' => 'src/facturas/generate_pdf.php',

			'/empresa' => 'src/cuenta_emp/form_cuenta_emp.php',

		];


		
		
		if(!empty($paths[$urlpath[0]]))
			$res = $paths[$urlpath[0]];


		if($urlpath2[1] == 'static'){
			$res  = 'assets/'.end($urlpath2);
		}

		if($urlpath2[1] == 'ajax'){
			$res  = 'api/'.$urlpath2[2].'.php';
		}

		if($urlpath2[1] == 'pdf'){
			$res  = './pdf/'.end($urlpath2);
		}

		if($urlpath2[1] == 'html'){
			$res  = 'templates/html/'.$urlpath2[2].'.php';
		}

		return $res;
	}

	public static function getEntryPOST(){
		$data = json_decode(file_get_contents('php://input'), true);

		return $data;
	}

	public static function getEntryGET(){
		$data = $_GET;

		return $data;
	}
}
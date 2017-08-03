<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alertas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('promocion_model');
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
		date_default_timezone_set('America/Mexico_City');
		
	}
	
	public function index(){
		
        $data = $this->header_lib->arma_rutas();
        
		if($this->login_lib->verifica_login()){
			
			$this->load->helper("security");
			
			$data = $this->header_lib->arma_menu($data);
			
			$id_usuario = $this->session->userdata('id_usuario');
			$id_usuario = $this->encrypt->decode($id_usuario);
			$this->db->order_by('alta', 'desc');
			$alertas = $this->db->get_where('alertas', array('usuarios_id_usuario' => $id_usuario));
			
			$data['alertas'] = $alertas;
			
			$page = 'alertas_page';
		}else{
			$page = 'index_page';
			$data['ultimas'] = $this->promocion_model->get_index();
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
        
	}
	
	public function guardar_alerta(){
		
		$this->load->helper("security");
		
		$max_alertas = 5;
		$mensaje = '';
		$codigo = -1;
		
		$id_usuario = $this->session->userdata("id_usuario");
		$id_usuario = $this->encrypt->decode($id_usuario);
		
		$num_alertas = $this->db->get_where('alertas', array("usuarios_id_usuario" => $id_usuario))->num_rows();
		
		if($num_alertas >= $max_alertas){
			$mensaje = 'Has excedido el número máximo de alertas.';
		}else{
			$datos = $this->session->userdata('alerta_actual');
			$this->db->insert('alertas', $datos);
			$codigo = $this->db->_error_number();
			if($codigo == 0){
				$mensaje = "Alerta guardada correctamente";
			}else{
				$mensaje = "Error al guardar alerta, por favor intente más tarde.";
			}
		}
		
		$response = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje
		);
		
        echo json_encode($response);
	}
	
	public function borrar(){
		
		$this->load->helper("security");
		
		$id_alerta = $this->input->post("alerta");
		$id_alerta_decode = $this->encrypt->decode($id_alerta);
		
		$this->db->where('id_alerta', $id_alerta_decode);
		$this->db->delete('alertas');
		$codigo = $this->db->_error_number();
		
		//$codigo = 0;
		
		$response = array(
			'alerta' => $id_alerta,
			'codigo' => $codigo
		);
		
		echo json_encode($response);
	}
	
    public function guardar(){
        
        $this->load->helper('security');
        
        $criterio_busqueda = '';
        
        if(!$this->input->post() || !$this->login_lib->verifica_login()){
			redirect('/');
		}
        
		$codigo = -1;
		$alta = '';
		$titulo = '';
		$id_alerta = '';
		$mensaje = '';
		$maximo_alertas = 5;
		
		$id_usuario = $this->session->userdata('id_usuario');
		$id_usuario = $this->encrypt->decode($id_usuario);
			
		$num_alertas = $this->db->get_where('alertas', array('usuarios_id_usuario' => $id_usuario))->num_rows();
		
		if($num_alertas >= $maximo_alertas){
			$mensaje = 'Has excedido el número máximo de alertas.';
		}else{
			$data = $this->header_lib->arma_rutas();
			$data = $this->header_lib->arma_menu($data);
			
			$categoria = $this->input->post('categoria');
			$subcategorias = $this->input->post("subcategorias");
			$tipo_promocion = $this->input->post('tipo_promocion') | 0;
			$canal = $this->input->post('canal') | 0;
			$formatos = $this->input->post('formatos');
			
			$str_subcategoria = '';
			$criterio_subcategoria = '';
			
			if($subcategorias){
				$cont_sub = 1;
				$str_subcategoria .= '(';
				foreach($subcategorias as $subcategoria){
					if($cont_sub <= 3){
						$nombre_subcategoria = $this->db->get_where('subcategorias', array('id_subcategoria' => $subcategoria))->row()->nombre_subcategoria;
						$str_subcategoria .= ucfirst(strtolower($nombre_subcategoria));
						$cont_sub++;
					}
					if($cont_sub <= 3){
						$str_subcategoria .= ", ";
					}
					$criterio_subcategoria .= $subcategoria . "|";
				}
				$str_subcategoria .= '... )';
				
				$nombre_categoria = $this->db->get_where('categorias', array('id_categoria' => $categoria))->row()->nombre_categoria;
				$criterio_busqueda .= ucfirst(strtolower($nombre_categoria)) . " " . $str_subcategoria . " / ";
				
				$categoria = 0;
			}else{
				$criterio_subcategoria = 0;
				if(!$categoria || $categoria == "TODOS"){
					$categoria = 0;
				}else{
					$nombre_categoria = $this->db->get_where('categorias', array('id_categoria' => $categoria))->row()->nombre_categoria;
					$criterio_busqueda .= ucfirst(strtolower($nombre_categoria)) . " " . $str_subcategoria . " / ";
				}
			}
			
			if($tipo_promocion != 0){
				$nombre_tipo_promo = $this->db->get_where('tipos_promocion', array('id_tipo_promocion' => $tipo_promocion))->row()->nombre_tipo_promocion;
				$criterio_busqueda .= $nombre_tipo_promo . " / ";
			}
			
			if($canal != 0){
				$nombre_canal = $this->db->get_where('canales', array('id_canal' => $canal))->row()->nombre_canal;
				$criterio_busqueda .= $nombre_canal . " / ";
			}
			
			$str_formatos = '';
			$criterio_formatos = '';
			$cont_formatos = 1;
			if( !empty($formatos) ){
				$str_formatos .= '(';
				$cont_formatos = 1;
				foreach($formatos as $formato){
					if($cont_formatos <= 3){
						$nombre_formato = $this->db->get_where('formatos', array('id_formato' => $formato))->row()->nombre_formato;
						$str_formatos .= ucfirst(strtolower($nombre_formato));
						$cont_formatos++;
					}
					
					if($cont_formatos <= 3){
						$str_formatos .= ", ";
					}
					
					$criterio_formatos .= $formato . "|";
				}
				$str_formatos .= '...) /';
				
			}else{
				$criterio_formatos = 0;
			}
			
			$criterio_busqueda .= $str_formatos;
			
			$fecha = date('Y-m-d H:i:s');
			
			$datos = array(
				'usuarios_id_usuario' => $id_usuario,
				'alta' => $fecha,
				'activa' => 1,
				'categoria' => $categoria,
				'subcategorias' => $criterio_subcategoria,
				'tipo_promo' => $tipo_promocion,
				'canal' => $canal,
				'formatos' => $criterio_formatos,
				'titulo' => $criterio_busqueda
			);
			
			$this->db->insert('alertas', $datos);
			$codigo = $this->db->_error_number();
			if($codigo == 0){
				$alerta = $this->db->get_where('alertas', $datos)->row();
				$alta = $alerta->alta;
				$titulo = $alerta->titulo;
				$id_alerta = $this->encrypt->encode($alerta->id_alerta);
				$mensaje = "Alerta guardada correctamente";
			}else{
				$mensaje = "Error al guardar alerta, por favor intente más tarde.";
			}
		}
		
		$response = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje,
			'alta' => $alta,
			'titulo' => $titulo,
			'alerta' => $id_alerta
		);
		
        echo json_encode($response);
    }
    
    public function enviar_alertas(){
		$this->load->library('email');
		$this->load->model('usuario_model');
        
        $limite_promociones = 10;
        
		$array = array(
			'id_usuario' => 16
		);
		
		$usuarios = $this->db->get_where('usuarios', $array);
		
        $usuarios = $this->usuario_model->get_all();
        
        foreach($usuarios->result() as $usuario){
			echo "correo ->";
			echo $usuario->correo;
			echo "<br />";
            $array = array(
                'usuarios_id_usuario' => $usuario->id_usuario
            );
            $alertas = $this->db->get_where('alertas', $array);
            
			if($alertas->num_rows() > 0 ){
				foreach($alertas->result() as $alerta){
					
					$titulo_alerta = $alerta->titulo;
					
					$query_promociones = '
						select p.id_promocion, concat(left(p.titulo, 15), "...") as titulo, p.foto, m.logo_marca, m.nombre_marca,
						cat.nombre_categoria, sub.nombre_subcategoria, tp.nombre_tipo_promocion, up.formatos_id_formato,
						form.img_formato, p.producto, p.descripcion
						from promociones as p
						left join marcas as m on m.id_marca = p.marcas_id_marca
						left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
						left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
						left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
						left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
						left join formatos as form on up.formatos_id_formato = form.id_formato
						left join canales as can on can.id_canal = form.canales_id_canal
						where 1 
					';
					
					$subcategorias = $alerta->subcategorias;
					if($subcategorias != 0){
						$subcategorias = explode('|',$subcategorias);
						$tamanio = count($subcategorias);
						$subcategorias = array_slice($subcategorias, 0, $tamanio - 1);
						$query_promociones .= ' and p.subcategorias_id_subcategoria in( ';
						foreach($subcategorias as $subcategoria){
							$query_promociones .= $subcategoria.',';
						}
						$query_promociones = substr_replace($query_promociones ,"",-1) . ' ) ';
						print_r($subcategorias);
						echo "<br />";
					}else{
						$categoria = $alerta->categoria;
						if($categoria != 0 && $categoria != 'TODOS'){
							$query_promociones .= ' and cat.id_categoria = ' . $categoria;
						}
						echo "<br />categoria->" . $categoria ."<br />";
					}
					
					
					$tipo_promocion = $alerta->tipo_promo;
					if($tipo_promocion != 0 && $tipo_promocion != 'TODOS'){
						$query_promociones .= ' and p.tipos_promocion_id_tipo_promocion = ' . $tipo_promocion;
					}
					
					
					
					$formatos = $alerta->formatos;
					echo "formatos ->";
					echo $formatos;
					echo "<br />";
					if($formatos != 0){
						$formatos = explode('|',$formatos);
						$tamanio = count($formatos);
						$formatos = array_slice($formatos, 0, $tamanio - 1);
						$query_promociones .= ' and up.formatos_id_formato in( ';
						foreach($formatos as $formato){
							$query_promociones .= $formato.',';
						}
						$query_promociones = substr_replace($query_promociones ,"",-1) . ' ) ';
						print_r($formatos);
						echo "<br />";
					}else{
						$canal = $alerta->canal;
						if($canal != 0 && $canal != 'TODOS'){
							$query_promociones .= ' and can.id_canal = ' . $canal;
						}
					}
					
					echo "<br />tipo promocion -> ".$tipo_promocion."<br />";
					
					$query_promociones .= ' order by p.fecha_alta desc ';
					
					$query_promociones .= ' limit ' .$limite_promociones .';';
					echo $query_promociones;
					echo "<br />";
					
					$promociones = $this->db->query($query_promociones);
					
					if($promociones->num_rows() > 0){
						$this->email->clear(TRUE);
						$nombre = $this->pdf($promociones, $titulo_alerta);
						
						$mensaje_correo = '<html lang="en">
						<head>
						  <meta charset="utf-8">
						  <meta name="description" content="">
						  <title>Qué Sucede</title>
							
						  <link href="http://quesucede.com.mx/css/bootstrap.css" rel="stylesheet">
						  <link href="http://quesucede.com.mx/css/style.css" rel="stylesheet">
						  <link href="http://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet" type="text/css">
						  
							</head>
					  
						<body>
						<div class="container f_top_bot">
							<div class="row" style="margin-top:20px;">
								<div class="col-md-10">
									<h1>Promociones</h1>
									<h2>'.$titulo_alerta.'</h2>
								</div>
							</div>
										<div class="row">
											
								</div>
						</div>
						
						</body>
						</html>';
						
						$subject = 'mis alertas que sucede';
						$this->email->set_mailtype("html");
						$this->email->from('info@quesucede.com.mx', 'quesucede');
						
						$correo = $usuario->correo;
						
						$this->email->to($correo);
						
						$this->email->subject($subject);
						$this->email->message($mensaje_correo);
						
						$this->email->attach($nombre);
						
						echo "<br /> akiiiiiiiii<br />";
						
						if($this->email->send()){
						//if(1){
							echo "ok";
						}else{
							echo "error";
						}
						
					}else{
						echo "<br />-----no hay------";
					}
				}
			}
			
            
        }
		
		
	}
	
	public function pdf($promociones, $titulo_alerta){
		$data = $this->header_lib->arma_rutas();
		$this->load->library('pdf_lib');
		
		$ahora = date('Y-m-d H:i:s');
		$nombre = 'alerta_'.$ahora;
		
		
		$nombre_pdf = realpath(APPPATH . '../pdf') . '/'.$nombre.'.pdf';
		
		$pdf = new Pdf_lib(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Que sucede');
		$pdf->SetTitle('Qué sucede');
		$pdf->SetSubject('Alertas Qué Sucede');
		$pdf->SetKeywords('TCPDF, PDF, quesucede, promociones, venta');
		
		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		//$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		
		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('helvetica', '', 12, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
		
		

$html = '

<style>

div.test {
	margin-top: 10px;
	margin-bottom:-10px;
	text-align: center;
    }
	
.border_abajo{
	border-bottom: solid 2px #0099CC;
	}

</style>

	<table border="0" cellspacing="0" cellpadding="4">
		<tr>
			<td colspan="4" style="background-color:#4e4e4e;">
				<img src="http://quesucede.com.mx/images/logo_que.svg">
			</td>
		</tr>
		<tr>
		<td colspan="4">Filtro: '.$titulo_alerta.'</td>
		</tr>
		';
		$cont_promo = 1;
		foreach($promociones->result() as $promocion){
			
			
			if($cont_promo == 1){
				$html .= '<tr>';
			}
			$html .='
			<td colspan="2" height="400px;" class="border_abajo">
					<div style="padding:5px;">
						<h3 style="font-size:10px; padding:10px 0 10px 0; margin-bottom:30px; border-bottom: solid 2px #0CF; te">'.$promocion->titulo.'</h3><br />
							
							<img style="" src="http://quesucede.com.mx/images/'.$promocion->img_formato.'">
							
							<img style=" width:190px; height:20px;" src="http://quesucede.com.mx/images/spacer.gif">
							
							<div class="test">
								<img style="width:310px; height:200px;" src="http://quesucede.com.mx/images_promo/'.$promocion->foto.'">
							</div>
						
							<div  style="font-size:11px; text-align:left;">
								Descripción:<br>
								<span style="font-size:10px; color:#666; margin:0px; padding:0px;">'.$promocion->producto.'</span>
								<br />
								<span style="font-size:10px; color:#666; margin:0px; padding:0px;">'.$promocion->descripcion.'</span>
							</div>
					</div>
			</td>
			';
			
			if($cont_promo == 2){
				$html .= '</tr>';
				$cont_promo = 0;
			}
			$cont_promo++;
		}
$html .= '
	</table>
';


echo $html;


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($nombre_pdf, 'F');
		
	return $nombre_pdf;
		//echo $nombre_pdf;
	}
    
}
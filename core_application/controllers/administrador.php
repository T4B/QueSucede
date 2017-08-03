<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('date_helper');
        $this->load->library('header_lib');
        $this->controlador = 'administrador';
    }
    
    public function index(){
        $data = $this->header_lib->arma_rutas();
        
        $sesion_administrador = $this->session->userdata('sesion_administrador');
        
        if($sesion_administrador){
            
            $data = $this->header_lib->arma_menu($data);
            
            $data['categorias'] = $this->db->get('categorias');
            $data['canales'] = $this->db->get('canales');
            $data['formatos'] = $this->db->get('formatos');
            
            $page = 'administrador_page';
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$this->controlador.'/tabs_page', $data);
            $this->load->view('pages/'.$this->controlador.'/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }else{
            $page = 'administrador_login_page';
            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$this->controlador.'/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }
    }
    
    public function login(){
        $this->load->helper('security');
        
        $correo_admin = $this->input->post('correo_admin');
        $password = $this->input->post('pass_admin');
        $password = do_hash($password, 'md5');
        
        $datos_usuario = array(
            'correo_admin' => $correo_admin,
            'password_admin' => $password
        );
        
        $usuario = $this->db->get_where('usuarios_admin', $datos_usuario);
        
        if($usuario->num_rows() > 0){
            $usuario = $usuario->row();
            if($correo_admin == 'oscarb@promored.mx'){
                $this->session->set_userdata('admin_root', TRUE);
            }
            $this->session->set_userdata('id_usuario_admin', $usuario->id_usuario_admin);
            $this->session->set_userdata('sesion_admin', TRUE);
            $this->session->set_userdata('sesion_administrador', TRUE);
            $this->session->set_userdata('login_ok', TRUE);
        }else{
            $this->session->set_flashdata("error_login", "Usuario y/o contraseña incorrectos.");
        }
        
        redirect('/administrador');
    }
    
    public function alta_usuario(){
        
        $sesion_administrador = $this->session->userdata('sesion_administrador');
        
        if($sesion_administrador){
            $data = $this->header_lib->arma_rutas();
            $data = $this->header_lib->arma_menu($data);
            
            $data['categorias'] = $this->db->get('categorias');
            $data['canales'] = $this->db->get('canales');
            $data['formatos'] = $this->db->get('formatos');
            
            if($this->session->userdata('admin_root')){
                $this->load->model('cliente_model');
                
                $clientes = $this->cliente_model->get_all();
                
                $data['clientes'] = $clientes;
                
                
                $page = 'administrador_alta_usuario_page';
                
                $this->load->view('templates/header', $data);
                $this->load->view('pages/'.$this->controlador.'/tabs_page', $data);
                $this->load->view('pages/'.$this->controlador.'/'.$page, $data);
                $this->load->view('templates/footer', $data);
                
            }else{
                redirect('/administrador');
            }
            
            
        }else{
            redirect('/administrador');
        }
        
    }
    
    public function guardar_usuario(){
        $this->load->helper('security');
        
        $codigo = 0;
        $mensaje = '';
        
        $nombre = $this->input->post('nombre');
        $a_paterno = $this->input->post('a_paterno');
        $correo = $this->input->post('correo');
        $pass = $this->input->post('pass');
        $password = do_hash($pass, 'md5');
        $cliente = $this->input->post('cliente');
        
        $datos_usuario = array(
            'correo' => $correo
        );
        
        $usuario_registrado = $this->db->get_where('usuarios', $datos_usuario);
        
        if($usuario_registrado->num_rows() > 0){
            $codigo = -1;
            $mensaje = 'Ese correo ya está registrado';
        }else{
            
            $datos_suscripcion = array(
                'clientes_id_cliente' => $cliente
            );
            
            $suscripcion = $this->db->get_where('suscripciones', $datos_suscripcion);
            
            $id_suscripcion = $suscripcion->row()->id_suscripcion;
            
            $datos_usuario_nuevo = array(
                'correo' => $correo,
                'nombre' => $nombre,
                'a_paterno' => $a_paterno,
                'password' => $password,
                'pass' => $pass,
                'suscripciones_id_suscripcion' => $id_suscripcion,
                'grupos_id_grupo' => 2,
                'activo' => 1
            );
            
            $this->db->insert('usuarios', $datos_usuario_nuevo);
            
            $codigo = $this->db->_error_number();
            
            if($codigo == 0){
                $mensaje = 'Usuario creado correctamente';
            }else{
                echo $this->db->_error_message();
                $mensaje = 'Error al crear el usuario';
            }
        }
        
        
        $response = array(
            'codigo' => $codigo,
            'mensaje' => $mensaje
        );
        
        echo json_encode($response);
    }
    
    public function capturar_promocion(){
        $sesion_administrador = $this->session->userdata('sesion_administrador');
        
        if($sesion_administrador){
            $this->load->model('marca_model');
            $this->load->model('subcategoria_model');
            $this->load->model('formato_model');
            $this->load->model('ubicacion_model');
            $this->load->model('tipo_promocion_model');
            $this->load->model('estado_model');
            
            $data = $this->header_lib->arma_rutas();
            $data = $this->header_lib->arma_menu($data);
            
            $data['categorias'] = $this->db->get('categorias');
            $data['canales'] = $this->db->get('canales');
            $data['formatos'] = $this->db->get('formatos');
            $data['subcategorias'] = $this->subcategoria_model->get_all();
            $data['marcas'] = $this->marca_model->get_all();
            $data['formatos'] = $this->formato_model->get_all();
            $data['estados'] = $this->estado_model->get_all();
            $data['ubicaciones'] = $this->ubicacion_model->get_all();
            $data['tipos_promocion'] = $this->tipo_promocion_model->get_all();
            
            $page = 'capturar_promocion_page';
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$this->controlador.'/tabs_page', $data);
            $this->load->view('pages/'.$this->controlador.'/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }
    }
    
    public function guardar_promocion(){
        
        $mensaje = '';
        
        $this->load->library('upload_lib');
        $upload_path = '/images_upload';
        $field_name = 'foto';
        
        $response = $this->upload_lib->upload($field_name, $upload_path);
        $foto = $response['nombre'];
        
        if($foto != '-1'){
            $ruta_imagen = realpath(APPPATH . '../images_upload') . "/" . $foto;
            $nueva_ruta = realpath(APPPATH . '../images_promo') . "/" . $foto;
            
            $image_overlay = realpath(APPPATH . '../images/wm.png');
            
            $config['source_image']	= $ruta_imagen;
            $config['wm_overlay_path'] = $image_overlay;
            $config['wm_type'] = 'overlay';
            $config['new_image'] = $nueva_ruta;
            $config['wm_font_color'] = 'ffffff';
            $config['wm_vrt_alignment'] = 'bottom';
            $config['wm_hor_alignment'] = 'center';
            $config['wm_padding'] = '20';
            
            try{
                $this->load->library('image_lib');
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->watermark();
            }catch(Exception $e){
                    echo "<br />exc";
            }
            
            $ahora = date('Y-m-d H:i:s');
            $semana = date('W');
            $anio = date('Y');
            $ver_index = 1;
            
            $subcategoria = $this->input->post('subcategoria');
            $marca = $this->input->post('marca');
            $precio = $this->input->post('precio');
            $producto = $this->input->post('producto');
            $titulo = $this->input->post('titulo');
            $tipo_promocion = $this->input->post('tipo_promocion');
            $encuesta = 0;
            
            $vigencia = $this->input->post('vigencia');
            $desc_vigencia = $vigencia == 'SI' ? $vigencia : $this->input->post('desc_vigencia');
            $fecha_inicio = $vigencia == 'SI' ? $this->input->post('fecha_inicio'): 'N/A';
            $fecha_fin = $vigencia == 'SI' ? $this->input->post('fecha_fin'): 'N/A';
            $descripcion = $this->input->post('descripcion');
            $mecanica = $this->input->post('mecanica');
            $regalo = $this->input->post('regalo');
            
            $datos = array(
                'subcategorias_id_subcategoria' => $subcategoria,
                'marcas_id_marca' => $marca,
                'precio' => $precio,
                'producto' => $producto,
                'titulo' => $titulo,
                'tipos_promocion_id_tipo_promocion' => $tipo_promocion,
                'semana_inicio' => $semana,
                'anio' => $anio,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'vigencia' => $desc_vigencia,
                'descripcion' => $descripcion,
                'mecanica' => $mecanica,
                'regalo' => $regalo,
                'foto' => $foto,
                'fecha_alta' => $ahora,
                'ver_index' => $ver_index,
                'encuesta' => $encuesta
            );
            
            $this->db->insert('promociones', $datos);
            
            if($this->db->_error_number() == 0){
                $id_formato = $this->input->post('formato');
                $id_estado = $this->input->post('estado');
                $ubicacion = $this->input->post('ubicacion');
                $activa = 1;
                
                $this->db->where($datos);
                $id_promocion = $this->db->get('promociones')->row()->id_promocion;

                $datos = array(
                    'promociones_id_promocion' => $id_promocion,
                    'estados_id_estado' => $id_estado,
                    'formatos_id_formato' => $id_formato,
                    'ubicaciones_id_ubicacion' => $ubicacion,
                    'semana' => $semana,
                    'activa' => $activa,
                    'anio' => $anio,
                    'precio' => $precio
                );
                
                $this->db->insert('ubicacion_promocion', $datos);
                
                $this->db->order_by('id_promocion','asc');
                $this->db->where('ver_index', 1);
                $this->db->where('id_promocion !=', $id_promocion);
                $this->db->limit(1);
                $id_promocion_index = $this->db->get('promociones')->row()->id_promocion;
                $this->db->where('id_promocion', $id_promocion_index);
                $this->db->update('promociones', array('ver_index' => 0));

                $mensaje = 'Promoción agregada correctamente con id - ' . $id_promocion;
                
            }else{
                $mensaje = 'Ocurrió un error al agregar la promoción';
            }
        }else{
            $mensaje = 'Ocurrió un error con la fotografía.';
            $mensaje = $response['mensaje'];
        }
        //Termina error de foto
        
        $this->session->set_flashdata('mensaje', $mensaje);
        
        redirect('/administrador/capturar_promocion');
        
    }
    
    public function recurrentes(){
        $data = $this->header_lib->arma_rutas();
        $sesion_administrador = $this->session->userdata('sesion_administrador');
        
        if($sesion_administrador){
            
            $this->load->model('estado_model');
            $this->load->model('ubicacion_model');
            
            $data = $this->header_lib->arma_menu($data);
            
            $this->db->order_by('descripcion', 'asc');
            $promociones = $this->db->get('promociones');
            $data['promociones'] = $promociones;
            
            $data['estados'] = $this->estado_model->get_all();
            $data['ubicaciones'] = $this->ubicacion_model->get_all();
            
            $anio = date('Y');
            $data['anio'] = $anio;
            $data['anio_anterior'] = --$anio;
            
            
            
            $page = 'promociones_recurrentes_page';
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$this->controlador.'/tabs_page', $data);
            $this->load->view('pages/'.$this->controlador.'/'.$page, $data);
            $this->load->view('templates/footer', $data);
            
        }else{
            $page = 'administrador_login_page';
            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$this->controlador.'/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }
        
    }
    
    public function guardar_recurrente(){
        $id_promocion = $this->input->post('id_promocion_recurrente');
        $id_formato = $this->input->post('formato_recurrente');
        $id_estado = $this->input->post('estado_recurrente');
        $ubicacion = $this->input->post('ubicacion_recurrente');
        
        $semana = $this->input->post('semana_recurrente');
        $activa = $this->input->post('activa_recurrente');
        $anio = $this->input->post('anio_recurrente');
        $precio = $this->input->post('precio_recurrente');
        
        $datos = array(
            'promociones_id_promocion' => $id_promocion,
            'estados_id_estado' => $id_estado,
            'formatos_id_formato' => $id_formato,
            'ubicaciones_id_ubicacion' => $ubicacion,
            'semana' => $semana,
            'activa' => $activa,
            'anio' => $anio,
            'precio' => $precio
        );
        
        $this->db->insert('ubicacion_promocion', $datos);
        
        $codigo = $this->db->_error_number();
        
        $response = array(
            'codigo' => $codigo
        );
        
        echo json_encode($response);
    }
    
    public function alta_admin(){
        $sesion_administrador = $this->session->userdata('sesion_administrador');
        
        if($sesion_administrador){
            $data = $this->header_lib->arma_rutas();
            $data = $this->header_lib->arma_menu($data);
            
            $data['categorias'] = $this->db->get('categorias');
            $data['canales'] = $this->db->get('canales');
            $data['formatos'] = $this->db->get('formatos');
            
            if($this->session->userdata('admin_root')){
                $page = 'administrador_alta_admin_page';
                
                $this->load->view('templates/header', $data);
                $this->load->view('pages/'.$this->controlador.'/tabs_page', $data);
                $this->load->view('pages/'.$this->controlador.'/'.$page, $data);
                $this->load->view('templates/footer', $data);
            }else{
                redirect('/administrador');
            }
            
            
        }else{
            redirect('/administrador');
        }
    }
    
    public function guardar_admin(){
        $this->load->helper('security');
        
        $codigo = 0;
        $mensaje = '';
        
        $nombre_admin = $this->input->post('nombre');
        $correo_admin = $this->input->post('correo');
        $pass = $this->input->post('pass');
        $password = do_hash($pass, 'md5');
        
        $datos_usuario = array(
            'correo_admin' => $correo_admin
        );
        
        $usuario_registrado = $this->db->get_where('usuarios_admin', $datos_usuario);
        
        if($usuario_registrado->num_rows() > 0){
            $codigo = -1;
            $mensaje = 'Ese correo ya está registrado';
        }else{
            $datos_usuario_nuevo = array(
                'correo_admin' => $correo_admin,
                'pass_admin' => $pass,
                'password_admin' => $password,
                'nombre_admin' => $nombre_admin
            );
            
            $this->db->insert('usuarios_admin', $datos_usuario_nuevo);
            
            $codigo = $this->db->_error_number();
            
            if($codigo == 0){
                $mensaje = 'Usuario creado';
            }else{
                $mensaje = 'Error al crear usuario';
            }
            
        }
        
        
        $response = array(
            'codigo' => $codigo,
            'mensaje' => $mensaje
        );
        
        echo json_encode($response);
    }
    
    public function obtener_promociones(){
        $criterio = $this->input->post('criterio');
        
        $query = '
            SELECT id_promocion, titulo, descripcion
            from promociones
            where titulo like "%'.$criterio.'%"
            or descripcion like "%'.$criterio.'%"
        ';
        
        $promociones = $this->db->query($query);
        
        if($promociones->num_rows() > 0){
            $promociones = $promociones->result_array();
            $codigo = 0;
        }else{
            $promociones = '';
            $codigo = -1;
        }
        
        $response = array(
            'codigo' => $codigo,
            'promociones' => $promociones
        );
        
        echo json_encode($response);
    }
    
    public function actualizarFoto(){
        $this->load->library('upload_lib');
        $upload_path = '/images_upload';
        $field_name = 'foto';
        
        $idPromocion = $this->input->post('idPromocion');
        
        $response = $this->upload_lib->upload($field_name, $upload_path);
        $foto = $response['nombre'];
        
        if($foto != '-1'){
            
            $ruta_imagen = realpath(APPPATH . '../images_upload') . "/" . $foto;
            $nueva_ruta = realpath(APPPATH . '../images_promo') . "/" . $foto;
            
            $image_overlay = realpath(APPPATH . '../images/wm.png');
            
            $config['source_image']	= $ruta_imagen;
            $config['wm_overlay_path'] = $image_overlay;
            $config['wm_type'] = 'overlay';
            $config['new_image'] = $nueva_ruta;
            $config['wm_font_color'] = 'ffffff';
            $config['wm_vrt_alignment'] = 'bottom';
            $config['wm_hor_alignment'] = 'center';
            $config['wm_padding'] = '20';
            
            try{
                $this->load->library('image_lib');
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->watermark();
            }catch(Exception $e){
                    echo "<br />exc";
            }
            
            $datosPromocion = array(
                'id_promocion' => $idPromocion
            );
            
            $datosUpdate = array(
                'foto' => $foto
            );
            
            $this->db->where($datosPromocion);
            $this->db->update('promociones', $datosUpdate);
            
            if($this->db->_error_number() == 0){
                $mensaje = 'Foto actualizada.';
            }else{
                $mensaje = 'Error al actualizar la foto.';
            }
            
        }else{
            $mensaje = 'Ocurrió un error con la fotografía.';
            $mensaje = $response['mensaje'];
        }
        
        $this->session->set_flashdata('mensaje', $mensaje);
        
        redirect('/admin');
    }
    
}


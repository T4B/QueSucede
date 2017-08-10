<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Folletos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('header_lib');
        $this->load->library('login_lib');
        $this->load->library('suscripcion_lib');
        $this->load->helper('security');
        $this->load->library('paginacion_lib');

    }

    public function index()
    {
        $data = $this->header_lib->arma_rutas();

        if ($this->login_lib->verifica_login()) {
            $data = $this->header_lib->arma_menu($data);
        } else {
            redirect('/');
        }

        $formatos = $this->db->get('formatos');

        $array_folletos = array();

        foreach ($formatos->result() as $formato) {
            $query_folleto = '
				select * from folletos where formatos_id_formato = ' . $formato->id_formato . '
				order by fecha_inicio desc;
			';
            $folleto = $this->db->query($query_folleto);
            if ($folleto->num_rows() > 0) {
                $folleto = $folleto->row_array();
                $folleto['img_folleto'] = $formato->img_folleto;
                array_push($array_folletos, $folleto);
            }
        }

        //Consulta con paginación
        $elementos_por_pagina = 100;
        $num_pagina = 1;

        $response_pag = $this->paginacion_lib->paginar($array_folletos, $elementos_por_pagina, $num_pagina);
        $tabla_folletos = $response_pag['tabla'];
        $total_paginas = $response_pag['total_paginas'];
        $paginacion = $response_pag['array_paginas'];

        $data['total_paginas'] = $total_paginas;
        $data['folletos'] = $tabla_folletos;
        $data['pagina_actual'] = $num_pagina;
        $data['paginacion'] = $paginacion;

        //$data['folletos'] = $array_folletos;
        $data['es_index'] = TRUE;

        $page = 'folletos_page';


        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);

    }

    public function formato($formato = NULL)
    {

        $data = $this->header_lib->arma_rutas();

        if (!$formato) {
            redirect('/');
        }


        if ($this->login_lib->verifica_login()) {
            $data = $this->header_lib->arma_menu($data);
        } else {
            redirect('/');
        }

        $query_folletos = '
			select f.id_folleto, f.formatos_id_formato, f.desc_fecha, f.periodo, f.pdf,
			f.portada, f.ruta, form.img_folleto
			from folletos as f
			left join formatos as form on form.id_formato = f.formatos_id_formato
			where 1 
		';

        if ($formato != '' && $formato != 'TODOS') {
            $query_folletos .= ' and f.formatos_id_formato =  ' . $formato;
        }

        $query_folletos .= '  order by f.fecha_inicio desc ';

        $this->paginacion_lib->set_variable('query_foll', $query_folletos);

        $elementos_por_pagina = 4;
        $num_pagina = 1;

        $response_pag = $this->paginacion_lib->pag_consulta('query_foll', $elementos_por_pagina, $num_pagina);
        $tabla_folletos = $response_pag['tabla'];
        $total_paginas = $response_pag['total_paginas'];
        $paginacion = $response_pag['array_paginas'];

        $data['folletos'] = $tabla_folletos;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $num_pagina;
        $data['paginacion'] = $paginacion;

        $page = 'folletos_page';

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function detalle($id_folleto = NULL)
    {

        if (!$id_folleto) {
            redirect('/');
        }

        $data = $this->header_lib->arma_rutas();

        if ($this->login_lib->verifica_login()) {
            $data = $this->header_lib->arma_menu($data);
        }

        $query_folleto = '
			select f.id_folleto, f.formatos_id_formato, f.desc_fecha, f.periodo, f.pdf,
			f.portada, f.ruta, form.img_folleto
			from folletos as f
			left join formatos as form on form.id_formato = f.formatos_id_formato
			where f.id_folleto = ' . $id_folleto . '
			order by f.fecha_inicio desc;
		';

        //$folleto = $this->db->get_where('folletos', array('id_folleto' => $id_folleto));

        $folleto = $this->db->query($query_folleto);

        $data['folleto'] = $folleto->row();

        $page = 'detalle_folleto_page';

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);

    }

    public function download($ruta = NULL, $archivo = NULL)
    {

        $this->load->helper('download');

        $data = $data = file_get_contents(realpath(APPPATH . '..') . '/src_folletos/' . $ruta . '/' . $archivo);
        $name = $archivo;

        force_download($name, $data);
    }

    public function buscar()
    {

        $data = $this->header_lib->arma_rutas();

        if ($this->login_lib->verifica_login()) {
            $data = $this->header_lib->arma_menu($data);
        } else {
            redirect('/');
        }

        if ($this->input->post()) {

            $formato = $this->input->post('formato');
            $fecha_inicio = $this->input->post('fecha_inicio');
            $fecha_fin = $this->input->post('fecha_fin');

            $query_folletos = '
				select f.id_folleto, f.formatos_id_formato, f.desc_fecha, f.periodo, f.pdf,
				f.portada, f.ruta, form.img_folleto
				from folletos as f
				left join formatos as form on form.id_formato = f.formatos_id_formato
				where 1 
			';

            if ($formato != '' && $formato != 'TODOS') {
                $query_folletos .= ' and f.formatos_id_formato =  ' . $formato;
            }

            if ($fecha_inicio != '') {
                $query_folletos .= ' and f.fecha_inicio >= \'' . $fecha_inicio . '\'';
            }

            if ($fecha_fin != '') {
                $query_folletos .= ' and f.fecha_inicio <= \'' . $fecha_fin . '\'';
            }


            $query_folletos .= '  order by f.fecha_inicio desc ';

            //$this->session->set_userdata('query_foll', $query_folletos);

            $this->paginacion_lib->set_variable('query_foll', $query_folletos);

            $elementos_por_pagina = 4;
            $num_pagina = 1;

            $response_pag = $this->paginacion_lib->pag_consulta('query_foll', $elementos_por_pagina, $num_pagina);
            $tabla_folletos = $response_pag['tabla'];
            $total_paginas = $response_pag['total_paginas'];
            $paginacion = $response_pag['array_paginas'];

            $data['folletos'] = $tabla_folletos;
            $data['total_paginas'] = $total_paginas;
            $data['pagina_actual'] = $num_pagina;
            $data['paginacion'] = $paginacion;

            $page = 'folletos_page';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer', $data);

        } else {
            redirect('/');
        }
    }

    public function pag($pagina = NULL)
    {

        if (!$pagina) {
            redirect('/folletos');
        }

        $data = $this->header_lib->arma_rutas();

        if ($this->login_lib->verifica_login()) {
            $data = $this->header_lib->arma_menu($data);
        } else {
            redirect('/');
        }

        $elementos_por_pagina = 4;
        $num_pagina = $pagina;

        $response_pag = $this->paginacion_lib->pag_consulta('query_foll', $elementos_por_pagina, $num_pagina);
        $tabla_folletos = $response_pag['tabla'];
        $total_paginas = $response_pag['total_paginas'];
        $paginacion = $response_pag['array_paginas'];

        $data['folletos'] = $tabla_folletos;
        $data['total_paginas'] = $total_paginas;
        $data['pagina_actual'] = $num_pagina;
        $data['paginacion'] = $paginacion;


        $page = 'folletos_page';

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function subir()
    {

        date_default_timezone_set("America/Mexico_City");

        $id_formato = $this->input->post("formato");

        $ruta_folleto = $this->db->get_where("formatos", array("id_formato" => $id_formato))->row()->ruta_folleto;
        $upload_path = '/src_folletos/' . $ruta_folleto;

        $nombre_portada = $this->upload('portada', $upload_path);


        $nombre_pdf = $this->upload('pdf', $upload_path);

        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');

        $fecha_inicio = explode("/", $fecha_inicio);
        $fecha_fin = explode("/", $fecha_fin);

        $arr_long_months = array('January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December');

        $arr_meses_largos = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');

        $arr_meses_cortos = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');

        if ($fecha_inicio[0] == $fecha_fin[0]) {

            if ($fecha_inicio[1] == $fecha_fin[1]) {
                $fecha_inicio = date("j ", mktime(0, 0, 0, $fecha_inicio[1], $fecha_inicio[2], $fecha_inicio[0]));
                $fecha_fin = date("j \d\e F \d\e Y", mktime(0, 0, 0, $fecha_fin[1], $fecha_fin[2], $fecha_fin[0]));

                $fecha_inicio = str_replace($arr_long_months, $arr_meses_largos, $fecha_inicio);
                $fecha_fin = str_replace($arr_long_months, $arr_meses_largos, $fecha_fin);
            } else {
                $fecha_inicio = date("j \d\e F", mktime(0, 0, 0, $fecha_inicio[1], $fecha_inicio[2], $fecha_inicio[0]));
                $fecha_fin = date("j \d\e F \d\e Y", mktime(0, 0, 0, $fecha_fin[1], $fecha_fin[2], $fecha_fin[0]));

                $fecha_inicio = str_replace($arr_long_months, $arr_meses_cortos, $fecha_inicio);
                $fecha_fin = str_replace($arr_long_months, $arr_meses_cortos, $fecha_fin);
            }


        } else {
            $fecha_inicio = date("j \d\e F \d\e Y", mktime(0, 0, 0, $fecha_inicio[1], $fecha_inicio[2], $fecha_inicio[0]));
            $fecha_fin = date("j \d\e F \d\e Y", mktime(0, 0, 0, $fecha_fin[1], $fecha_fin[2], $fecha_fin[0]));

            $fecha_inicio = str_replace($arr_long_months, $arr_meses_cortos, $fecha_inicio);
            $fecha_fin = str_replace($arr_long_months, $arr_meses_cortos, $fecha_fin);
        }


        $periodo = 'Del ' . $fecha_inicio . ' al ' . $fecha_fin;

        $datos = array(
            'formatos_id_formato' => $id_formato,
            'fecha_inicio' => $this->input->post('fecha_inicio'),
            'desc_fecha' => $this->input->post('fecha_texto'),
            'periodo' => $periodo,
            'pdf' => $nombre_pdf,
            'portada' => $nombre_portada,
            'ruta' => $ruta_folleto
        );

        $this->db->insert('folletos', $datos);

        redirect('/admin');
    }

    function upload($field_name, $upload_path)
    {

        $this->load->library('aws_sdk');
        $now = time();
        $gmt = local_to_gmt($now);
        $ext = explode('.', $_FILES[$field_name]['name']);
        $file_name = substr($_FILES[$field_name]['name'], 0, 3) . $gmt;
        $indice = count($ext) - 1;
        $nombre_archivo = $file_name . '.' . $ext[$indice];
        $data = array(
            'Bucket' => 'quesucede'.$upload_path,
            'Key' => $nombre_archivo,
            'ACL' => 'public-read',
            'SourceFile' => ($_FILES[$field_name]['tmp_name']),
            'ContentType' => mime_content_type($_FILES[$field_name]['tmp_name'])
        );
        $aws_object = $this->aws_sdk->saveObject($data)->toArray();
        return $nombre_archivo;
    }
}


<?php
class Promocion_model extends CI_Model {
    public function __construct()
    {
		
    }
    
    
    public function get_all()
    {
        $query = "SELECT tp.id_promocion, tcat.nombre_categoria, tmarc.nombre_marca, tp.imagen, tp.descripcion_promocion as decripcion, tcat.clase_categoria
				from promociones as tp, categorias as tcat, marcas as tmarc
				where tp.categorias_id_categoria = tcat.id_categoria
				and tp.marcas_id_marca = tmarc.id_marca";
		
		$result = $this->db->query($query);
		
        //$result = $this->db->get('promociones');
		
        return $result;
    }
    
	public function get_top($cant)
    {
		
		$query = "SELECT distinct tp.id_promocion, tp.descripcion_promocion as decripcion, tp.imagen,
				tcat.clase_categoria, tcat.nombre_categoria, tmarc.nombre_marca
				from promociones as tp, categorias as tcat, marcas as tmarc
				where tp.marcas_id_marca = tmarc.id_marca
				and tmarc.categorias_id_categoria = tcat.id_categoria LIMIT ".$cant;
		
		$result = $this->db->query($query);
		
        return $result;
    }
	
	public function get_param($clave, $valor){
		
		$query = "SELECT DISTINCT tp.id_promocion, tp.visitas, tp.titulo_promocion, tp.fecha_inicio, tp.fecha_fin,
		
				tcat.clase_categoria, tcat.nombre_categoria, tp.descripcion_promocion,
				tp.producto, tp.mecanica, tp.imagen, marcas.logo_marca, marcas.nombre_marca,
				tform.nombre_formato, ttipo.nombre_tipo_promocion, tcan.nombre_canal, tiendas.nombre_tienda
				
				from promociones as tp, formatos as tform, tipos_promocion as ttipo,
				categorias as tcat,canales as tcan, marcas, tiendas
				
				where tform.canales_id_canal = tcan.id_canal
				and tp.tiendas_id_tienda = tiendas.id_tienda
				and tiendas.formatos_id_formato = tform.id_formato
				and marcas.categorias_id_categoria = tcat.id_categoria
				and tp.tipos_promocion_id_tipo_promocion = ttipo.id_tipo_promocion
				and tp.marcas_id_marca = marcas.id_marca";
		
		if($clave == "id_categoria"){
			$query .= " and ($clave = $valor or padre_categoria = $valor or categoria_principal = $valor)";
		}else{
			$query .= " and $clave = $valor";
		}
		
		$query .= " order by tp.fecha_registro desc";
		
		$result = $this->db->query($query);
		
		return $result;
	}
	
	public function busqueda_avanzada($array){
		$query = "SELECT DISTINCT tp.id_promocion, tp.titulo_promocion, tp.fecha_inicio, tp.fecha_fin, tcat.clase_categoria,
				tp.descripcion_promocion, tp.mecanica, tp.imagen, marcas.logo_marca, productos.logo_producto,
				tform.nombre_formato, ttipo.nombre_tipo_promocion, tcan.nombre_canal
				
				from promociones as tp, formatos as tform, tipos_promocion as ttipo, formatos_sucursales as tforsuc,
				categorias as tcat,canales as tcan, marcas, productos
				
				where tp.id_formato_sucursal = tforsuc.id_formato_sucursal
				and tforsuc.formatos_id_formato = tform.id_formato
				and tform.canales_id_canal = tcan.id_canal
				and tp.categorias_id_categoria = tcat.id_categoria
				and tp.tipos_promocion_id_tipo_promocion = ttipo.id_tipo_promocion
				and tp.id_producto = productos.id_producto
				and tp.marcas_id_marca = marcas.id_marca";
				
		
		foreach($array as $key => $value){
			$query .= ' and tp.' . $key . ' = ' . $value ;
		}
		
		$result = $this->db->query($query);
		
		return $result;
	}
	
	public function get_like($criterio){
		$query = "SELECT DISTINCT tp.id_promocion, tp.titulo_promocion, tp.fecha_inicio,
				tp.fecha_fin, tcat.clase_categoria, productos.logo_producto,
				tp.descripcion_promocion, tp.mecanica, tp.imagen, marcas.logo_marca,  
				tform.nombre_formato, ttipo.nombre_tipo_promocion, tcan.nombre_canal
				
				from promociones as tp, formatos as tform, tipos_promocion as ttipo, formatos_sucursales as tforsuc,
				categorias as tcat,canales as tcan, marcas, productos
				
				where tp.id_formato_sucursal = tforsuc.id_formato_sucursal
				and tforsuc.formatos_id_formato = tform.id_formato
				and tform.canales_id_canal = tcan.id_canal
				and tp.categorias_id_categoria = tcat.id_categoria
				and tp.tipos_promocion_id_tipo_promocion = ttipo.id_tipo_promocion
				and tp.marcas_id_marca = marcas.id_marca
				and tp.id_producto = productos.id_producto
				and (tp.descripcion_promocion like '%$criterio%'
					or tp.mecanica like '%$criterio%'
					or tform.nombre_formato like '%$criterio%'
					or marcas.nombre_marca like '%$criterio%'
					or tp.titulo_promocion like '%$criterio%')";
			
			$query = "SELECT DISTINCT tp.id_promocion, tp.visitas, tp.titulo_promocion, tp.fecha_inicio, tp.fecha_fin,
		
				tcat.clase_categoria, tcat.nombre_categoria, tp.descripcion_promocion,
				tp.producto, tp.mecanica, tp.imagen, marcas.logo_marca, marcas.nombre_marca,
				tform.nombre_formato, ttipo.nombre_tipo_promocion, tcan.nombre_canal, tiendas.nombre_tienda
				
				from promociones as tp, formatos as tform, tipos_promocion as ttipo,
				categorias as tcat,canales as tcan, marcas, tiendas
				
				where tform.canales_id_canal = tcan.id_canal
				and tp.tiendas_id_tienda = tiendas.id_tienda
				and tiendas.formatos_id_formato = tform.id_formato
				and marcas.categorias_id_categoria = tcat.id_categoria
				and tp.tipos_promocion_id_tipo_promocion = ttipo.id_tipo_promocion
				and tp.marcas_id_marca = marcas.id_marca
				and (tp.descripcion_promocion like '%$criterio%'
					or tp.mecanica like '%$criterio%'
					or tform.nombre_formato like '%$criterio%'
					or marcas.nombre_marca like '%$criterio%'
					or tp.titulo_promocion like '%$criterio%')";
			
			$result = $this->db->query($query);
			
			return $result;
	}
	
	public function get($id){
		
		$query_promocion = '
			select p.id_promocion, p.ver_index, p.precio, p.descripcion, p.titulo, p.producto, p.foto, p.vigencia, p.mecanica, p.regalo,
			m.logo_marca, m.nombre_marca, cat.nombre_categoria, sub.nombre_subcategoria,
			tp.nombre_tipo_promocion, up.formatos_id_formato, u.nombre_ubicacion
			from promociones as p
			left join marcas as m on m.id_marca = p.marcas_id_marca
			left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
			left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
			left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
			left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
			left join ubicaciones as u on u.id_ubicacion = up.ubicaciones_id_ubicacion
			where p.id_promocion = ' . $id . ';';
			
			
		return $this->db->query($query_promocion)->row();
	}
	
	public function add_visitas($id){
		
		$result = $this->db->get_where('promociones', array('id_promocion' => $id));
		
		$row = $result->row();
		
		$visitas = $row->visitas;
		$visitas += 1;
		
		$data = array(
               'visitas' => $visitas
            );

		$this->db->where('id_promocion', $id);
		$this->db->update('promociones', $data); 
		
		return $visitas;
	}
	
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
	
	public function get_ranking_top($num){
		
		$query = '
			select distinct(p.id_promocion), concat(left(p.titulo, 15), "...") as titulo, p.foto, m.logo_marca, cat.nombre_categoria, sub.nombre_subcategoria,
			tp.nombre_tipo_promocion, up.formatos_id_formato, m.nombre_marca
			from promociones as p
			left join marcas as m on m.id_marca = p.marcas_id_marca
			left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
			left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
			left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
			left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
			group by p.id_promocion
			order by p.visitas desc
			limit '.$num.';';
		
		$result = $this->db->query($query);
		
		return $result;
	}
	
	public function get_destacados($num){
		
		$query = "SELECT DISTINCT tp.id_promocion, tp.visitas, tp.titulo_promocion, tp.fecha_inicio, tp.fecha_fin,
		
				tcat.clase_categoria, tcat.nombre_categoria, tp.descripcion_promocion,
				tp.producto, tp.mecanica, tp.imagen, marcas.logo_marca, marcas.nombre_marca,
				tform.nombre_formato, ttipo.nombre_tipo_promocion, tcan.nombre_canal, tiendas.nombre_tienda
				
				from promociones as tp, formatos as tform, tipos_promocion as ttipo,
				categorias as tcat,canales as tcan, marcas, tiendas
				
				where tform.canales_id_canal = tcan.id_canal
				and tp.tiendas_id_tienda = tiendas.id_tienda
				and marcas.categorias_id_categoria = tcat.id_categoria
				and tp.tipos_promocion_id_tipo_promocion = ttipo.id_tipo_promocion
				and tp.marcas_id_marca = marcas.id_marca
				and tp.destacado = 1
				LIMIT $num";
				
		$result = $this->db->query($query);
		
		return $result;
	}
	
	
	public function get_ultimos($num){
		
		$query = '
			select distinct(p.id_promocion), concat(left(p.titulo, 15), "...") as titulo, p.foto, m.logo_marca, cat.nombre_categoria, sub.nombre_subcategoria,
			tp.nombre_tipo_promocion, up.formatos_id_formato, m.nombre_marca
			from promociones as p
			left join marcas as m on m.id_marca = p.marcas_id_marca
			left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
			left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
			left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
			left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
			group by p.id_promocion
			order by p.fecha_alta desc
			limit '.$num.';';
			
		$result = $this->db->query($query);
		
		return $result;
	}
	
	public function get_random($num){
		
		$ahora = resta_dias(date("Y-m-d H:i:s"), 30);
		
		$query_promociones = '
			select p.id_promocion, concat(left(p.titulo, 15), "...") as titulo, p.foto, m.logo_marca, m.nombre_marca,
			cat.nombre_categoria, sub.nombre_subcategoria, tp.nombre_tipo_promocion, up.formatos_id_formato
			from promociones as p
			left join marcas as m on m.id_marca = p.marcas_id_marca
			left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
			left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
			left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
			left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
			left join formatos as form on up.formatos_id_formato = form.id_formato
			left join canales as can on can.id_canal = form.canales_id_canal
			where 1
			group by p.id_promocion
			order by rand()
			limit '.$num.';
		';
		
		/*
		$query_promociones ='
		select distinct(p.id_promocion), concat(left(p.titulo, 15), "...") as titulo, p.foto, m.logo_marca, cat.nombre_categoria, sub.nombre_subcategoria,
		tp.nombre_tipo_promocion, up.formatos_id_formato
		from promociones as p
		left join marcas as m on m.id_marca = p.marcas_id_marca
		left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
		left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
		left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
		left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
		group by p.id_promocion
		order by rand()
		limit '.$num.';';
		*/
		
		//where p.fecha_alta >= \''.$ahora.'\'
		
		$promociones = $this->db->query($query_promociones);
		
		return $promociones;
	}
	
	public function get_index(){
		
		$query = '
			select distinct(p.id_promocion), concat(left(p.titulo, 15), "...") as titulo, p.foto, m.logo_marca, cat.nombre_categoria, sub.nombre_subcategoria,
			tp.nombre_tipo_promocion, up.formatos_id_formato, m.nombre_marca
			from promociones as p
			left join marcas as m on m.id_marca = p.marcas_id_marca
			left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
			left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
			left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
			left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
			where p.ver_index = 1
			group by p.id_promocion
			order by p.fecha_alta desc
			limit 4;';
			
		$result = $this->db->query($query);
		
		return $result;
	}
	
}

?>
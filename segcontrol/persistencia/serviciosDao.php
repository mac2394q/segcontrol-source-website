<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/directorio.php');
require_once (PERSISTENCIA_PATH."DataSource.php");
require_once (MODEL_PATH."servicios.php");
require_once (MODEL_PATH."minuta.php");
require_once (MODEL_PATH."conductor.php");
require_once (MODEL_PATH."vehiculo.php");
class serviciosDao{


  public function verificarMinuta($id){
    $data_source = new DataSource();
    $data_table = $data_source->ejecutarConsulta("SELECT servicio_novedad.idservicio_novedad as minuta, servicio_novedad.fecha_novedad
       FROM servicio join servicio_novedad on(servicio.id_servicio=servicio_novedad.id_servicio)
       where servicio.estado ='ACTIVO' and servicio.id_servicio= ".$id." order by servicio_novedad.idservicio_novedad DESC");

    $objServicios = null;
    date_default_timezone_set('america/bogota');
    $fecha = new DateTime();
    $actual =$fecha->getTimestamp();
    $from_time =strtotime($data_table[0]['fecha_novedad']) ;
    $dif =round(($actual -$from_time) / 60,0);
    $var=$dif-60;

      if(intval($var) < -15){
        $resultado=3;

      }else{
        if(intval($var) < 0){
           $resultado=2;

        }else {
          $resultado=1;

        }
      }
      return $resultado;

    }

  public function ultimoID(){
        $data_source = new DataSource();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM  `servicio` ORDER BY  id_servicio DESC ");
        return $data_table[0]["id_servicio"];
  }
  public function numeroServiciosActivos(){
    $data_source = new DataSource();
    $data_table = $data_source->ejecutarConsulta("SELECT count(*) as 'n' FROM `servicio` WHERE estado='ACTIVO'");
    if(count($data_table) >= 1){
      $n=$data_table[0]['n'];
      return $n;
    }else{
      return 0;
    }
  }

  public function listaServicios(){
    $data_source = new DataSource();
    $data_table = $data_source->ejecutarConsulta("SELECT * FROM `servicio`");
    $objServicios = null;
    $arrayServicios = array();
    if(count($data_table) >0){
      foreach ($data_table as $clave => $valor) {
        $objServicios = new servicio(
          $data_table[$clave]["id_servicio"],
          $data_table[$clave]["id_conductor"],
          $data_table[$clave]["id_vehiculo"],
          $data_table[$clave]["id_cliente"],
          $data_table[$clave]["id_empleado"],
          $data_table[$clave]["manifiesto"],
          $data_table[$clave]["fecha_creacion"],
          $data_table[$clave]["fecha_fin"],
          $data_table[$clave]["estado"],
          $data_table[$clave]["satelital"],
          $data_table[$clave]["ciudad_origen"],
          $data_table[$clave]["ciudad_destino"],
          $data_table[$clave]["direccion_descargue"],
          $data_table[$clave]["sello"],
          $data_table[$clave]["numero_contenedor"],
          $data_table[$clave]["link_localizador"],
          $data_table[$clave]["usuario_satelital"],
          $data_table[$clave]["clave_satelital"],
          $data_table[$clave]["ruta"]);
          array_push($arrayServicios, $objServicios);
        }
        return $arrayServicios;
      }else{
        return null;
      }
    }
  /**********************************************************************************/
    public function listaTodosServiciosActivos(){
      $data_source = new DataSource();
      $data_table = $data_source->ejecutarConsulta("SELECT * FROM `servicio` where estado ='ACTIVO'");
      $objServicios = null;
      $arrayServicios = array();
      if(count($data_table) >0){
        foreach ($data_table as $clave => $valor) {
          $objServicios = new servicio(
            $data_table[$clave]["id_servicio"],
            $data_table[$clave]["id_conductor"],
            $data_table[$clave]["id_vehiculo"],
            $data_table[$clave]["id_cliente"],
            $data_table[$clave]["id_empleado"],
            $data_table[$clave]["manifiesto"],
            $data_table[$clave]["fecha_creacion"],
            $data_table[$clave]["fecha_fin"],
            $data_table[$clave]["estado"],
            $data_table[$clave]["satelital"],
            $data_table[$clave]["ciudad_origen"],
            $data_table[$clave]["ciudad_destino"],
            $data_table[$clave]["direccion_descargue"],
            $data_table[$clave]["sello"],
            $data_table[$clave]["numero_contenedor"],
            $data_table[$clave]["link_localizador"],
            $data_table[$clave]["usuario_satelital"],
            $data_table[$clave]["clave_satelital"],
            $data_table[$clave]["ruta"]);
            array_push($arrayServicios, $objServicios);
          }
          return $arrayServicios;
        }else{
          return null;
        }
      }
  public function listaTodosServiciosCerrados(){
    $data_source = new DataSource();
    $data_table = $data_source->ejecutarConsulta("SELECT * FROM `servicio` where estado ='CERRADO'");
    $objServicios = null;
    $arrayServicios = array();
    if(count($data_table) >0){
      foreach ($data_table as $clave => $valor) {
        $objServicios = new servicio(
          $data_table[$clave]["id_servicio"],
          $data_table[$clave]["id_conductor"],
          $data_table[$clave]["id_vehiculo"],
          $data_table[$clave]["id_cliente"],
          $data_table[$clave]["id_empleado"],
          $data_table[$clave]["manifiesto"],
          $data_table[$clave]["fecha_creacion"],
          $data_table[$clave]["fecha_fin"],
          $data_table[$clave]["estado"],
          $data_table[$clave]["satelital"],
          $data_table[$clave]["ciudad_origen"],
          $data_table[$clave]["ciudad_destino"],
          $data_table[$clave]["direccion_descargue"],
          $data_table[$clave]["sello"],
          $data_table[$clave]["numero_contenedor"],
          $data_table[$clave]["link_localizador"],
          $data_table[$clave]["usuario_satelital"],
          $data_table[$clave]["clave_satelital"],
          $data_table[$clave]["ruta"]);
          array_push($arrayServicios, $objServicios);
        }
        return $arrayServicios;
      }else{
        return null;
      }
    }
/****************************************************************************************************************************************/
public function servicioId($id){

  $data_source = new DataSource();
  $data_table = $data_source->ejecutarConsulta("SELECT * FROM `servicio` where id_servicio = :id",array(
    ':id'=>$id));
    $objServicios = null;
    if(count($data_table) > 0){
      $objServicios = new servicio(
        $data_table[0]["id_servicio"],
        $data_table[0]["id_conductor"],
        $data_table[0]["id_vehiculo"],
        $data_table[0]["id_cliente"],
        $data_table[0]["id_empleado"],
        $data_table[0]["manifiesto"],
        $data_table[0]["fecha_creacion"],
        $data_table[0]["fecha_fin"],
        $data_table[0]["estado"],
        $data_table[0]["satelital"],
        $data_table[0]["ciudad_origen"],
        $data_table[0]["ciudad_destino"],
        $data_table[0]["direccion_descargue"],
        $data_table[0]["sello"],
        $data_table[0]["numero_contenedor"],
        $data_table[0]["link_localizador"],
        $data_table[0]["usuario_satelital"],
        $data_table[0]["clave_satelital"],
        $data_table[0]["ruta"]);
        return $objServicios;
      }else{
        return null;
      }
    }
/****************************************************************************************************************************************/
  public function servicioEmp($id){
    $data_source = new DataSource();
    $data_table = $data_source->ejecutarConsulta("SELECT * FROM `servicio` where id_empleado = :id",array(
      ':id'=>$id));
      $objServicios = null;
      if(count($data_table) == 1){
        foreach ($data_table as $clave => $valor) {
          $objServicios = new servicio();
          $objServicios->setId_servicio($data_table[$clave]["id_servicio"]);
          $objServicios->setId_empleado($data_table[$clave]["id_conductor"]);
          $objServicios->setId_conductor($data_table[$clave]["id_vehiculo"]);
          $objServicios->setId_vehiculo($data_table[$clave]["id_cliente"]);
          $objServicios->setId_cliente($data_table[$clave]["id_empleado"]);
          $objServicios->setManifiesto($data_table[$clave]["manifiesto"]);
          $objServicios->setFecha_creacion($data_table[$clave]["fecha_creacion"]);
          $objServicios->setFecha_fin($data_table[$clave]["fecha_fin"]);
          $objServicios->setEstado($data_table[$clave]["estado"]);
          $objServicios->setSatelital($data_table[$clave]["satelital"]);
          $objServicios->setCiudad_origen($data_table[$clave]["ciudad_origen"]);
          $objServicios->setCiudad_destino($data_table[$clave]["ciudad_destino"]);
          $objServicios->setDireccion_descargue($data_table[$clave]["direccion_descargue"]);
          $objServicios->setSello($data_table[$clave]["sello"]);
          $objServicios->setNumero_contenedor($data_table[$clave]["numero_contenedor"]);
          $objServicios->setLink_localizador($data_table[$clave]["link_localizador"]);
          $objServicios->setUsuario_satelital($data_table[$clave]["usuario_satelital"]);
          $objServicios->setClave_satelital($data_table[$clave]["clave_satelital"]);
          $objServicios->setRuta($data_table[$clave]["ruta"]);
        }
        return $objServicios;
      }else{
        return null;
      }
    }
/****************************************************************************************************************************************/
 public function servicioCli($id){
   $data_source = new DataSource();
   $data_table = $data_source->ejecutarConsulta("SELECT * FROM `servicio` where id_cliente = :id",array(
     ':id'=>$id));
     $objServicios = null;
     if(count($data_table) == 1){
       foreach ($data_table as $clave => $valor) {
         $objServicios = new servicio();
         $objServicios->setId_servicio($data_table[$clave]["id_servicio"]);
         $objServicios->setId_empleado($data_table[$clave]["id_conductor"]);
         $objServicios->setId_conductor($data_table[$clave]["id_vehiculo"]);
         $objServicios->setId_vehiculo($data_table[$clave]["id_cliente"]);
         $objServicios->setId_cliente($data_table[$clave]["id_empleado"]);
         $objServicios->setManifiesto($data_table[$clave]["manifiesto"]);
         $objServicios->setFecha_creacion($data_table[$clave]["fecha_creacion"]);
         $objServicios->setFecha_fin($data_table[$clave]["fecha_fin"]);
         $objServicios->setEstado($data_table[$clave]["estado"]);
         $objServicios->setSatelital($data_table[$clave]["satelital"]);
         $objServicios->setCiudad_origen($data_table[$clave]["ciudad_origen"]);
         $objServicios->setCiudad_destino($data_table[$clave]["ciudad_destino"]);
         $objServicios->setDireccion_descargue($data_table[$clave]["direccion_descargue"]);
         $objServicios->setSello($data_table[$clave]["sello"]);
         $objServicios->setNumero_contenedor($data_table[$clave]["numero_contenedor"]);
         $objServicios->setLink_localizador($data_table[$clave]["link_localizador"]);
         $objServicios->setUsuario_satelital($data_table[$clave]["usuario_satelital"]);
         $objServicios->setClave_satelital($data_table[$clave]["clave_satelital"]);
         $objServicios->setRuta($data_table[$clave]["ruta"]);
       }
       return $objServicios;
     }else{
       return null;
     }
   }
/****************************************************************************************************************************************/
  public function registrarServicio(servicio $servicio){
    $data_source = new DataSource();
    $sql = "INSERT INTO servicio VALUES (:id_servico,:id_conductor,:id_vehiculo,:id_cliente,
      :id_empleado,:manifiesto,:fecha_creacion,:fecha_fin,:estado,:satelital,:ciudad_origen,
      :ciudad_destino,:direccion_descargue,:sello,:numero_contenedor,:link_localizador,:usuario_satelital,
      :clave_satelital,:ruta)";

      $resultado = $data_source->ejecutarActualizacion($sql,array(
        ':id_servico'=>$servicio->getId_servicio(),
        ':id_conductor'=>$servicio->getId_conductor(),
        ':id_vehiculo'=>$servicio->getId_vehiculo(),
        ':id_cliente'=>$servicio->getId_cliente(),
        ':id_empleado'=>$servicio->getId_empleado(),
        ':manifiesto'=>$servicio->getManifiesto(),
        ':fecha_creacion'=>$servicio->getFecha_creacion(),
        ':fecha_fin'=>$servicio->getFecha_fin(),
        ':estado'=>$servicio->getEstado(),
        ':satelital'=>$servicio->getSatelital(),
        ':ciudad_origen'=>$servicio->getCiudad_origen(),
        ':ciudad_destino'=>$servicio->getCiudad_destino(),
        ':direccion_descargue'=>$servicio->getDireccion_descargue(),
        ':sello'=>$servicio->getSello(),
        ':numero_contenedor'=>$servicio->getNumero_contenedor(),
        ':link_localizador'=>$servicio->getLink_localizador(),
        ':usuario_satelital'=>$servicio->getUsuario_satelital(),
        ':clave_satelital'=>$servicio->getClave_satelital(),
        ':ruta'=>$servicio->getRuta()
      )
    );
    return $resultado;
  }
/****************************************************************************************************************************************/
  public function actualizarServicio(servicio $servicio){
    $data_source = new DataSource();
    $sql = "UPDATE servicio SET id_conductor = :id_conductor,
    id_vehiculo = :id_vehiculo,
    id_cliente = :id_cliente,
    manifiesto = :manifiesto,
    fecha_creacion = :fecha_creacion,
    fecha_fin = :fecha_fin,
    estado = :estado,
    satelital = :satelital,
    ciudad_origen = :ciudad_origen,
    ciudad_destino = :ciudad_destino,
    direccion_descargue = :direccion_descargue,
    sello = :sello,
    numero_contenedor = :numero_contenedor,
    link_localizador = :link_localizador,
    usuario_satelital = :usuario_satelital,
    clave_satelital = :clave_satelital,
    ruta = :ruta
    WHERE idservicio = :idservicio
    ";
    $resultado = $data_source->ejecutarActualizacion($sql,array(
      ':id_conductor'=>$servicio->getId_conductor(),
      ':id_vehiculo'=>$servicio->getId_vehiculo(),
      ':id_cliente'=>$servicio->getId_cliente(),
      ':id_empleado'=>$servicio->getId_empleado(),
      ':manifiesto'=>$servicio->getManifiesto(),
      ':fecha_creacion'=>$servicio->getFecha_creacion(),
      ':fecha_fin'=>$servicio->getFecha_fin(),
      ':estado'=>$servicio->getEstado(),
      ':satelital'=>$servicio->getSatelital(),
      ':ciudad_origen'=>$servicio->getCiudad_origen(),
      ':ciudad_destino'=>$servicio->getCiudad_destino(),
      ':direccion_descargue'=>$servicio->getDireccion_descargue(),
      ':sello'=>$servicio->getSello(),
      ':numero_contenedor'=>$servicio->getNumero_contenedor(),
      ':link_localizador'=>$servicio->getLink_localizador(),
      ':usuario_satelital'=>$servicio->getUsuario_satelital(),
      ':clave_satelital'=>$servicio->getClave_satelital(),
      ':ruta'=>$servicio->getRuta(),
      ':idservicio'=>$servicio->getId_servicio()
    )
  );
  return $resultado;
}
  /****************************************************************************************************************************************/
  public function cerrarServicio($id_servicio){
    $data_source = new DataSource();
    $sql = "UPDATE servicio SET estado = CERRADO,
    WHERE idservicio = :idservicio";
    $resultado = $data_source->ejecutarActualizacion($sql,array(
      ':id_servicio'=>$id_servicio));
      return $resultado;
    }
  }
?>

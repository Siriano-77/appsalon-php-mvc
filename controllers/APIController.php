<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();  
        echo json_encode($servicios);
    }

    public static function guardar() {
        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);
        // debuguear($cita);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena la Cita y el Servicio
        // Almacena los servicios con el ID de la Cita
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        $id = $_POST['id'];
        $cita = Cita::find($id);
        $cita->eliminar();
        header('Location:'. $_SERVER['HTTP_REFERER']);
    }
}
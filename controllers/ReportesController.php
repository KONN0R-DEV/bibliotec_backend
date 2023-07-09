<?php

namespace app\controllers;

use app\models\Tokens;
use app\models\Usuarios;

class ReportesController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionObtenerListadoReportes()
    {
        if(isset($_GET['token']) && !empty($_GET['token']))
        {
            $verificarToken = Tokens::verificarEstadoAdmin($_GET['token']);
            if(is_numeric($verificarToken))
            {
                $reportes = array();
                array_push($reportes,['idReporte'=>"CANTLIBDIS","nombre"=>"Obtener libros disponibles"]);
                array_push($reportes,['idReporte'=>"CANTLIBPRN","nombre"=>"Obtener libros prestados ahora"]);
                array_push($reportes,['idReporte'=>"CANTLIBPRV","nombre"=>"Obtener libros prestados por tiempo"]);
                array_push($reportes,['idReporte'=>"TOPLIBPEDV","nombre"=>"Top de los libros mas pedidos"]);
                array_push($reportes,['idReporte'=>"TOPCATPEDV","nombre"=>"Top de las categorias mas pedidas"]);
                return json_encode(array("code"=>104,"msg"=>"Obtenido con exito","datos"=>array("reportes"=>$reportes)));
            }else{
                return json_encode($verificarToken);
            }
        }else{
            return json_encode(array("code"=>100,"msg"=>"El token es oblgatorio"));
        }
    }


    public function actionEjecutarReporte() 
    {
        $reporte = $_POST['reporte'];
        $datos = $_POST['datos'];
        if(isset($_POST['token']) && !empty($_POST['token']))
        {
            $verificarToken = Tokens::verificarEstadoAdmin($_POST['token']);
            if(is_numeric($verificarToken))
            {
                $respuesta = array();
                switch($reporte)
                {
                    case "CANTLIBDIS": //Cantidad de libros disponibles
                        $respuesta = ReportesController::cantidadLibrosDisponibles();
                    break;
                    case "CANTLIBPRN"://Cantidad e libros prestados hoy

                    break;
                    case "CANTLIBPRV"://Cantidad e libros prestados por fecha

                    break;
                    case "TOPLIBPEDV"://Top de los libros mas pedidos

                    break;
                    case "TOPCATPEDV"://Top de las categorias mas pedidas

                    break;
                    default:
                        $respuesta['code'] = 100;
                        $respuesta['msg'] = "El resporte enviado no existe.";
                    break;
                }
                return json_encode($respuesta);
            }else{
                return json_encode($verificarToken);
            }
        }else{
            return json_encode(array("code"=>100,"msg"=>"El token es oblgatorio"));
        }
       
    }


    public function cantidadLibrosDisponibles() {
        
    }
}

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

}

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
                array_push($reportes,['idReporte'=>"CANTLIB","nombre"=>"Cantidad de libros disponibles"]);
                return json_encode(array("code"=>104,"msg"=>"Obtenido con exito","datos"=>array("")));
            }else{
                return json_encode($verificarToken);
            }
        }else{
            return json_encode(array("code"=>100,"msg"=>"El token es oblgatorio"));
        }
    }

}

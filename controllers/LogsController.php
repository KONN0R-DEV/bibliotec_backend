<?php

namespace app\controllers;
use app\models\LogAbm;
use app\models\LogAccion;
use app\models\Usuarios;

class LogsController extends \yii\web\Controller
{
    public $modelClass = 'app\models\LogAmb';
    public $enableCsrfValidation = false;

    public function actionListado(){

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            if (!Usuarios::checkIfAdmin($this->request, $this->modelClass))
                return json_encode(array("codigo"=>2, 'mensaje' => 'Token invalido'));
                    
            $logsamb = LogAbm::find()->all();

            $array = array();
            foreach($logsamb as $logamb)
            {
                $logaccion = LogAccion::findOne(['loga_logabm_id' => $logamb['logabm_id']]);
                $usuario = Usuarios::findOne(['usu_id' => $logamb['logabm_usu_id']]);

                $index = null;
                $index['logabm_id'] = $logamb['logabm_id'];
                $index['logabm_fecha_hora'] = $logamb['logabm_fecha_hora'];
                $index['logabm_usu_id'] = $logamb['logabm_usu_id'];

                $index['usu_nombre_apellido'] = $usuario['usu_nombre'] . ' ' . $usuario['usu_apellido']; 
                
                $index['logabm_tabla'] = $logamb['logabm_tabla'];
                $index['logabm_accion_id'] = $logamb['logabm_accion_id'];
                $index['logabm_nombre_accion'] = $logamb['logabm_nombre_accion'];
                $index['logabm_modelo_viejo'] = $logamb['logabm_modelo_viejo'];
                $index['logabm_modelo_nuevo'] = $logamb['logabm_modelo_nuevo'];
                $index['logabm_descripcion'] = $logamb['logabm_descripcion'];

                if ($logaccion != null){
                    $index['loga_id'] = $logaccion['loga_id'];
                    $index['loga_endpoint'] = $logaccion['loga_endpoint'];
                    $index['loga_nombre_accoin'] = $logaccion['loga_nombre_accoin'];
                    $index['loga_descripcion'] = $logaccion['loga_descripcion'];   
                    //$index['loga_usu_id'] = $logaccion['loga_usu_id'];   
                    //$index['loga_fecha_hora'] = $logaccion['loga_fecha_hora'];  
                }
                //array_push($array,$index);
                //$array[] = $index; // Corrección: agregar el array $index a $array
                array_push($array,$index);
            }

            //return $array;
            return json_encode($array);
        }else{
            return json_encode(array("codigo"=>3, "mensaje"=>"metodo http incorrecto"));
        }
    }
}

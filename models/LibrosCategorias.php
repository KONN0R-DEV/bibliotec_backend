<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libros_categorias".
 *
 * @property int $libcat_id
 * @property int|null $libcat_lib_id
 * @property int|null $libcat_cat_id
 * @property int|null $libcat_subcat_id
 */
class LibrosCategorias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libros_categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['libcat_lib_id', 'libcat_cat_id', 'libcat_subcat_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'libcat_id' => 'Libcat ID',
            'libcat_lib_id' => 'Libcat Lib ID',
            'libcat_cat_id' => 'Libcat Cat ID',
            'libcat_subcat_id' => 'Libcat Subcat ID',
        ];
    }

    public static function nuevoLibroCategoria($idLibro, $idCategoria, $idSubCategoria = "")
    {
        $model = new LibrosCategorias();
        $model->libcat_lib_id = $idLibro;
        $model->libcat_cat_id = $idCategoria;
        $model->libcat_subcat_id = $idSubCategoria;
        $model->save();
    }

    public static function obtenerCategoriasSubCategorias($idLibro)
    {
        $sql = "SELECT cat_nombre, NVL(subcat_nombre,'') as subcat_nombre, cat_id, subcat_id
                FROM libros_categorias
                    LEFT JOIN categorias ON cat_id = libcat_cat_id
                    LEFT JOIN sub_categorias ON subcat_cat_id = cat_id AND subcat_id = libcat_subcat_id
                WHERE libcat_lib_id = $idLibro";

        $categorias = Yii::$app->db->createCommand($sql)->queryAll(); 
        return $categorias;
    }


    public static function obtenerCategorias($idLibro)
    {
        $sql = "SELECT cat_id, cat_nombre
                FROM libros_categorias
                    LEFT JOIN categorias ON cat_id = libcat_cat_id
                WHERE libcat_lib_id = $idLibro
                GROUP BY 1";

        $categorias = Yii::$app->db->createCommand($sql)->queryAll(); 
        return $categorias;
    }

    

    public static function obtenerSubCategorias($idLibro)
    {
        $sql = "SELECT subcat_id, subcat_nombre
                FROM libros_categorias
                    LEFT JOIN categorias ON cat_id = libcat_cat_id
                    LEFT JOIN sub_categorias ON subcat_cat_id = cat_id AND subcat_id = libcat_subcat_id
                WHERE libcat_lib_id = $idLibro AND libcat_subcat_id IS NOT NULL
                GROUP BY 1";

        $categorias = Yii::$app->db->createCommand($sql)->queryAll(); 
        return $categorias;
    }
}

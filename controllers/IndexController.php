<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/30 0030
 * Time: 14:37
 */

namespace app\controllers;


use yii\web\Controller;

class IndexController extends Controller
{
     public function actionIndex(){
      $this->layout = 'layout1';
      return   $this->render('index');
     }

}
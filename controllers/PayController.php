<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/10 0010
 * Time: 15:53
 */

namespace app\controllers;


use app\models\Pay;
use Codeception\Module\Yii1;
use yii\web\Controller;

class PayController extends CommonController
{

    public $enableCsrfValidation = false;
  public function actionNotify(){
  if (\Yii::$app->request->isPost){
      $post = \Yii::$app->request->post();
      if (Pay::notify($post)){
          echo "success";
          exit;
      }
      echo "fail";
      exit;
  }
  }
  public function actionReturn(){
$this->layout = 'layout1';
$status = \Yii::$app->request->get('trade_status');
if ($status == 'TRADE_SUCCESS'){
    $s = 'ok';
}else{
    $s = 'no';
}
return $this->render('status',['status'=>$s]);
  }
}
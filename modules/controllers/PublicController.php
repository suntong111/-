<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/31 0031
 * Time: 11:15
 */

namespace app\modules\controllers;


use app\modules\models\Admin;
use yii\web\Controller;
use Yii;
class PublicController extends Controller
{
   public function actionLogin(){
       session_start();
       var_dump($_SESSION);
       $this->layout = false;
       $model = new Admin();
       if (\Yii::$app->request->isPost){
           $post = Yii::$app->request->post();
        if ($model->login($post)){
            $this->redirect(['default/index']);
            Yii::$app->end();
        } ;
       }
       return $this->render('login',[
           'model'=>$model
       ]);
   }

   public function actionLogout(){
       Yii::$app->session->removeAll();
       if (!isset(Yii::$app->session['admin']['isLogin'])){
           $this->redirect(['public/login']);
           Yii::$app->end();
       }
       $this->goBack();
   }

   public function actionSeekpassword(){
       $this->layout = false;
       $model = new Admin();
       if (Yii::$app->request->isPost){
           $post = Yii::$app->request->post();
         if ($model->seekPass($post)){
            Yii::$app->session->setFlash('info','电子邮件已发送');
         }  ;
       }
       return $this->render("seekpassword",[
           'model'=>$model
       ]);
   }


}
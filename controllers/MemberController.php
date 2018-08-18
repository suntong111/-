<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/31 0031
 * Time: 09:00
 */

namespace app\controllers;


use app\models\User;
use yii\web\Controller;

class MemberController extends Controller
{
   public $layout = false;

   public function actionAuth(){
       $this->layout = 'layout2';
       return $this->render('auth');
   }

   public function actionQqlogin(){
       require_once ("../vendor/qqlogin/qqConnectAPI.php");
       $qc = new \QC();
       $qc->qq_login();
   }

   public function actionQqcallback(){
       require_once ("../vendor/qqlogin/qqConnectAPI.php");
      $auth = new \OAuth();
      $accessToken = $auth->qq_callback();
      $openid = $auth->get_openid();
      $qc = new \QC($accessToken,$openid);
      $userinfo = $qc->get_user_info();

      $session = \Yii::$app->session;
      $session['userinfo']=$userinfo;
      $session['openid'] = $openid;
      if (User::find()->where('openid=:openid',[':openid'=>$openid])->one()){
          $session['loginname'] = $userinfo['nickname'];
          $session['islogin'] = 1;
          return $this->redirect(['index/index']);
      }
      return $this->redirect(['member/qqreg']);
   }

   public function actionQqreg(){
       $this->layout = 'layout2';
       $model = new User();
       if (\Yii::$app->request->isPost){
           $post = \Yii::$app->request->post();
           $post['User']['openid'] = \Yii::$app->session['openid'];
           if ($model->reg($post,'qqreg')){
          return $this->redirect(['index/index']);
           }
       }
       return $this->render('aareg',['model'=>$model]);
   }

}
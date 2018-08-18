<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/9 0009
 * Time: 16:57
 */

namespace app\controllers;


use app\models\Address;
use app\models\User;
use yii\web\Controller;

class AddressController extends CommonController
{
  public function actionAdd(){
      if (\Yii::$app->session['isLogin'] !=1){
          return $this->redirect(['member/auth']);
      }
      $userid = User::find()->where(['username'=>\Yii::$app->session['loginname']])->one()->userid;
      if (\Yii::$app->request->isPost){
          $post = \Yii::$app->request->post();
          $post['userid'] = $userid;
          $post['address'] = $post['adddress1'].$post['address2'];
          $data['Address'] = $post;
          $model = new Address();
          $model->load($data);
          $model->save();
      }
      return $this->redirect($_SERVER['HTTP_REFERER']);
  }

  public function actionDel(){
      if (\Yii::$app->session['isLogin'] !=1){
          return $this->redirect(['member/auth']);
      }
      $userid = User::find()->where(['username'=>\Yii::$app->session['loginname']])->one()->userid;
      $addressid = \Yii::$app->request->get('addressid');
      if (!Address::find()->where(['userid'=>$userid],['addressid'=>$addressid])->one()){
          return $this->redirect([$_SERVER['HTTP_REFERER']]);
      }
      Address::deleteAll(['addressid'=>$addressid]);
      return $this->redirect([$_SERVER['HTTP_REFERER']]);

  }
}
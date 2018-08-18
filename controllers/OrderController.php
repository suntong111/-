<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/31 0031
 * Time: 08:34
 */

namespace app\controllers;


use app\models\Address;
use app\models\Cart;
use app\models\Order;
use app\models\OrderDetail;
use app\models\Pay;
use app\models\Product;
use app\models\User;
use yii\db\Exception;
use yii\web\Controller;

class OrderController extends Controller
{

   public function actionCheck(){
       $this->layout = 'layout1';
       if (\Yii::$app->session['isLogin'] != 1){
           return $this->redirect(['member/auth']);
       }
       $orderid = \Yii::$app->request->get('orderid');
       $status = Order::find()->where(['orderid'=>$orderid])->one()->status;
       if ($status != Order::CREATEORDER && $status != Order::CHECKORDER){
           return $this->redirect(['order/index']);
       }
       $userid = User::find()->where(['username'=>\Yii::$app->session['loginname']])->one()->userid;
       $addresses = Address::find()->where(['userid'=>$userid])->asArray()->all();
       $details = OrderDetail::find()->where(['orderid'=>$orderid])->asArray()->all();
       $data = [];
       foreach ($details as $detail){
    $model = Product::find()->where(['productid'=>$detail['productid']])->one();
    $detail['title'] = $model->title;
    $detail['cover'] = $model->cover;
    $data[] = $detail;
       }
       $express = \Yii::$app->params['express'];
       $expressPrice = \Yii::$app->params['expressPrice'];
       return $this->render('check',[
           'express'=>$express,
           'expressPrice'=>$expressPrice,
           'addresses'=>$addresses,
           'products'=>$data
       ]);
   }

   public function actionIndex(){
       $this->layout = 'layout2';
       if (\Yii::$app->session['isLogin'] !=1){
           return $this->redirect(['member/auth']);
       }
       $loginname =\Yii::$app->session['loginname'];
       $userid = User::find()->where(['username'=>$loginname])->one();
       $orders = Order::getProducts($userid);
       return $this->render('index',['orders'=>$orders]);
   }

   public function actionAdd(){
       if (\Yii::$app->session['isLogin'] != 1){
           return $this->redirect(['member/auth']);
       }
       $transaction = \Yii::$app->db->beginTransaction();
       try{
           if (\Yii::$app->request->isPost){
               $post = \Yii::$app->request->post();
               $ordermodel = new Order();
               $ordermodel->scenario = 'add';
               $usermodel = User::find()->where(['username'=>\Yii::$app->session['loginname']])->one();
               if (!$usermodel){
                   throw new \Exception();
               }
               $userid = $usermodel->userid;
               $ordermodel->userid = $userid;
               $ordermodel->status = Order::CREATEORDER;
               $ordermodel->createtime = time();
               if (!$ordermodel->save()){
                   throw new \Exception();
               }
               $orderid = $ordermodel->getPrimaryKey();
               foreach ($post['OrderDteail'] as $product){
                   $model = new OrderDetail();
                   $product['orderid'] = $orderid;
                   $product['createtime'] = time();
                   $data['OrderDetail'] = $product;
                   if (!$model->add($data)){
                       throw new \Exception();
                   }
                   Cart::deleteAll(['productid'=>$product['productid']]);
               }
           }
           $transaction->commit();
       }catch (\Exception $e){
       $transaction->rollBack();
       return $this->redirect(['cart/index']);
       }
       return $this->redirect(['order/check','orderid'=>$orderid]);
   }

   public function actionConfirm(){
       try{
           if (\Yii::$app->session['islogin'] !=1){
               return $this->redirect(['member/auth']);
           }
           if (!\Yii::$app->request->isPost){
               throw new \Exception();
           }
           $post = \Yii::$app->request->post();
           $usermodel = User::find()->where(['username'=>\Yii::$app->session['loginname']])->one();
           if (empty($usermodel)){
               throw new \Exception();
           }
           $userid = $usermodel->userid;
           $model = Order::find()->where(['orderid'=>$post['orderid']],['userid'=>$userid])->one();
           if (empty($model)){
               throw new \Exception();
           }
           $model->scenario = "update";
           $post['status'] = Order::CHECKORDER;
           $details = OrderDetail::find()->where(['orderid'=>$post['orderid']])->all();
           $amount = 0;
           foreach ($details as $detail){
               $amount += $detail->productnum*$detail->price;
           }
           if ($amount <=0){
               throw new \Exception();
           }
           $express = \Yii::$app->params['expressPrice'][$post['expressid']];
           if ($express <0){
             throw new \Exception();
           }
           $amount += $express;
           $post['amount'] = $amount;
           $data['Order'] = $post;
           if ($model->load($data) && $model->save()){
               return $this->redirect(['order/pay','orderid'=>$post['orderid'],'paymethod'=>$post['paymethod']]);
           }
       }catch (\Exception $e){
  return $this->redirect(['index/index']);
       }
   }

   public function actionPay(){
       try{
           $orderid = \Yii::$app->request->get('orderid');
           $paymethod = \Yii::$app->request->get('paymethod');
           if (empty($orderid) || empty($paymethod)){
               throw new \Exception();
           }
           if ($paymethod == 'alipay'){
               return Pay::alipay($orderid);
           }
       }catch(\Exception $e){
      return $this->redirect(['order/index']);
       }
   }
}
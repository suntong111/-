<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/11 0011
 * Time: 08:51
 */

namespace app\modules\controllers;


use app\models\Order;
use yii\data\Pagination;
use yii\web\Controller;

class OrderController extends Controller
{
   public function actionList(){
       $this->layout = 'layout1';
       $model = Order::find();
       $count = $model->count();
       $pageSize = \Yii::$app->params['pageSize']['order'];
       $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
       $data = $model->offset($pager->offset)->limit($pager->limit)->all();
       $order = new Order();

       $data = $order->getDetail($data);
       return $this->render('list',['pager'=>$pager,'orders'=>$data]);
   }

   public function actionDetail(){
       $this->layout='layout1';
$orderid =\Yii::$app->request->get('orderid');
$order = Order::find()->where(['orderid'=>$orderid])->one();
      $data = Order::getData($order);
       return $this->render('detail',['order'=>$data]);
   }
   public function actionSend(){
       $this->layout='layout1';
       $orderid = \Yii::$app->request->get('orderid');
       $model = Order::find()->where(['orderid'=>$orderid])->one();
       $model -> scenario = 'send';
       if (\Yii::$app->request->isPost){
           $post = \Yii::$app->request->post();
           if ($model->load($post) && $model->save()){
               \Yii::$app->session->setFlash('info','发货成功');
           }
       }
       return $this->render('send',['model'=>$model]);
   }
}
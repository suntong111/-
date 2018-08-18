<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/8 0008
 * Time: 09:59
 */

namespace app\controllers;


use app\models\Cart;
use app\models\Category;
use app\models\Product;
use app\models\User;
use yii\web\Controller;

class CommonController extends Controller
{
  public function init()
  {
      $menu = Category::getMenu();
      $this->view->params['menu'] = $menu;
      $data = [];
      $data['products'] = [];
      $total = 0;
      if (\Yii::$app->session['isLogin']){
          $userid = User::find()->where(['username'=>\Yii::$app->session['loginname']])->one()->userid;
          if(!empty($userid)){
              $carts = Cart::find()->where(['userid'=>$userid])->asArray()->all();
              foreach($carts as $k=>$pro){
                  $product = Product::find()->where(['productid'=>$pro['productid']])->one();
                  $data['products']['$k']['cover'] = $product->cover;
                  $data['products'][$k]['title'] = $product->title;
                  $data['products'][$k]['productnum'] = $pro['productnum'];
                  $data['products'][$k]['price'] = $pro['price'];
                  $data['products'][$k]['productid'] = $pro['productid'];
                  $data['products'][$k]['cartid'] = $pro['cartid'];
                  $total += $data['products'][$k]['price'] * $data['products'][$k]['productnum'];
              }
          }
      }
      $data['total'] = $total;
      $this->view->params['cart'] = $data;
  }
}
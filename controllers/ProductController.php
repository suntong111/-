<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/30 0030
 * Time: 16:57
 */

namespace app\controllers;


use app\models\Product;
use yii\data\Pagination;
use yii\web\Controller;

class ProductController extends Controller
{

  public function actionIndex(){
      $this->layout = 'layout2';
      $cid = \Yii::$app->request->get('cateid');
      $where = "cateid = :cid and ison = '1";
      $params = [':cid'=>$cid];
      $model = Product::find()->where($where,$params);
      $all = $model->asArray()->all();
      $count = $model->count();
      $pageSize = \Yii::$app->params['pageSize']['frontproduct'];
      $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
      $all = $model->offset($pager->offset)->limit($pager->limit)->asArray()->all();
      $tui = $model->where($where.'and istui = \'1\'',$params)->orderBy('createtime desc')->limit(5)->all();
      $hot = $model->where($where.'and ishot = \'1\'',$params)->orderBy('createtime desc')->limit(5)->all();
      $sale = $model->where($where.'and issale = \'1\'',$params)->orderBy('createtime desc')->limit(5)->all();

      return $this->render('index',['sale' => $sale, 'tui' => $tui, 'hot' => $hot, 'all' => $all, 'pager' => $pager, 'count' => $count]);
  }

  public function actionDetail(){
      $this->layout = 'layout2';
      $productid = \Yii::$app->request->get('productid');
      $product = Product::find()->where(['productid'=>$productid]);
      return $this->render('detail');
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/7 0007
 * Time: 10:21
 */

namespace app\modules\controllers;


use app\models\Category;
use app\models\Product;
use crazyfd\qiniu\Qiniu;
use yii\data\Pagination;
use yii\web\Controller;


class ProductController extends Controller
{
     public function actionList(){
      $this->layout = 'layout1';
      $model = Product::find();
       $count = $model->count();
       $pageSize = \Yii::$app->params['pageSize']['product'];
       $pager = new Pagination(['totalCount'=>$count,'pagesize'=>$pageSize]);
       $products = $model->offset($pager->offset)->limit($pager->limit)->all();
      return $this->render('product',['products'=>$products,'pager'=>$pager]);
     }

     public function actionAdd(){
         $this->layout='layout1';
         $model = new Product();
         $cate = new Category();
         $list = $cate->getOptions();
         unset($list[0]);
         if (\Yii::$app->request->isPost){
             $post = \Yii::$app->request->post();
             $pics = $this->upload();
             if (!$pics){
                 $model->addError('cover','封面不能为空');
             }else{
                 $post['Product']['cover'] = $pics['cover'];
                 $post['Product']['pics'] = $pics['pics'];
             }
             if ($pics && $model->add($post)){
                 \Yii::$app->session->setFlash('info','添加成功');
             }else{
                 \Yii::$app->session->setFlash('info','添加失败');
             }
         }
         return $this->render('add',['opts'=>$list,'model'=>$model]);
     }

     private function upload(){
  if ($_FILES['Product']['error']['cover']>0){
      return false;
  }
  $qiniu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET,Product::ZONE);
  $key = uniqid();
  $qiniu ->uploadFile($_FILES['Product']['tmp_name']['cover'],$key);
  $cover = $qiniu->getLink($key);
  $pics = [];
  foreach($_FILES['Product']['tmp_name']['pics'] as $k=>$file){
      if ($_FILES['Product']['error']['pics'][$k] > 0){
          continue;
      }
      $key = uniqid();
      $qiniu->uploadFile($file,$key);
      $pics[$key] = $qiniu->getLink($key);
  }
 return ['cover'=>$cover,'pics'=>json_encode($pics)];
     }
}
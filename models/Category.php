<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3 0003
 * Time: 16:43
 */

namespace app\models;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
  public static function tableName()
  {
    return "{{%category}}";
  }


  public function attributeLabels()
  {
      return [
          'parentid'=>'上级分类',
          'title'=>'分类名称'
      ];
  }

    public function rules()
  {
      return [
    ['parentid','required','message'=>'商机分类不能为空'],
          ['title','required','message'=>'不能为空'],
          ['createtime','safe']
      ];
  }


  public function add($data){
//      $this->scenario='';
      $data['Category']['createtime'] = time();
  if ($this->load($data) && $this->save()){
      return true;
  }
  return false;
  }


  public function getData(){
      $cates = self::find()->asArray()->all();
      return $cates;
  }

  public function getTree($cates,$pid = 0){
      $tree = [];
      foreach ($cates as $cate){
          if ($cate['parentid'] == $pid){
              $tree[] = $cate;
              $tree = array_merge($tree,$this->getTree($cates,$cate['cateid']));
          }
      }
      return $tree;
  }

  public function setprefix($data,$p= '|---'){
      $tree = [];
      $num = 1;
      $prefix = [0=>1];
      while ($val = current($data)){
   $key = key($data);
   if ($key>0){
       if ($data[$key - 1]['parentid'] !=$val['parentid']){
           $num++;
       }
   }
   if (array_key_exists($val['parentid'],$prefix)){
    $num = $prefix[$val['parentid']];
   }
   $val['title'] = str_repeat($p,$num).$val['title'];
   $prefix[$val['parentid']] = $num;
   $tree[] = $val;
   next($data);
      }
      return $tree;
  }

  public function getOptions(){
      $data = $this->getData();
      $tree = $this->getTree($data);
      $tree = $this->setprefix($tree);
      $options = ['添加顶级分类'];
      foreach ($tree as $cate){
          $options[$cate['cateid']] = $cate['title'];
      }
      return $options;
  }
  public function getTreeList(){
      $data = $this->getData();
      $tree = $this->getTree($data);
      return $tree = $this->setprefix($tree);
  }

  public static function getMenu(){
      $top = self::find()->where(['parentid'=>0])->asArray()->all();
      $data = [];
      foreach ((array)$top as $k=>$cate){
          $cate['children'] = self::find()->where(['parentid'=>$cate['cateid']])->asArray()->all();
          $data[$k] = $cate;
      }
      return $data;

  }
}
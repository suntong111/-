<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/8 0008
 * Time: 13:46
 */

namespace app\models;


use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
   public static function tableName()
   {
       return "{{%cart}}";
   }

   public function rules()
   {
       return [
         [['productid','productnum','userid','price'],'required'],
           ['createtime','safe']
       ];
   }
}
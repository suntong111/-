<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/2 0002
 * Time: 15:36
 */

namespace app\models;


use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{
  public static function tableName()
  {
    return"{{%profile}}";
  }
}
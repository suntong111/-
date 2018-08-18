<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/9 0009
 * Time: 15:55
 */

namespace app\models;


use yii\db\ActiveRecord;

class Address extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%address}}";
    }
    public function rules()
    {
        return [
            [['userid', 'firstname', 'lastname', 'address', 'email', 'telephone'], 'required'],
            [['createtime', 'postcode'],'safe'],
        ];
    }
}
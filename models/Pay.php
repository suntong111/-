<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/10 0010
 * Time: 13:59
 */

namespace app\models;


use vendor\alipay\AlipayPay;
use yii\db\ActiveRecord;

class Pay
{
   public static function alipay($orderid){
           $amount = Order::find()->where(['orderid'=>$orderid])->one()->amount;
           if (!empty($amount)){
               $alipay = new AlipayPay();
               $giftname = "商城";
               $data = OrderDetail::find()->where(['orderid'=>$orderid])->all();
               $body = "";
               foreach ($data as $pro){
                   $body .=Product::find()->where(['productid'=>$pro['productid']])->one()->title . '-';
               }
            $body .="等商品";
               $showurl = "http://xxx.com";
               $html = $alipay->requestPay($orderid,$giftname,$amount,$body,$showurl);
               echo $html;
           }
   }

   public static function notify($data){
       $alipay = new AlipayPay();
       $verify_result = $alipay->verifyNotify();
       if ($verify_result){
           $out_trade_no = $data['extra_common_param'];
           $trade_no = $data['trade_no'];
           $trade_status = $data['trade_status'];
           $status = Order::PAYFAILED;
           if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS'){
                $status = Order::PAYSUCCESS;
                $order_info = Order::find()->where(['orderid'=>$out_trade_no])->one();
                if (!$order_info){
                    return false;
                }
                if ($order_info->status == Order::CHECKORDER){
                    Order::updateAll(['status'=>$status],['orderid'=>$order_info->orderid]);
                }else{
                    return false;
                }
           }
           return true;
       }else{
           return false;
       }
   }
}
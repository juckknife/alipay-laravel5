<?php
/* *
 * 功能：打钱
 */

namespace EchoBool\AlipayLaravel\BuilderModel;

class AlipayFundCouponOrderAgreementPayContentBuilder
{
    private $out_order_no;

    private $out_request_no;
    
    private $order_title;

    private $amount;

    private $payer_user_id;

    private $pay_timeout;

    private $bizContentarr = array();

    private $bizContent = NULL;

    public function getBizContent()
    {
        if(!empty($this->bizContentarr)){
            $this->bizContent = json_encode($this->bizContentarr,JSON_UNESCAPED_UNICODE);
        }
        return $this->bizContent;
    }

    public function getPayTimeout()
    {
        return $this->pay_timeout;
    }

    public function setPayTimeout($pay_timeout)
    {
        $this->pay_timeout = $pay_timeout;
        $this->bizContentarr['pay_timeout'] = $pay_timeout;
    }

    public function getPayeeLogonId()
    {
        return $this->payer_user_id;
    }

    public function setPayeeUserId($payer_user_id)
    {
        $this->payer_user_id = $payer_user_id;
        $this->bizContentarr['payer_user_id'] = $payer_user_id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        $this->bizContentarr['amount'] = $amount;
    }

    public function getOrderTitle()
    {
        return $this->order_title;
    }

    public function setOrderTitle($order_title)
    {
        $this->order_title = $order_title;
        $this->bizContentarr['order_title'] = $order_title;
    }

    public function getTradeNo()
    {
        return $this->out_order_no;
    }

    public function setOutOrderNo($out_order_no)
    {
        $this->out_order_no = $out_order_no;
        $this->bizContentarr['out_order_no'] = $out_order_no;
    }

    public function getOutRequestNo()
    {
        return $this->out_order_no;
    }

    public function setOutRequestNo($out_request_no)
    {
        $this->out_request_no = $out_request_no;
        $this->bizContentarr['out_request_no'] = $out_request_no;
    }
}

?>
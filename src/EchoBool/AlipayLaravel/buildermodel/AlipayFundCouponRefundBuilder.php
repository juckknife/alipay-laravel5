<?php
/* *
 * 功能：
 */
namespace EchoBool\AlipayLaravel\BuilderModel;

class AlipayFundCouponRefundBuilder
{
    private $auth_no;

    private $out_request_no;

    private $amount;

    private $remark;

    private $bizContentarr = array();

    private $bizContent = NULL;

    public function getBizContent()
    {
        if(!empty($this->bizContentarr)){
            $this->bizContent = json_encode($this->bizContentarr,JSON_UNESCAPED_UNICODE);
        }
        return $this->bizContent;
    }

    public function getOutRequestNo()
    {
        return $this->out_request_no;
    }

    public function setOutRequestNo($out_request_no)
    {
        $this->out_request_no = $out_request_no;
        $this->bizContentarr['out_request_no'] = $out_request_no;
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

    public function getRemark()
    {
        return $this->remark;
    }

    public function setRemark($remark)
    {
        $this->remark = $remark;
        $this->bizContentarr['remark'] = $remark;
    }

    public function getAuthNo()
    {
        return $this->auth_no;
    }

    public function setAuthNo($auth_no)
    {
        $this->auth_no = $auth_no;
        $this->bizContentarr['auth_no'] = $auth_no;
    }

}

?>
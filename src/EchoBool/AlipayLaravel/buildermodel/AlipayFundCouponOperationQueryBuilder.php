<?php
/* *
 * 功能：
 */
namespace EchoBool\AlipayLaravel\BuilderModel;

class AlipayFundCouponOperationQueryBuilder
{
    private $auth_no;

    private $out_order_no;

    private $operation_id;

    private $out_request_no;

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

    public function getOperationId()
    {
        return $this->operation_id;
    }

    public function setOperationId($operation_id)
    {
        $this->operation_id = $operation_id;
        $this->bizContentarr['operation_id'] = $operation_id;
    }

    public function getOutOrderNo()
    {
        return $this->out_order_no;
    }

    public function setOutOrderNo($out_order_no)
    {
        $this->out_order_no = $out_order_no;
        $this->bizContentarr['out_order_no'] = $out_order_no;
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
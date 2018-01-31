<?php
/**
 * Created by PhpStorm.
 * User: luojinyi
 * Date: 2017/6/27
 * Time: 上午11:48
 */

namespace EchoBool\AlipayLaravel;

use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeCloseContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeFastpayRefundQueryContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradePagePayContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeQueryContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeRefundContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayFundCouponOrderDisburseBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayOpenAuthTokenAppBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayOpenAuthTokenAppQueryBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayFundCouponOperationQueryBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayFundCouponOrderAgreementPayBuilder;
use EchoBool\AlipayLaravel\Service\AlipayTradeService;

class AlipaySdk
{
    public $aop;
    public $config;

    /**
     * AlipaySdk constructor.
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->aop = new AlipayTradeService($config);
    }

    /**
     * 支付接口 支持自定义数据传输
     * @param $subject
     * @param $body
     * @param $out_trade_no
     * @param $total_amount
     * @param $customData 自定义数据
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function tradePagePay($subject, $body, $out_trade_no, $total_amount, $customData)
    {
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setPassbackParams($customData);
        $response = $this->aop->pagePay($payRequestBuilder, $this->config['return_url'], $this->config['notify_url'], $this->config['trade_pay_type']);

        return $response;
    }

    /**
     * 退款接口
     * @param $out_trade_no//商户订单号，商户网站订单系统中唯一订单号
     * @param $refund_amount//需要退款的金额，该金额不能大于订单金额，必填
     * @param $refund_reason//退款的原因说明
     * @param string $out_request_no//标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|\SimpleXMLElement[]|string
     */
    public function tradeRefund($out_trade_no, $refund_amount, $refund_reason, $out_request_no = '')
    {
        $RequestBuilder = new AlipayTradeRefundContentBuilder();

        $RequestBuilder->setOutTradeNo($out_trade_no);
        //$RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setOutRequestNo($out_request_no);
        $RequestBuilder->setRefundReason($refund_reason);

        $response = $this->aop->Refund($RequestBuilder);
        return $response;
    }

    /**
     * 支付交易查询接口，用于查询交易是否交易成功
     * @param $out_trade_no
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|\SimpleXMLElement[]|string
     */
    public function tradePayQuery($out_trade_no)
    {
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        //$RequestBuilder->setTradeNo($trade_no);

        $response = $this->aop->Query($RequestBuilder);
        return $response;
    }

    /**
     * 退款查询接口
     * @param $out_trade_no//商户订单号，商户网站订单系统中唯一订单号
     * @param $out_request_no//请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号，必填
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function refundQuery($out_trade_no, $out_request_no)
    {
        $RequestBuilder=new AlipayTradeFastpayRefundQueryContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        //$RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setOutRequestNo($out_request_no);

        $response = $this->aop->refundQuery($RequestBuilder);
        return $response;
    }

    /**
     * 关闭订单接口
     * @param $out_trade_no
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|\SimpleXMLElement[]|string
     */
    public function Close($out_trade_no)
    {
        $RequestBuilder=new AlipayTradeCloseContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        //$RequestBuilder->setTradeNo($trade_no);

        $response = $this->aop->Close($RequestBuilder);
        return $response;
    }

    /**
     * 异步通知验证
     * @param $requestData
     * @return bool
     */
    public function notify($requestData)
    {
        $this->aop->writeLog(var_export($requestData,true));
        return $this->aop->check($requestData);
    }

    /**
     * 打钱接口 
     * @param $out_order_no
     * @param $out_request_no
     * @param $order_title
     * @param $amount
     * @param $payee_logon_id 收款方的支付宝登录号，形式为手机号或邮箱等
     * @param $pay_timeout 该笔订单允许的最晚付款时间，逾期将关闭该笔订单
     * @param $customData 自定义数据
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function fightMoneyPay($out_order_no, $out_request_no, $amount, $payee_logon_id, $payee_user_id, $deduct_auth_no, $pay_timeout='1m', $order_title = '工资')
    {
        $RequestBuilder = new AlipayFundCouponOrderDisburseBuilder();
        $RequestBuilder->setOutOrderNo($out_order_no);
        $RequestBuilder->setDeductAuthNo($deduct_auth_no);
        $RequestBuilder->setOutRequestNo($out_request_no);
        $RequestBuilder->setOrderTitle($order_title);
        $RequestBuilder->setAmount($amount);
        // $RequestBuilder->setPayeeUserId($payee_user_id);
        $RequestBuilder->setPayeeLoginId($payee_logon_id);
        // $RequestBuilder->setPayTimeout($pay_timeout);
        $response = $this->aop->fightMoney($RequestBuilder); 

        return $response;
    }

    /**
     * 生成红包 
     * @param $out_order_no
     * @param $order_title
     * @param $amount
     * @param $payer_user_id 
     * @param $pay_timeout 该笔订单允许的最晚付款时间，逾期将关闭该笔订单
     * @param $customData 自定义数据
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function createPocket($out_order_no, $out_request_no, $amount, $payer_user_id, $pay_timeout='1m', $order_title = '工资')
    {
        $RequestBuilder = new AlipayFundCouponOrderAgreementPayBuilder();
        $RequestBuilder->setOutOrderNo($out_order_no);
        $RequestBuilder->setOutRequestNo($out_request_no);
        $RequestBuilder->setOrderTitle($order_title);
        $RequestBuilder->setAmount($amount);
        $RequestBuilder->setPayerUserId($payer_user_id);
        // $RequestBuilder->setPayTimeout($pay_timeout);
        $response = $this->aop->createPocket($RequestBuilder); 

        return $response;
    }

    /**
     * 换取应用授权令牌
     * @param $grant_type
     * @param $code
     * @param $refresh_token
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function getAuthToken($grant_type, $code, $refresh_token)
    {
        $RequestBuilder = new AlipayOpenAuthTokenAppBuilder();
        $RequestBuilder->setGrantType($grant_type);
        $RequestBuilder->setCode($code);
        $RequestBuilder->setRefreshToken($refresh_token);
        $response = $this->aop->authToken($RequestBuilder);

        return $response;
    }

    /**
     * 查询某个应用授权AppAuthToken的授权信息
     * @param $grant_type
     * @param $code
     * @param $refresh_token
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function authTokenQuery($app_auth_token)
    {
        $RequestBuilder = new AlipayOpenAuthTokenAppQueryBuilder();
        $RequestBuilder->setAppAuthToken($app_auth_token);
        $response = $this->aop->authTokenQuery($RequestBuilder);

        return $response;
    }

    /**
     * 红包明细查询接口
     * @param $auth_no
     * @param $out_order_no
     * @param $operation_id
     * @param $out_request_no
     * @return bool|提交表单HTML文本|mixed|\SimpleXMLElement|string
     */
    public function fundCouponQuery($auth_no, $out_order_no, $operation_id, $out_request_no)
    {
        $RequestBuilder = new AlipayFundCouponOperationQueryBuilder();
        $RequestBuilder->setAuthNo($auth_no);
        $RequestBuilder->setOutOrderNo($out_order_no);
        $RequestBuilder->setOperationId($operation_id);
        $RequestBuilder->setOutRequestNo($out_request_no);
        $response = $this->aop->fundCouponQuery($RequestBuilder);

        return $response;
    }
}
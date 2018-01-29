<?php
/* *
 * 功能：换取授权码
 */
namespace EchoBool\AlipayLaravel\BuilderModel;

class AlipayOpenAuthTokenAppBuilder
{
    private $grant_type;

    private $code;

    private $operatorId;

    private $bizContentarr = array();

    private $bizContent = NULL;

    public function getBizContent()
    {
        if(!empty($this->bizContentarr)){
            $this->bizContent = json_encode($this->bizContentarr,JSON_UNESCAPED_UNICODE);
        }
        return $this->bizContent;
    }

    public function getGrantType()
    {
        return $this->grant_type;
    }

    public function setGrantType($grant_type)
    {
        $this->grant_type = $grant_type;
        $this->bizContentarr['grant_type'] = $grant_type;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        $this->bizContentarr['code'] = $code;
    }
    public function getRefreshToken()
    {
    	return $this->refresh_token;
    }
    
    public function setRefreshToken($refresh_token)
    {
    	$this->refresh_token = $refresh_token;
    	$this->bizContentarr['operator_id'] = $refresh_token;
    }

}

?>
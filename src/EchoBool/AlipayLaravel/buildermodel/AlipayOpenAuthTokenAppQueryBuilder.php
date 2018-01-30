<?php
/* *
 * 功能：换取授权码
 */
namespace EchoBool\AlipayLaravel\BuilderModel;

class AlipayOpenAuthTokenAppQueryBuilder
{
    private $app_auth_token;

    private $bizContentarr = array();

    private $bizContent = NULL;

    public function getBizContent()
    {
        if(!empty($this->bizContentarr)){
            $this->bizContent = json_encode($this->bizContentarr,JSON_UNESCAPED_UNICODE);
        }
        return $this->bizContent;
    }

    public function getAppAuthToken()
    {
        return $this->app_auth_token;
    }

    public function setAppAuthToken($app_auth_token)
    {
        $this->app_auth_token = $app_auth_token;
        $this->bizContentarr['app_auth_token'] = $app_auth_token;
    }

}

?>
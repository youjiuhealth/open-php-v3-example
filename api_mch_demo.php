<?php
/**
 * Created by PhpStorm.
 * author: qw_xingzhe <qinwei@youjiuhealth.com>
 * Date: 2018/8/21/021
 * Time: 16:16
 */

include 'OpenApi.php';

class ApiMchDemo extends OpenApi
{
    // 接口地址（正式服）
    protected $base_url = 'https://open.youjiuhealth.com/mch';
    // 接口地址（测试服）
    // protected $base_url = 'http://open.wx3city.com/mch';


    // 获取商家列表
    public function getClients($query=[])
    {
        return $this->getData('/clients',$query);
    }

    // 获取商家设备列表
    public function getClientDevices($client_id,$query=[])
    {
        return $this->getData('/clients/'.$client_id.'/devices',$query);
    }

}

$app_id     = 'xxxxxxxx';
$app_secret = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';


$api        = new ApiMchDemo($app_id,$app_secret);

// 获取token
//+-----------------------------------------------------------------------
$res = $api->getTocken();
var_dump( $res );


// 获取报告列表
//+-----------------------------------------------------------------------
$query = [
//    'phone'     => '',
//    'device_sn' => '',
    'page'      => '1',
];
//$res = $api->getReportsList($query);
//var_dump( $res );


// 获取报告详情
//+-----------------------------------------------------------------------
$measurementId = 38021067;    // 报告ID（通过getReportsList获取）
//$res = $api->getReportsDetail($measurementId);
//var_dump( $res );


// 获取报告小程序码
//+-----------------------------------------------------------------------
//$res = $api->getMiniProgramCode($measurementId);
//var_dump( $res );



// 获取商家列表
//+-----------------------------------------------------------------------
$query = [
    'page'      => '1',
];
//$res = $api->getClients($query);
//var_dump( $res );



// 获取商家设备列表
//+-----------------------------------------------------------------------
$query = [
    'page'      => '1',
];
//$client_id = '3225414';
//$res = $api->getClientDevices($client_id,$query);
//var_dump( $res );
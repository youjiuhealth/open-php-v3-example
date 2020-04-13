<?php
/**
 * Created by PhpStorm.
 * author: qw_xingzhe <qinwei@youjiuhealth.com>
 * Date: 2018/8/21/021
 * Time: 16:16
 */

include 'OpenApi.php';

class ApiDemo extends OpenApi
{
    // 接口地址（正式服）
    protected $base_url = 'https://open.youjiuhealth.com/api';
    // 接口地址（测试服）
    // protected $base_url = 'http://open.wx3city.com/api';

    // 请求header头
    protected function header()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getTocken(),
//            'accept'        => 'application/vnd.XoneAPI.v2+json'    // V2版本
            'accept'        => 'application/vnd.XoneAPI.v3+json'    // V3版本
        ];
    }

}


$app_id     = 'xxxxxxxx';
$app_secret = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';


$api        = new ApiDemo($app_id,$app_secret);

// 1、获取token
//+-----------------------------------------------------------------------
//$res = $api->getTocken();
//var_dump( $res );


// 2、获取报告列表
//+-----------------------------------------------------------------------
$query = [
//    'phone'     => '',
//    'device_sn' => '',
    'page'      => '1',
];
//$res = $api->getReportsList($query);
//var_dump( $res );


// 3、获取报告详情
//+-----------------------------------------------------------------------
$measurementId = 20087148;    // 报告ID（通过getReportsList获取）
//$res = $api->getReportsDetail($measurementId);
//var_dump( $res );


// 4、获取报告小程序码
//+-----------------------------------------------------------------------
$res = $api->getMiniProgramCode($measurementId);
var_dump( $res );


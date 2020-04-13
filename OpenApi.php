<?php
/**
 * Created by PhpStorm.
 * author: qw_xingzhe <qinwei@youjiuhealth.com>
 * Date: 2018/8/21/021
 * Time: 16:16
 */

include 'Cache.php';

class OpenApi
{
    protected $app_id;
    protected $app_secret;
    protected $tocken;
    protected $base_url = '';
    protected $access_token;

    public function __construct($app_id,$app_secret)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    // 获取token
    public function getTocken()
    {
        // 取缓存
        $cache = new Cache;
        $access_token = $cache->cacheData('access_token');
        if($access_token)return $access_token;

        // 无缓存请求接口
        $data = $this->request_data('/session', [
            'app_id'        => $this->app_id,
            'app_secret'    => $this->app_secret,
        ]);

        if( isset($data['response']['access_token']) ){
            $this->access_token = $data['response']['access_token'];
            $cache->cacheData('access_token',$this->access_token,$data['response']['expires_in']);
            return $this->access_token;
        }
        throw new Exception("Token acquisition failure");
    }

    // 获取报告列表
    public function getReportsList($query=[])
    {
        return $this->getData('/reports',$query);
    }

    // 获取报告详情
    public function getReportsDetail($id)
    {
        return $this->getData('/reports/'.$id);
    }

    // 获取小程序码
    public function getMiniProgramCode($id)
    {
        return $this->getData('/reports/'.$id.'/miniProgramCode');
    }

    // 请求header头
    protected function header()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getTocken(),
        ];
    }

    // 发起Get请求
    public function getData($url,$data=[])
    {
        return $this->request_data($url, $data, false, $this->header());
    }

    // 发起Post请求
    public function postData($url,$data=[])
    {
        return $this->request_data($url, $data, true, $this->header());
    }

    /**
     * 请求数据
     * @param String $url     请求的地址
     * @param Array  $header  自定义的header数据
     * @param Array  $content POST的数据
     * @return String
     */
    public  function request_data($resources,$data=[],$is_post=true, $header=null)
    {
        $url = $this->base_url . $resources;

        $ch = curl_init();
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($header){
            $headers = [];
            foreach ($header as $key=>$val){
                $headers[] = $key.':'.$val;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if($data){
            $data = http_build_query($data);
            if($is_post){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }else{
                $url .= '?'.$data;
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        $response = curl_exec($ch);
        if ($error = curl_error($ch)) {
            die($error);
        }
        curl_close($ch);
        return [
            'response'  => json_decode($response,true)
        ];

    }
}

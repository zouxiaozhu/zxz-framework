<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2019/1/25
 * Time: 7:30 PM
 */

namespace App\controllers\stream;

use Framework\Core\Controller;
use Framework\Exceptions\ZxzHttpException;

class Stream extends Controller
{
    /**
     * @return array
     * @throws ZxzHttpException
     */
    public function test()
    {
        //  获取流内容 文件本质就是流
        //  $path = 'file://' . zxz_path('.env');
        //  $fp = fopen($path, 'rw+'); // 打开的是文件流
        //  echo stream_get_contents($fp);die;
        //  echo fread($fp, 111);die;

        $str = 'file://' . zxz_path('.env');
        echo file_get_contents($str);
        die;


        $t = '';
        while (feof($fp)) {
            $t .= fread($fp, filesize($fp));
        }

        echo $t;
        die;
    }

    // 套接字协议类型
    public function transport()
    {
        ds(stream_get_transports());
    }

    // 获取已注册流类型
    public function wrappers()
    {
        ds(stream_get_wrappers());
    }

    //获取已注册的数据流过滤器列表
    public function stream_filter()
    {
        ds(stream_get_filters());
    }

    // 只能获取post json数据
    public function php_input()
    {
        $fp = (fopen('php://input', 'rw'));
        var_dump(json_decode(stream_get_contents($fp), true));
        die;
    }

    public function stream_context_create_test()
    {
        $context = stream_context_create([
            'http' => array(
                'method' => "POST", /** 这里必须是大写 */
                'timeout' => 60,
            )
        ]);

        /** 两种方式 mode 不能加w 否则权限出现问题 */
//        $fp = file_get_contents('http://zxz-framework.test/search/job/index', false, $context);
        $fp = fopen('http://zxz-framework.test/search/job/index', 'r', false, $context);
        var_dump(stream_get_contents($fp));
        die;
        fclose($fp);
    }

    /**
     * stream_bucket_append函数：为队列添加数据　
     * stream_bucket_make_writeable函数：从操作的队列中返回一个数据对象
     * stream_bucket_new函数：为当前队列创建一个新的数据
     * stream_bucket_prepend函数：预备数据到队列　
     * stream_context_create函数：创建数据流上下文
     * stream_context_get_default函数：获取默认的数据流上下文
     * stream_context_get_options函数：获取数据流的设置
     * stream_context_set_option函数：对数据流、数据包或者上下文进行设置
     * stream_context_set_params函数：为数据流、数据包或者上下文设置参数
     * stream_copy_to_stream函数：在数据流之间进行复制操作
     * stream_filter_append函数：为数据流添加过滤器
     * stream_filter_prepend函数：为数据流预备添加过滤器
     * stream_filter_register函数：注册一个数据流的过滤器并作为PHP类执行
     * stream_filter_remove函数：从一个数据流中移除过滤器
     * stream_get_contents函数：读取数据流中的剩余数据到字符串
     * stream_get_filters函数：返回已经注册的数据流过滤器列表
     * stream_get_line函数：按照给定的定界符从数据流资源中获取行
     * stream_get_meta_data函数：从封装协议文件指针中获取报头/元数据
     * stream_get_transports函数：返回注册的Socket传输列表
     * stream_get_wrappers函数：返回注册的数据流列表
     * stream_register_wrapper函数：注册一个用PHP类实现的URL封装协议
     * stream_select函数：接收数据流数组并等待它们状态的改变
     * stream_set_blocking函数：将一个数据流设置为堵塞或者非堵塞状态
     * stream_set_timeout函数：对数据流进行超时设置
     * stream_set_write_buffer函数：为数据流设置缓冲区
     * stream_socket_accept函数：接受由函数stream_ socket_server()创建的Socket连接
     * stream_socket_client函数：打开网络或者UNIX主机的Socket连接
     * stream_socket_enable_crypto函数：为一个已经连接的Socket打开或者关闭数据加密
     * stream_socket_get_name函数：获取本地或者网络Socket的名称
     * stream_socket_pair函数：创建两个无区别的Socket数据流连接
     * stream_socket_recvfrom函数：从Socket获取数据，不管其连接与否
     * stream_socket_sendto函数：向Socket发送数据，不管其连接与否
     * stream_socket_server函数：创建一个网络或者UNIX Socket服务端
     * stream_wrapper_restore函数：恢复一个事先注销的数据包
     * stream_wrapper_unregister函数：注销一个URL地址包
     */
}
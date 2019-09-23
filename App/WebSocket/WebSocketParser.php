<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19-9-23
 * Time: 上午10:25
 */

namespace App\WebSocket;


use EasySwoole\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Socket\Bean\Caller;
use EasySwoole\Socket\Bean\Response;

class WebSocketParser implements ParserInterface
{

    public function decode($raw, $client): ?Caller
    {
        // TODO: Implement decode() method.
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            echo "decode message error! \n";
            return null;
        }

        // new 调用者对象
        $caller =  new Caller();
        /**
         * 设置被调用的类 这里会将ws消息中的 class 参数解析为具体想访问的控制器
         * 如果更喜欢 event 方式 可以自定义 event 和具体的类的 map 即可
         * 注 目前 easyswoole 3.0.4 版本及以下 不支持直接传递 class string 可以通过这种方式
         */
        $class = '\\App\\WebSocket\\'. ucfirst($data['class'] ?? 'Index');
        $caller->setControllerClass($class);

        // 提供一个事件风格的写法
//         $eventMap = [
//             'index' => Index::class
//         ];
//         $caller->setControllerClass($eventMap[$data['class']] ?? Index::class);

        // 设置被调用的方法
        $caller->setAction($data['action'] ?? 'index');
        // 检查是否存在args
        if (!empty($data['content'])) {
            // content 无法解析为array 时 返回 content => string 格式
            $args = is_array($data['content']) ? $data['content'] : ['content' => $data['content']];
        }

        // 设置被调用的Args
        $caller->setArgs($args ?? []);
        return $caller;

    }

    public function encode(Response $response, $client): ?string
    {
        // TODO: Implement encode() method.

        /**
         * 这里返回响应给客户端的信息
         * 这里应当只做统一的encode操作 具体的状态等应当由 Controller处理
         */
        return $response->getMessage();

    }
}
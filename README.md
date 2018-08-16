### php_rabbit使用教程
---

1. 入门

    1.安装包

    2.配置项目根目录: vendor/bin/rabbit_manager rabbit:config your_project_root_path

    3.项目根目录下配置rabbit.yml,具体样式参照php_rabbit包根目录下的rabbit.yml

    4.生成队列: vendor/bin/rabbit_manager rabbit:declare-all

2. 发送消息:

    1.确保rabbit.yml配置文件配置好producer

    2.引入 Cto\Rabbit\Publisher\Publisher

    3.Publisher::publish($publisher, $message, $messageAttributesArray)

3. 消费消息：

    1.确保rabbit.yml配置文件配置好consumer

    2.消费者回调需要能够被composer的autoload.php自动导入

    3.消费者回调继承Cto\Rabbit\Consumer\AbstractConsumer,实现consumer方法

    4.vendor/bin/rabbit_manager rabbit:consume your_consumer_name

4. todo

    1.测试、调试

    2.整合supervisorr消费者
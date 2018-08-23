### php_rabbit使用教程
---

1. 初始化

    1.安装包

    2.项目根目录下配置rabbit.yml,具体样式参照php_rabbit包根目录下的rabbit.yml

    3.生成队列: vendor/bin/rabbit_manager rabbit:declare-all

2. 发送消息:

    1.确保rabbit.yml配置文件配置好producer

    2.引入 Cto\Rabbit\Publisher\Publisher

    3.Publisher::publish($publisher, $message, $messageAttributesArray)

3. 消费消息：

    1.确保rabbit.yml配置文件配置好consumer

    2.消费者回调需要能够被composer的autoload.php自动导入

    3.消费者回调继承Cto\Rabbit\Consumer\AbstractConsumer,实现consumer方法

    4.vendor/bin/rabbit_manager rabbit:consume consumer_name

4. 消费者进程配置基础:

    1.配置consumer的num_procs等参数，具体参数可参考php_rabbit下的rabbit.yml

    2.vendor/bin/rabbit_manager rabbit:consumer:pcntl config consumer_name生成consumer_name的进程配置文件

    3.vendor/bin/rabbit_manager rabbit:consumer:pcntl init consumer_name初始化进程管理器

    4.vendor/bin/rabbit_manager rabbit:consumer:pcntl start consumer_name启动指定配置的consumer

    5.vendor/bin/rabbit_manager rabbit:consumer:pcntl status consumer_name显示指定消费者的状态

    6.vendor/bin/rabbit_manager rabbit:consumer:pcntl stop consumer_name停止消费者

5. 更新消费者进程配置: 

    1.修改rabbit.yml

    2.vendor/bin/rabbit_manager rabbit:consumer:pcntl config consumer_name

    3.vendor/bin/rabbit_manager rabbit:consumer:pcntl reload consumer_name

    4.vendor/bin/rabbit_manager rabbit:consumer:pcntl start consumer_name
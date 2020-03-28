### hyperf-nacos
> Hyperf 框架下关于 Nacos 微服务的 php SDK

#### 安装
```shell
composer require daodao97/hyperf-nacos
```

#### 发布配置文件

```shell
php bin/hyperf.php vendor:publish daodao97/hyperf-nacos
```

#### 目录结构
```shell
./src
├── Config   配置中心的拉取,监听
│   ├── FetchConfigProcess.php
│   ├── OnPipeMessageListener.php
│   └── PipeMessage.php
├── ConfigProvider.php Hyperf扩展配置
├── Helper 一些帮助方法
│   └── func.php
├── Lib   Nacos相关API封装
│   ├── AbstractNacos.php
│   ├── NacosConfig.php
│   ├── NacosInstance.php
│   ├── NacosOperator.php
│   └── NacosService.php
├── Listener  事件监听
│   └── BootAppConfListener.php
├── Model 领域内模型
│   ├── AbstractModel.php
│   ├── ConfigModel.php
│   ├── InstanceModel.php
│   └── ServiceModel.php
├── Process  自定义进程
│   └── InstanceBeatProcess.php
├── ThisInstance.php
└── Util 辅助工具
    ├── Guzzle.php
    └── RemoteConfig.php
```

### 配置的合并与更新

`BootAppConfListener.php` 系统启动时将拉取远程配置, 并合入`hyperf` 的 `Config`
`FetchConfigProcess.php` 自定义进程将监听配置, 若有更新将发送`PipeMessage` 到各服务`worker`进程, 并合入当前进程的 `Config`

### 服务的注册

`BootAppConfListener.php` 将在系统启动完成时自动完成`实例注册`, `服务注册` 

#### 依赖扩展

`ext-json`, `ext-yaml`, `ext-simplexml`

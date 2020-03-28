<?php
declare(strict_types = 1);
namespace Hyperf\Nacos\Process;

use Hyperf\Logger\LoggerFactory;
use Hyperf\Nacos\Lib\NacosInstance;
use Hyperf\Nacos\ThisInstance;
use Hyperf\Process\AbstractProcess;

class InstanceBeatProcess extends AbstractProcess
{
    public $name = 'nacos-beat';

    public function handle(): void
    {
        /** @var ThisInstance $instance */
        $instance = make(ThisInstance::class);
        /** @var NacosInstance $nacos_instance */
        $nacos_instance = make(NacosInstance::class);

        $logger = container(LoggerFactory::class)->get('nacos');
        while (true) {
            sleep(config('nacos.client.beatInterval', 5));
            if (!$nacos_instance->beat($instance->serviceName, $instance, $instance->groupName, $instance->ephemeral)) {
                $logger->error("nacos send beat fail}", compact('instance'));
            } else {
                $logger->info('nacos send beat success!', compact('instance'));
            }
        }

    }

    public function isEnable(): bool
    {
        return config('nacos.client.beatenable', false);
    }
}

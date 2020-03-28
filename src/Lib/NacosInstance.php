<?php

namespace Hyperf\Nacos\Lib;

use Hyperf\Nacos\Model\InstanceModel;

class NacosInstance extends AbstractNacos
{
    public function register(InstanceModel $instanceModel)
    {
        return $this->request('POST', "/nacos/v1/ns/instance?{$instanceModel}") == 'ok';
    }

    public function delete(InstanceModel $instanceModel)
    {
        return $this->request('DELETE', "/nacos/v1/ns/instance?{$instanceModel}") == 'ok';
    }

    public function update(InstanceModel $instanceModel)
    {
        $instanceModel->healthy = null;

        return $this->request('PUT', "/nacos/v1/ns/instance?{$instanceModel}") == 'ok';
    }

    public function list($serviceName, $groupName = null, $namespaceId = null, array $clusters = [], $healthyOnly = null)
    {
        $params = array_filter(compact('serviceName', 'groupName', 'namespaceId', 'clusters', 'healthyOnly'));
        if (isset($params['clusters'])) {
            $params['clusters'] = implode(',', $params['clusters']);
        }
        $params_str = http_build_query($params);

        return $this->request('GET', "/nacos/v1/ns/instance/list?{$params_str}");
    }

    public function detail(InstanceModel $instanceModel)
    {
        return $this->request('GET', "/nacos/v1/ns/instance?{$instanceModel}");
    }

    public function beat($serviceName, InstanceModel $instanceModel, $groupName = null, $ephemeral = null)
    {
        $params = array_filter(compact('serviceName', 'beat', 'groupName', 'ephemeral'));
        $params['beat'] = $instanceModel->toJson();
        $params_str = http_build_query($params);

        return $this->request('PUT', "/nacos/v1/ns/instance/beat?{$params_str}");
    }

    public function upHealth(InstanceModel $instanceModel)
    {
        if ($instanceModel->healthy === null) {
            $instanceModel->healthy = true;
        }

        return $this->request('PUT', "/nacos/v1/ns/health/instance?{$instanceModel}") == 'ok';
    }
}

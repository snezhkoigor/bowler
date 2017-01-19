<?php

namespace Vinelab\Bowler\Traits;

/**
 * @author Kinane Domloje <kinane@vinelab.com>
 */
trait HelperTrait
{
    /**
     * Compiles the parameters passed to the constructor.
     *
     * @return array
     */
    private function compileParameters()
    {
        $params = [
                'queueName' => property_exists($this, 'queueName') ? $this->queueName : null,
                'exchangeName' => $this->exchangeName,
                'exchangeType' => $this->exchangeType,
                'passive' => $this->passive,
                'durable' => $this->durable,
                'autoDelete' => $this->autoDelete,
                'deliveryMode' => property_exists($this, 'deliveryMode') ? $this->deliveryMode : null,
            ];

        property_exists($this, 'routingKey') ? ($params['routingKey'] = $this->routingKey) : ($params['bindingKeys'] = $this->bindingKeys);

        return array_filter($params);
    }
}

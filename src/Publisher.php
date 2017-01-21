<?php

namespace Vinelab\Bowler;

/**
 * @author Kinane Domloje <kinane@vinelab.com>
 */
class Publisher extends Producer
{
    /**
     * Part of the out-of-the-box Pub/Sub implementation
     * Default exchange name is `pub-sub` of type `direct`.
     *
     * @param Vinelab\Bowler\Connection $connection
     * @param string                    $routingKey
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    public function setRoutingKey($routingKey)
    {
        $this->setup('pub-sub', 'direct', $routingKey);
    }
}

<?php
namespace Application\RestResource;

use ZF\Rest\AbstractResourceListener;
use ZF\Rest\ResourceEvent;

abstract class RestResourceAbstract extends AbstractResourceListener
{
    public function dispatch(ResourceEvent $event)
    {
        
    }
}
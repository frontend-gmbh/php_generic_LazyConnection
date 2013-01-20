<?php
/**
 * User: Patrick Schinkel schinkel@schinkelmedia.com
 * Date: 20.01.13
 * Time: 12:46
 */


class LazyConnectionController{
    /**
     * @var LazyConnectionModel[]
     */
    private $connections = array();

    public function addConnection($name, $openCallback, $closeCallback){
        $this->connections[$name] = new LazyConnectionModel($openCallback,$closeCallback);
    }




}




<?php
/**
 * User: Patrick Schinkel schinkel@schinkelmedia.com
 * Date: 20.01.13
 * Time: 12:46
 */


class LazyConnector{
    /**
     * @var LazyConnection[]
     */
    private $connections = array();

    /**
     * Creates a new lazy connection
     * @param string $name
     * @param callback $openCallback
     * @param callback $closeCallback
     */
    public function addConnection($name, $openCallback, $closeCallback){
        $this->connections[$name] = new LazyConnection($openCallback,$closeCallback);
    }

    /**
     * Manually opens a connection
     * @param string $name
     */
    public function manuallyOpenConnection($name){
        $this->connections[$name]->manualOpen();
    }

    /**
     * Manually closes a connection and destroys the object
     * @param string $name
     */
    public function manuallyCloseConnection($name){
        unset($this->connections[$name]);
    }

    /**
     * returns a connection handler
     * @param string $name
     * @return mixed|null
     */
    public function getHandler($name){
        return $this->connections[$name]->getHandler();
    }
}




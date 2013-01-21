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
     * @param string $name Name of the connection
     * @param callback $openCallback
     * @param callback $closeCallback
     * @param bool $lazy
     */
    public function addConnection($name, $openCallback, $closeCallback = null, $lazy = true){
        $this->connections[$name] = new LazyConnection($openCallback,$closeCallback);
        if(!$lazy){
            $this->manuallyOpenConnection($name);
        }
    }

    /**
     * Manually opens a connection
     * @param string $name Name of the connection
     */
    public function manuallyOpenConnection($name){
        $this->connections[$name]->manuallyOpen();
    }

    /**
     * Manually closes a connection and destroys the object
     * @param string $name Name of the connection
     */
    public function manuallyCloseConnection($name){
        unset($this->connections[$name]);
    }

    /**
     * returns a connection handler
     * @param string $name Name of the connection
     * @return mixed|null
     */
    public function getHandler($name){
        return $this->connections[$name]->getHandler();
    }

    /**
     * adds a function to the connection
     * @param string $name Name of the connection
     * @param string $gettername Name of the get-function
     * @param callback $getCallback Callbackfunction function($handler,$key){..}
     */
    public function addConnectionfunction($name,$gettername, $getCallback){
        $this->connections[$name]->addConnectionfunction($gettername,$getCallback);
    }

    /**
     * uses a function of the connection
     * @param string $name Name of the connection
     * @param string $gettername Name of the get-function
     * @param string $key key to get the data sessionkey, query-string etc
     * @return mixed|null
     */
    public function useConnectionfunction($name,$gettername,$key){
        return $this->connections[$name]->connectionfunction($gettername,$key);
    }
}




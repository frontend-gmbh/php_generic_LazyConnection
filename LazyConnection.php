<?php
/**
 * User: Patrick Schinkel schinkel@schinkelmedia.com
 * Date: 20.01.13
 * Time: 12:46
 * Handles one lazy connection
 */
class LazyConnection{
    /**
     * tells if a connection is initialised
     * @var bool
     */
    private $connected = false;
    /**
     * Callback for opening the connection
     * @var callback
     */
    private $openCallback = null;
    /**
     * Callback for closing the connection
     * @var callback
     */
    private $closeCallback = null;
    /**
     * Connection-handler
     * @var mixed
     */
    private $handler = null;
    /**
     * Callbacks to get data
     * @var callback[]
     */
    private $connectionCallbacks = array();

    /**
     * Set Callback for connection
     * @param callback $openCallback
     * @param callback $closeCallback
     */
    function __construct($openCallback, $closeCallback){
        $this->openCallback = $openCallback;
        $this->closeCallback = $closeCallback;
    }

    /**
     * destruct open connections at destruction/scripttermination
     */
    function __destruct(){
        if($this->connected && $this->closeCallback!=null){
            $func = $this->closeCallback;
            $func($this->getHandler());
        }
    }

    /**
     * manually opens a connection
     */
    public function manuallyOpen(){
        $func = $this->openCallback;
        $handler = $func();
        if($handler!=0 && $handler!=null){
            $this->connected = true;
            $this->handler = $handler;
        }
    }

    /**
     * returns the eventhandler
     * if necessary it opens a connection
     * @return mixed|null
     */
    public function getHandler(){
        if(!$this->connected){
            $this->manuallyOpen();
        }
        return $this->handler;
    }

    /**
     * adds a new connection function
     * if necessary it opens a connection
     * @param string $name
     * @param callback $callback Callbackfunction function($handler,$key){..}
     */
    public function addConnectionfunction($name, $callback){
        $this->connectionCallbacks[$name] = $callback;
    }

    /**
     * Gets data from the connection
     * uses with addConnectionfunction predefined functions
     * @param string $name name of the connection function
     * @param string $key key to get the data sessionkey, query-string etc
     * @return mixed|null
     */
    public function connectionfunction($name,$key){
        $func = $this->connectionCallbacks[$name];
        return $func($this->getHandler(),$key);
    }
}
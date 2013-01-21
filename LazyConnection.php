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
            $this->closeCallback();
        }
    }

    /**
     * manually opens a connection
     */
    public function manuallyOpen(){
        $handler = $this->openCallback();
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
}
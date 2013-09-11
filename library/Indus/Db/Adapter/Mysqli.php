<?php

class Indus_Db_Adapter_Mysqli{
    /**
     * 数据库连接资源
     * @var resource|null
     */
    private $_connection = null;
    
    private $_errno = 0;
    private $_error = null;
    /**
     * 连接数据库配置项
     * @var array('host'=>..,'username'=>..,'password'=>..,'dbname'=>..,'port'=>..,'charset'=>..,..)
     */
    private $_config = array();
    
    public function __construct($host = '127.0.0.1', $username = 'root', $password = '', $dbname = 'test', $port = 3306, $charset = ''){
        $this->_config = array(
                'host' => $host,
                'username' => $username,
                'password' => $password,
                'dbname' => $dbname,
                'port' => $port,
                'charset' => $charset
        );
        
        return $this->_connect();
    }
    
    protected function _connect(){
        if ($this->_connection) {
            return $this->_connection;
        }
        
        if (!extension_loaded('mysqli')) {
            $this->_error = 'mysqli扩展加载失败，请检查！';
            return false;
        }
        
        $this->_connection = mysqli_init();
        
        $this->_connection = @mysqli_real_connect($this->_connection, $this->_config['host'], $this->_config['username'], $this->_config['password'], $this->_config['dbname'], $this->_config['port']);
        if ($this->_connection === false || mysqli_connect_errno()) {
            $this->_errno = mysqli_connect_errno();
            $this->_error = mysqli_connect_error().'数据库连接失败！';
            return false;
        }
        
        if (!empty($this->_config['charset'])) {
            mysqli_set_charset($this->_connection, $this->_config['charset']);
        }
        
        return $this->_connection;
    }
    
    public function getErrno(){
        return $this->_errno;
    }
    
    public function getError(){
        return $this->_error;
    }
}
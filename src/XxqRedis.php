<?php
/**
 * Created by PhpStorm.
 * User: xuxianqiong
 * Date: 2021/5/26
 * Time: 下午2:37
 */

namespace  XxqRedis;

use Exception;
use Predis\Client;

class XxqRedis
{
    /** @var  \Redis */
    protected $redis;

    protected $options = [
        'expire'     => 60,
        'default'    => 'default',
        'host'       => '127.0.0.1',
        'port'       => 6379,
        'password'   => '',
        'select'     => 0,
        'timeout'    => 0,
        'persistent' => false,
    ];

    public function __construct(array $options)
    {
        if(!extension_loaded('redis')){
            throw new Exception('redis扩展未安装');
        }
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        if(class_exists('\Predis\Client')){
            $params = [];
            foreach ($this->options as $key => $val) {
                if (in_array($key, ['aggregate', 'cluster', 'connections', 'exceptions', 'prefix', 'profile', 'replication', 'parameters'])) {
                    $params[$key] = $val;
                    unset($this->options[$key]);
                }
            }
            $op=$this->options;
            if ('' == $this->options['password']) {
                unset($this->options['password']);
            }

            if($this->options['redis_type']=='cluster'){
                $this->options=$this->options['cluster_config'];
            }
            $this->redis = new \Predis\Client($this->options, $params);
            $this->options=$op;
            $this->options['prefix'] = '';
        }else{
            $func        = $this->options['persistent'] ? 'pconnect' : 'connect';
            $this->redis = new \Redis();
            $this->redis->$func($this->options['host'], $this->options['port'], $this->options['timeout']);
        }

    }

    /**
     * 将一个值插入到列表头部
     * @param $key
     * @param $value
     * @return bool|int
     */
    public function lPush($key, $value){
        return $this->redis->lPush($key, $value);
    }

    /**
     * 于将一个值插入到列表的尾部(最右边)
     * @param $key
     * @param $value
     * @return bool|int
     */
    public function rPush($key, $value){
        return $this->redis->rPush($key, $value);
    }

    /**
     * 移出并获取列表的第一个元素
     * @param $key
     * @return string
     */
    public function lPop( $key ) {
        return $this->redis->lPop($key);
    }
    /**
     * 用于移除列表的最后一个元素，返回值为移除的元素
     * @param $key
     * @return string
     */
    public function rPop( $key ) {
        return $this->redis->rPop($key);
    }

    /**
     * 用于返回列表的长度
     * @param $key
     * @return int
     */
    public function lLen($key){
        return $this->redis->lLen($key);
    }

    /**
     * 回列表中指定区间内的元素
     * @param $key
     * @param $start
     * @param $end
     * @return array
     */
    public function lRange($key, $start, $end){
        return $this->redis->lRange($key, $start, $end);
    }

    /**
     * @param $key
     * @param $value
     * @param int $timeout
     * @return bool
     */
    public function set($key, $value, $timeout = 0){
        return $this->redis->set($key, $value, $timeout);
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function get($key){
        return $this->redis->get($key);
    }
    /**
     * 检查给定 key 是否存在
     * @param $key
     * @return bool
     */
    public function exists($key){
        return $this->redis->exists($key);
    }

    /**
     * 删除已存在的键
     * @param $key
     * @return int
     */
    public function del($key){
        return $this->redis->del($key);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function _serialize( $value ) {
        return $this->redis->_serialize($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function _unserialize( $value ) {
        return $this->redis->_unserialize($value);
    }

    /**
     * 监视一个(或多个) key ，如果在事务执行之前这个(或这些) key 被其他命令所改动，那么事务将被打断
     * @param $key
     */
    public function watch( $key ) {
        return $this->redis->watch($key);
    }

    /**
     * 取消 WATCH 命令对所有 key 的监视
     */
    public function unwatch( ) {
        return $this->redis->unwatch();
    }

    /**
     * 用于标记一个事务块的开始。
     * 事务块内的多条命令会按照先后顺序被放进一个队列当中，最后由 EXEC 命令原子性(atomic)地执行。
     * @return \Redis
     */
    public function multi() {
        return $this->redis->multi();
    }

    /**
     * 执行所有事务块内的命令
     * @return array
     */
    public function exec() {
        return $this->redis->exec();
    }

}
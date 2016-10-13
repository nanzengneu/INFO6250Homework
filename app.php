<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Chicago');
require 'Predis/Autoloader.php';
use Predis\Collection\Iterator; 
Predis\Autoloader::register();
$date = new DateTime();
$timestamp=$date->getTimestamp();
$curr_date=date_format($date, 'Y/m/d H:i:s');
$curr_date_min=date_format($date, 'Y/m/d H:i');
if (isset($_GET['cmd']) === true) {
  $host = 'redis-master';
  if (getenv('GET_HOSTS_FROM') == 'env') {
    $host=getenv('REDIS_MASTER_SERVICE_HOST');
  }
  header('Content-Type: application/json');
  switch ($_GET['cmd']){
    case 'set':
       $client = new Predis\Client([
        'scheme'=> 'tcp',
        'host'  => $host,
        'port'  => 6379,
       ]);
       $client->set($_GET['key'],$_GET['value']);
       print('{"message": "Updated"}');
       break;
    case 'append':
       $client = new Predis\Client([
        'scheme'=> 'tcp',
        'host'  => $host,
        'port'  => 6379,
       ]);
       $key=$_GET['key'];
       $val=",".$_GET['value'];
       $client->append($key,$val);
       print('{"message": "Updated"}');
       break;
    case 'get':
       $host = 'redis-slave';
       if (getenv('GET_HOSTS_FROM') == 'env') {
        $host = getenv('REDIS_SLAVE_SERVICE_HOST');
       }
       $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $host,
        'port'   => 6379,
       ]);
       $value = $client->get($_GET['key']);
       print('{"data": "' . $value.'"}');
       break;
    case 'val_cnt_by_key':
       $host = 'redis-slave';
       if (getenv('GET_HOSTS_FROM') == 'env') {
        $host = getenv('REDIS_SLAVE_SERVICE_HOST');
       }
       $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $host,
        'port'   => 6379,
       ]);
       $key=$_GET['key'];
       $value_raw = $client->get($key);
       $value_arr = explode(",",$value_raw);
       print($key.",".count($value_arr));
       break;
    case 'cnt_by_keys':
       $host = 'redis-slave';
       if (getenv('GET_HOSTS_FROM') == 'env') {
        $host = getenv('REDIS_SLAVE_SERVICE_HOST');
       }
       $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $host,
        'port'   => 6379,
       ]);
       $key_arr = $client->keys($_GET['key']);
       foreach($key_arr as $key){
         $value_raw = $client->get($key);
         $value_arr = explode(",",$value_raw);
         print($key.",".count($value_arr).PHP_EOL);
       }
       break;
    case 'keys':
       $host = 'redis-slave';
       if (getenv('GET_HOSTS_FROM') == 'env') {
        $host = getenv('REDIS_SLAVE_SERVICE_HOST');
       }
       $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $host,
        'port'   => 6379,
       ]);
       $key_arr = $client->keys($_GET['key']);
    	foreach($key_arr as $key){
         $value = $client->get($key);
         print($key."-".$value.PHP_EOL);
       }
       break;
    case 'purge':
       $host = 'redis-master';
       if (getenv('GET_HOSTS_FROM') == 'env') {
        $host = getenv('REDIS_MASTER_SERVICE_HOST');
       }
       $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $host,
        'port'   => 6379,
        'profile'=>'2.8',
       ]);
       $client->flushall();
       print('{"message": "Flashed"}');
       break;
    case 'all':
       $host = 'redis-slave';
       if (getenv('GET_HOSTS_FROM') == 'env') {
        $host = getenv('REDIS_SLAVE_SERVICE_HOST');
       }
       $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $host,
        'port'   => 6379,
        'profile'=>'2.8',
       ]);
       $dbsize=$client->dbsize();
       print('DBZIE='.$dbsize.PHP_EOL);
       if (empty($_GET['pattern']))
        $pattern='*';
       else
        $pattern=$_GET['pattern'];
       foreach (new Iterator\Keyspace($client, $pattern) as $key) {
        $val = $client->get($key);
        print($key.",".$val);
       }
       break;
    default:
       print('http://host/app.php?cmd=set&key=key1&value=val1'.PHP_EOL);
       print('http://host/app.php?cmd=append&key=key1&value=val1'.PHP_EOL);
       print('http://host/app.php?cmd=get&key=key1'.PHP_EOL);
       print('http://host/app.php?cmd=all'.PHP_EOL);
       print('http://host/app.php?cmd=all&pattern=*a*'.PHP_EOL);
       print('http://host/app.php?cmd=all&pattern=*a*'.PHP_EOL);
       print('http://host/app.php?cmd=append&key=timestamp&value=val&opt=opt'.PHP_EOL);
       print('http://host/app.php?cmd=keys&key=TS*us*'.PHP_EOL);
       print('http://host/app.php?cmd=keys&key=TS*us*'.PHP_EOL);
       print('http://host/app.php?cmd=cnt_by_keys&key=TS*'.PHP_EOL);
       print('http://host/app.php?cmd=val_cnt_by_key&key=SupplyEvents'.PHP_EOL);
  }
} else {
  print('http://host/app.php?cmd');
  phpinfo();
} ?>

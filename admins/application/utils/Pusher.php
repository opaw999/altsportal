<?php 
require 'vendor/autoload.php';

class Pusher {

  private $appId = '1213133';
  private $appKey = 'b49163b6de1bae4c1c2f';
  private $appSecret = 'ff1f638d357e0d19019c';

  private $options = [
  	'cluster' => 'ap1',
    'useTLS' => true
  ];

  private $pusher;

  public function __construct() {
  	$this->pusher = new Pusher\Pusher(
      $this->appKey,
      $this->appSecret,
      $this->appId,
      $this->options
    );
  }

  public function broadcast($channel, $event, $data)
  {
  	$this->pusher->trigger($channel, $event, $data);
  }

}
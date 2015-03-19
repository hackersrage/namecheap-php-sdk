
```
$config = new \Namecheap\Config();
$config->apiUser('example-user')
    ->apiKey('api-key')
    ->clientIp('your-ip')
    ->sandbox(true);

$command = Namecheap\Api::factory($config, 'domains.getList');
$command->dispatch();
```
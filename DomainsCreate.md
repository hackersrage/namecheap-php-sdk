
```
$config = new \Namecheap\Config();
$config->apiUser('example-user')
    ->apiKey('api-key')
    ->clientIp('your-ip')
    ->sandbox(true);

$command = Namecheap\Api::factory($config, 'domains.create');
$command->setParams(array(
    'DomainName' => 'example.com',
    'RegistrantFirstName' => 'John',
    'RegistrantLastName' => 'Smith',
))->dispatch();

if ($command->status() == 'error') { die($command->errorMessage); }
```
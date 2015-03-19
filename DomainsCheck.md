
```
$config = new \Namecheap\Config();
$config->apiUser('example-user')
    ->apiKey('api-key')
    ->clientIp('your-ip')
    ->sandbox(true);

$command = Namecheap\Api::factory($config, 'domains.check');

// Pass a comma-separated list to domainList
$command->domainList(array('example1.com', 'example2'))->dispatch();

// OR pass an array to domainList
$command->domainList('example1.com,example2.com')->dispatch();

// Check single domain
echo 'example1.com';
echo ($command->isAvailable('example1.com') === true) ? ' available' : ' not available';
echo "<br/>\n";

// Throws exception
echo 'billybob.com';
echo ($command->isAvailable('billybob.com') === true) ? ' available' : ' not available';
echo "<br/>\n";

// Loop through each returned domain
foreach ($command->domains as $domain => $available):
    echo $domain;
    echo ($available === true) ? ' available' : ' not available';
    echo "<br/>\n";
endforeach;
```
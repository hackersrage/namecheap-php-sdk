<?php

namespace Namecheap\Command\Domains\Dns\GetHosts
{
	class Exception extends \Exception {}
}

namespace Namecheap\Command\Domains\Dns
{
	class GetHosts extends \Namecheap\Command\ACommand
	{
		public $data = array();
		protected $_hosts = array();

		public function command()
		{
			return 'namecheap.domains.dns.getHosts';
		}

		public function params()
		{
			return array(
				'TLD'			=> 'com',
				'SLD'			=> null,
			);
		}

		/**
		 * Process domains array
		 */
		protected function _postDispatch()
		{
			$result = $this->_response->DomainDNSGetHostsResult;

			$this->data = array();
			$this->data['emailType'] = (string) $result->attributes()->EmailType;
			$this->data['namecheapDns'] = ((string) $result->attributes()->IsUsingOurDNS == 'true') ? true : false;

			// Process host records
			$this->_hosts = array();
			foreach ($this->_response->DomainDNSGetHostsResult->host as $entry)
			{
				$domain = array();
				foreach ($entry->attributes() as $key => $value)
				{
					$domain[$key] = (string) $value;
				}
				$this->_hosts[$domain['HostId']] = new \Namecheap\DnsRecord($domain);
			}
		}

		/**
		 * Get/set method for domain name, which is comprised of sld + tld
		 * @param string $value
		 * @return mixed
		 */
		public function domainName($value = null)
		{
			if (null !== $value)
			{
				list($sld, $tld) = explode('.', $value);
				$this->setParam('SLD', (string) substr($sld, 0, 70));
				$this->setParam('TLD', (string) substr($tld, 0, 10));
				return $this;
			}
			return $this->getParam('SLD') . '.' . $this->getParam('TLD');
		}
	}
}

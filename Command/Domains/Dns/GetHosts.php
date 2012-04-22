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
				'TLD'	=> 'com',
				'SLD'	=> null,
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
				$this->_hosts[$domain['Name']] = new \Namecheap\DnsRecord($domain);
			}
		}

		/**
		 * Return the DnsRecord object for host
		 * @param string $key
		 * @return Namecheap\DnsRecord
		 */
		public function getHost($key)
		{
			return (isset($this->_hosts[$key])) ? $this->_hosts[$key] : false;
		}

		/**
		 * Set the DnsRecord object for host
		 * @param string $key
		 * @param Namecheap\DnsRecord
		 * @return mixed
		 */
		public function setHost($key, \Namecheap\DnsRecord $value)
		{
			$this->_hosts[$key] = $value;
			return $this;
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

		/**
		 * Return the array of hosts
		 * @return array
		 */
		public function hosts()
		{
			return (array) $this->_hosts;
		}

		/**
		 * Return the DnsRecord object for host
		 * @param string $key
		 * @return Namecheap\DnsRecord
		 */
		public function host($key, \Namecheap\DnsRecord $value = null)
		{
			if (null !== $value)
			{
				return $this->setHost($key, $value);
			}
			return $this->getHost($key);
		}

		/**
		 * Add DnsRecord object for host
		 * @param Namecheap\DnsRecord $record
		 * @return Namecheap\DnsRecord
		 */
		public function addHost(\Namecheap\DnsRecord $record)
		{
			if (strlen($record->host) < 1)
			{
				throw new GetHosts\Exception('No host set');
			}
			
			return $this->setHost($record->host, $record);
		}
	}
}

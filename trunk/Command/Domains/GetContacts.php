<?php

namespace Namecheap\Command\Domains\GetContacts
{
	class Exception extends \Exception {}
}

namespace Namecheap\Command\Domains
{
	class GetContacts extends \Namecheap\Command\ACommand
	{
		public function command()
		{
			return 'namecheap.domains.getContacts';
		}

		public function params()
		{
			return array(
				'DomainName'	=> null,
			);
		}

		/**
		 * Process domains array
		 */
		protected function _postDispatch()
		{
			$domains = array();
			foreach ($this->_response->DomainContactsResult->Domain as $entry)
			{
				$domain = array();
				foreach ($entry->attributes() as $key => $value)
				{
					$domain[$key] = (string) $value;
				}
				$domains[] = $domain;
			}
			d($domains);
		}

		/**
		 * Get/set method for domain name
		 * @param string $value
		 * @return mixed
		 */
		public function domainName($value = null)
		{
			if (null !== $value)
			{
				$this->setParam('DomainName', (string) substr($value, 0, 70));
				return $this;
			}
			$this->getParam('DomainName');
		}

	}
}

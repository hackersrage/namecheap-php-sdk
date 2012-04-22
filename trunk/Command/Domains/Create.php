<?php

namespace Namecheap\Command\Domains\Create
{
	class Exception extends \Exception {}
}

namespace Namecheap\Command\Domains
{
	class Create extends \Namecheap\Command\ACommand
	{
		public $domain = array();

		public function command()
		{
			return 'namecheap.domains.create';
		}

		public function params()
		{
			return array(
				'DomainName'	=> null,
				'Years'			=> 1,
			);
		}

		/**
		 * Process domains array
		 */
		protected function _postDispatch()
		{
			foreach ($this->_response->DomainCreateResult->Domain as $entry)
			{
				$domain = array();
				foreach ($entry->attributes() as $key => $value)
				{
					$domain[$key] = (string) $value;
				}
				$this->domain[] = $domain;
			}
		}

		/**
		 * Get/set method for domain list, limited to 1024 characters
		 * @param string|array $value
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

<?php

namespace Namecheap\DnsRecord
{
	class Exception extends \Exception {};
}

namespace Namecheap
{
	class DnsRecord
	{
		protected $_data = array(
			'sld'		=> null,
			'tld'		=> null,
			'hostId'	=> null,
			'host'		=> null,
			'type'		=> 'A',
			'address'	=> null,
			'mxPref'	=> 0,
			'ttl'		=> 1800,
		);

		/**
		 * Class constructor
		 */
		public function __construct($config = array())
		{
			foreach ($config as $key => $value)
			{
				switch ($key)
				{
					case 'SLD':
						$key = 'sld'; break;

					case 'TLD':
						$key = 'tld'; break;

					case 'HostId':
						$key = 'hostId'; break;

					case 'Name':
						$key = 'host'; break;

					case 'Type':
						$key = 'type'; break;

					case 'Address':
						$key = 'address'; break;

					case 'MXPref':
						$key = 'mxPref'; break;

					case 'TTL':
						$key = 'ttl'; break;

					default:
						continue;
				}

				if (array_key_exists($key, $this->_data))
				{
					$method = 'set' . ucfirst($key);
					$this->$method($value);
				}
			}
		}

		/**
		 * Magic get method. Calls getKey if key is a valid property
		 * @param string $key
		 * @return mixed
		 */
		public function __get($key)
		{
			$key = $this->_checkKey($key);

			$method = 'get' . ucfirst($key);
			return $this->$method();
		}

		/**
		 * Magic set method. Calls setKey(value) if key is a valid property
		 * @param string $key
		 * @param mixed $value
		 * @return mixed
		 */
		public function __set($key, $value)
		{
			$key = $this->_checkKey($key);

			$method = 'set' . ucfirst($key);
			$this->$method($value);
		}

		/**
		 * Magic isset(). Returns true/false for if _data[key] is set
		 * @param string $key
		 * @return bool
		 */
		public function __isset($key)
		{
			return isset($this->_data[$key]);
		}

		/**
		 * Verify key is valid
		 * @param string $key
		 * @return string
		 * @throws Config\Exception
		 */
		protected function _checkKey($key)
		{
			$key = (string) $key;
			if (!array_key_exists($key, $this->_data))
			{
				throw new Config\Exception(__CLASS__ . ' does not have the property ' . $key);
			}
			return $key;
		}

		/**
		 * Performs self check on options. Command classes should call this before making api call
		 * @return DnsRecord
		 */
		public function check()
		{
			return $this;
		}

		/**
		 * Set the SLD
		 * @param string $value
		 * @return DnsRecord
		 */
		public function setSld($value)
		{
			$this->_data['sld'] = (string) substr($value, 0, 70);
			return $this;
		}

		/**
		 * Set the TLD
		 * @param string $value
		 * @return DnsRecord
		 */
		public function setTld($value)
		{
			$this->_data['tld'] = (string) substr($value, 0, 10);
			return $this;
		}

		/**
		 * Set the host id
		 * @param int $value
		 * @return DnsRecord
		 */
		public function setHostId($value)
		{
			$this->_data['hostId'] = (int) substr($value, 0, 10);
			return $this;
		}

		/**
		 * Set the host
		 * @param string $value
		 * @return DnsRecord
		 */
		public function setHost($value)
		{
			$this->_data['host'] = (string) substr($value, 0, 70);
			return $this;
		}

		/**
		 * Set the record type
		 * @param string $value
		 * @return DnsRecord
		 */
		public function setType($value)
		{
			// Force upper case
			$value = strtoupper($value);

			switch ($value)
			{
				case 'A': break;
				case 'AAAA': break;
				case 'CNAME': break;
				case 'MX': break;
				case 'MXE': break;
				case 'TXT': break;
				case 'URL': break;
				case 'URL301': break;
				case 'FRAME': break;
				default: $value = 'A';
			}

			$this->_data['type'] = (string) $value;
			return $this;
		}

		/**
		 * Set record address
		 * @param string $value
		 * @return DnsRecord
		 */
		public function setAddress($value)
		{
			$this->_data['address'] = (string) substr($value, 0, 70);
			return $this;
		}

		/**
		 * Set MX preference
		 * @param int $value
		 * @return DnsRecord
		 */
		public function setMxPref($value)
		{
			$this->_data['mxPref'] = (int) substr($value, 0, 3);
			return $this;
		}

		/**
		 * Set TTL
		 * @param int $value
		 * @return DnsRecord
		 */
		public function setTtl($value)
		{
			$this->_data['ttl'] = (int) substr($value, 0, 10);
			return $this;
		}

		/**
		 * Get SLD
		 * @return string
		 */
		public function getSld()
		{
			return (string) $this->_data['sld'];
		}

		/**
		 * Get TLD
		 * @return string
		 */
		public function getTld()
		{
			return (string) $this->_data['tld'];
		}

		/**
		 * Get host id
		 * @return int
		 */
		public function getHostId()
		{
			return (int) $this->_data['hostId'];
		}

		/**
		 * Get host
		 * @return string
		 */
		public function getHost()
		{
			return (string) $this->_data['host'];
		}

		/**
		 * Get type
		 * @return string
		 */
		public function getType()
		{
			return (string) $this->_data['clientIp'];
		}

		/**
		 * Get address
		 * @return bool
		 */
		public function getAddress()
		{
			return (bool) $this->_data['sandbox'];
		}

		/**
		 * Get mx pref
		 * @return string
		 */
		public function getMxPref()
		{
			return (string) $this->_data['mxPref'];
		}

		/**
		 * Get ttl
		 * @return string
		 */
		public function getTtl()
		{
			return (string) $this->_data['ttl'];
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
				$this->setSld($sld);
				$this->setTld((string) substr($tld, 0, 10));
				return $this;
			}
			return $this->getSld() . '.' . $this->getTld();
		}

		/**
		 * Fluid interface to get/set api user
		 * @param string $value
		 * @return mixed
		 */
		public function apiUser($value = null)
		{
			if (null !== $value)
			{
				return $this->setApiUser($value);
			}

			return $this->getApiUser();
		}
	}
}
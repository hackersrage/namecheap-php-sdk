<?php

namespace Namecheap\Api
{
	class Exception extends \Exception {}
}

namespace Namecheap
{
	include_once 'Config.php';
	include_once 'Command/ICommand.php';
	include_once 'Command/ACommand.php';
	include_once 'Command/Domains/GetList.php';

	class Api
	{
		/**
		 * Array of possible commands and associated class names
		 * @var array
		 */
		protected static $_commands = array(
			'domains.getList'		=> 'Namecheap\Command\Domains\GetList',
			'domains.getContacts'	=> 'Namecheap\Command\Domains\GetContacts',
			'domains.create'		=> 'Namecheap\Command\Domains\Create',
		);

		/**
		 * @return Namecheap\Command\ACommand
		 * @throws Api\Exception
		 */
		public static function factory($config, $command)
		{
			if (!array_key_exists($command, static::$_commands))
			{
				throw new Api\Exception($command . ' is not a valid API');
			}

			$instance = new static::$_commands[$command]();
			return $instance->config($config);
		}
	}
}
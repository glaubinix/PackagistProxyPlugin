<?php

namespace Hermes\Composer\PackagistProxy;

use Composer\IO\IOInterface;
use Composer\Util\RemoteFilesystem;

class ProxyRemoteFilesystem extends RemoteFilesystem
{

	/**
	 * @var ProxyClient
	 */
	protected $client;

	public function __construct(IOInterface $io, array $options, ProxyClient $client)
	{
		parent::__construct($io, $options);
		$this->client = $client;
	}

	public function copy($originUrl, $fileUrl, $fileName, $progress = true, $options = array())
	{
		$this->client->download($fileUrl, $fileName, $progress);
	}
}

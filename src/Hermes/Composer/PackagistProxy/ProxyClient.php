<?php

namespace Hermes\Composer\PackagistProxy;

use Composer\Config;
use Composer\Downloader\TransportException;
use Composer\IO\IOInterface;
use Guzzle\Http\Client;
use Guzzle\Http\EntityBody;

class ProxyClient {

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var IOInterface
	 */
	protected $io;

	/**
	 * @param IOInterface $io
	 * @param Config $config
	 */
	public function __construct(IOInterface $io, Config $config)
	{
		$this->io       = $io;
		$this->config   = $config;
	}

	/**
	 * @param string $url URL of the original archive.
	 * @param string $to Location on disk.
	 * @param boolean $progress
	 * @throws TransportException
	 */
	public function download($url, $to, $progress)
	{
		echo $url . " - " . $to . " - " . $progress . "\n";
		if ($progress) {
			$this->io->write("    Downloading: <comment>connection...</comment>", false);
		}

		try {
			if (!$this->config->has('packagist-proxy-url')) {
				$errorMessage = sprintf('Proxy config param not set: define "%s"', 'packagist-proxy-url');
				throw new \Exception($errorMessage);
			}

			$client = new Client($url);
			$request = $client->get('/');
			$response_body = EntityBody::factory(fopen($to, 'w+'));
			$request->setResponseBody($response_body);
			$request->send();

			if ($progress) {
				$this->io->overwrite("    Downloading: <comment>100%</comment>");
			}

			if (false === file_exists($to) || !filesize($to)) {
				$errorMessage = sprintf(
					"Unknown error occurred: '%s' was not downloaded from '%s'.",
					$url
				);

				throw new TransportException($errorMessage);
			}
		} catch (TransportException $e) {
			throw $e; // just re-throw
		} catch (\Exception $e) {
			throw new TransportException("Problem?", null, $e);
		}
	}
}

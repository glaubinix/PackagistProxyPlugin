<?php

namespace Hermes\Composer\PackagistProxy;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PreFileDownloadEvent;

class ProxyPlugin implements PluginInterface, EventSubscriberInterface
{

	/**
	 * @var Composer
	 */
	protected $composer;

	/**
	 * @var IOInterface
	 */
	protected $io;

	/**
	 * @param Composer $composer
	 * @param IOInterface $io
	 */
	public function activate(Composer $composer, IOInterface $io)
	{
		$this->composer = $composer;
		$this->io = $io;
	}

	public static function getSubscribedEvents()
	{
		return array(
			PluginEvents::PRE_FILE_DOWNLOAD => array(
				array('onPreFileDownload', 0)
			),
		);
	}

	public function onPreFileDownload(PreFileDownloadEvent $event)
	{
		print_r($event);
		$client = new ProxyClient($this->io, $this->composer->getConfig());
		$event->setRemoteFilesystem(new ProxyRemoteFilesystem($this->io, $event->getRemoteFilesystem()->getOptions(), $client));
	}

}

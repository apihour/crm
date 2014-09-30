<?php

namespace Tutto\CommonBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class FlashBagExtension
 * @package Tutto\CommonBundle\Twig
 */
class FlashBagExtension extends Twig_Extension implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null) {
        $this->setContainer($container);
    }

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            new Twig_SimpleFunction('flash_bag', [$this, 'flashBag'])
        ];
    }

    /**
     * @return $this
     */
    public function flashBag() {
        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name) {
        if ($this->has($name)) {
            return $this->getFlashBag()->get($name);
        }

        return null;
    }

    /**
     * @param string $type
     * @param string $message
     * @return void
     */
    public function add($type, $message) {
        if ($this->container !== null) {
            $this->getFlashBag()->add($type, $message);
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name) {
        if ($this->container === null) {
            return false;
        }

        return $this->getFlashBag()->has($name);
    }

    /**
     * @return FlashBagInterface
     */
    protected function getFlashBag() {
        return $this->container->get('session')->getFlashBag();
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'tutto_common_errors_extension';
    }
}
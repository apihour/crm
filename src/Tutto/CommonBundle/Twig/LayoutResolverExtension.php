<?php

namespace Tutto\CommonBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\Request;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class LayoutResolverExtension
 * @package Tutto\CommonBundle\Twig
 */
class LayoutResolverExtension extends Twig_Extension implements ContainerAwareInterface {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $baseLayoutName = '::layout.html.twig';

    /**
     * @var string
     */
    protected $ajaxLayoutName = '::ajax:html.twig';

    /**
     * @var string
     */
    protected $emptyLayoutName = '::empty.html.twig';

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
            new Twig_SimpleFunction('layoutResolver', [$this, 'layoutResolver'])
        ];
    }

    /**
     * @return $this
     */
    public function layoutResolver() {
        return $this;
    }

    /**
     * @param null $defaultLayout
     * @return string
     */
    public function resolve($defaultLayout = null) {
        if ($this->container === null) {
            return $this->getBaseLayoutName();
        }

        /** @var Request $request */
        $request = $this->container->get('request');

        // Check if is ajax request
        if ($request->isXmlHttpRequest()) {
            if ($request->get('_format') === 'ajax') {
                return $this->getAjaxLayoutName();
            }
        } else {
            if ((boolean) $request->get('_partial') === true) {
                return $this->getEmptyLayoutName();
            } else {
                if ($defaultLayout === null) {
                    return $this->getBaseLayoutName();
                } else {
                    return $defaultLayout;
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getBaseLayoutName() {
        return $this->baseLayoutName;
    }

    /**
     * @param string $baseLayoutName
     */
    public function setBaseLayoutName($baseLayoutName) {
        $this->baseLayoutName = $baseLayoutName;
    }

    /**
     * @return string
     */
    public function getAjaxLayoutName() {
        return $this->ajaxLayoutName;
    }

    /**
     * @param string $ajaxLayoutName
     */
    public function setAjaxLayoutName($ajaxLayoutName) {
        $this->ajaxLayoutName = $ajaxLayoutName;
    }

    /**
     * @return string
     */
    public function getEmptyLayoutName() {
        return $this->emptyLayoutName;
    }

    /**
     * @param string $emptyLayoutName
     */
    public function setEmptyLayoutName($emptyLayoutName) {
        $this->emptyLayoutName = $emptyLayoutName;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'tutto_common_layout_resolver';
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
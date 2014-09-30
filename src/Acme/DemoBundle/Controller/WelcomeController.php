<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tutto\SecurityBundle\Configuration\Authorization;

/**
 * Class WelcomeController
 * @package Acme\DemoBundle\Controller
 * @Authorization(omit=true)
 */
class WelcomeController extends Controller
{
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        return $this->render('AcmeDemoBundle:Welcome:index.html.twig');
    }
}

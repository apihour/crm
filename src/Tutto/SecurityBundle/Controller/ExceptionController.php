<?php

namespace Tutto\SecurityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Tutto\CommonBundle\Controller\AbstractController;

class ExceptionController extends BaseExceptionController {
    public function __construct() {

    }

    /**
     * @param Request $request
     * @param FlattenException $exception
     * @param DebugLoggerInterface $logger
     * @param string $_format
     * @return array
     * @Template()
     */
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null, $_format = 'html') {
        parent::showAction($request, $exception, $logger, $_format);
        return new Response();
    }
} 
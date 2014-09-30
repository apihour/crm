<?php

namespace Apihour\FrontendBundle\Controller;

use Apihour\UserBundle\Entity\User;
use Tutto\CommonBundle\Controller\AbstractController;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tutto\SecurityBundle\Configuration\Authorization;
use Tutto\CommonBundle\Configuration\PageData;
use Apihour\UserBundle\Entity\Role;

/**
 * Class DashboardController
 * @package Apihour\FrontendBundle\Controller
 *
 * @Authorization({Role::MEMBER})
 */
class DashboardController extends AbstractController {
    /**
     * @Route("/", name="apihour_frontend_dashboard_index")
     * @PageData(title="dashboard", subtitle="dasboad subtitle")
     * @Template()
     */
    public function indexAction() {
        /** @var User $user */
        $user = $this->getUser();
        return ['user' => $user];
    }
} 
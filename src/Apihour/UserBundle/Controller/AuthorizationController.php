<?php

namespace Apihour\UserBundle\Controller;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;

use Tutto\CommonBundle\Controller\AbstractController;
use Apihour\UserBundle\Form\Type\ForgotPasswordType;
use Apihour\UserBundle\Form\Type\LoginType;
use Apihour\UserBundle\Entity\User;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Tutto\SecurityBundle\Configuration\Authorization;
use Apihour\UserBundle\Entity\Role;

/**
 * Class AuthorizationController
 * @package Apihour\UserBundle\Controller
 *
 * @Authorization(omit=true)
 */
class AuthorizationController extends AbstractController {
    /**
     * @Route("/login", name="_login")
     * @Template()
     */
    public function loginAction(Request $request) {
        if ($this->isLogged()) {
            return $this->redirect('/');
        }

        $form    = $this->createForm(new LoginType($this->container));
        $session = $this->container->get('session');

        if($session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $session->getFlashBag()->add(
                AbstractController::FLASH_BAG_ERROR,
                $session->get(SecurityContextInterface::AUTHENTICATION_ERROR)->getMessage()
            );
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/user/forgot-password", name="_forgot_password")
     * @Template()
     */
    public function forgotAction(Request $request) {
        $form = $this->createForm(new ForgotPasswordType());

        if ($request->isMethod('POST')) {
            if ($form->submit($request)->isValid()) {

            } else {

            }
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/login_check", name="_login_check")
     */
    public function checkAction() { /** Nothing to do. */}

    /**
     * @Route("/logout", name="_logout")
     */
    public function logoutAction() { /** Nothing to do */ }
} 
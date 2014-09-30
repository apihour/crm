<?php

namespace Tutto\SecurityBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\SecurityBundle\Entity\Account;
use Tutto\SecurityBundle\Entity\Role;
use Tutto\SecurityBundle\Entity\User;
use Tutto\SecurityBundle\Form\Type\RegistrationType;
use Tutto\SecurityBundle\Repository\RoleRepository;
use Tutto\SecurityBundle\Repository\UserRepository;

use DateTime;
use Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tutto\SecurityBundle\Configuration\Authorization;

/**
 * Class RegistrationController
 * @package Tutto\SecurityBundle\Controller
 *
 * @Route("/user")
 * @Authorization(omit=true)
 */
class RegistrationController extends AbstractController {
    /**
     * @Route("/registration", name="_registration")
     * @Template()
     *
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function registerAction(Request $request) {
        if ($this->isLogged()) {
            /** todo Zastanowić się co zrobić z zalogowanym użytkownikiem */
        }

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager    = $this->container->get('fos_user.user_manager');
        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(Role::class);

        /** @var User $user */
        $user = $userManager->createUser();
        $form = $this->createForm(new RegistrationType(), $user);

        if($request->isMethod('post')) {
            if($form->submit($request)->isValid()) {
                if($userManager->findUserByEmail($user->getEmail())) {
                    $this->addFlashError('security:user.email_exists', ['%email%' => $user->getEmail()]);
                } else {
                    $this->getEm()->beginTransaction();
                    try {
                        $user->setAccount(new Account());
                        $user->setEnabled(false);
                        $user->setRoles([$roleRepository->getByName(Role::MEMBER)]);

                        if ($user instanceof User) {
                            $expiresAt = new DateTime();
                            $expiresAt->add(new \DateInterval('P7D'));
                            $user->setExpiresAt($expiresAt);
                        }

                        $user->setConfirmationToken($this->generateToken());
                        $userManager->updateUser($user);

//                        $this->getEm()->commit();
//                        return $this->redirect(
//                            $this->generateUrl(
//                                '_confirmRegistration',
//                                [
//                                    'id'    => $user->getId(),
//                                    'email' => $user->getEmail()
//                                ]
//                            )
//                        );
                    } catch(Exception $ex) {
                        $this->addFlashError($ex->getMessage());
                        $this->getEm()->rollback();
                    }
                }
            } else {
                $this->addFlashError('flash_bag.forms.formNotValid');
            }
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/confirm/{id}-{email}",
     *      name="_confirmRegistration",
     *      requirements={
     *          "id"="\d+",
     *          "email"="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"
     *      }
     * )
     * @Template()
     * @Method({"GET"})
     */
    public function confirmAction($id, $email) {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getRepository(User::class);
        $user = $userRepository->findOneBy([
            'id'    => $id,
            'email' => $email
        ]);

        if($user instanceof User) {
            $this->addFlashSuccess('security.user.userCreated');
            $this->sendEmail(
                $user->getEmail(),
                'security.email.user_created',
                'TuttoSecurityBundle:emails:user-created.html.twig',
                [
                    'user' => $user
                ]
            );
        } else {
            $this->addFlashError('security.user.userNotCreated');
        }

        return ['user' => $user];
    }

    /**
     * @Route("/activate/{id}-{email}/{token}",
     *      name="_user_activate",
     *      requirements={
                "id"="\d+",
     *          "email"="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"
     *      }
     * )
     * @Template()
     * @Method({"GET"})
     */
    public function activateAction($id, $email, $token) {
        /** @var UserRepository $repository */
        $repository = $this->getRepository(User::class);

        $user    = $repository->findOneBy([
            'id'    => (int) $id,
            'email' => addslashes($email),
            'confirmationToken' => addslashes($token)
        ]);

        if($user instanceof User) {
            if($user->isEnabled()) {
                $this->addFlashAlert('security.user.enabledAlready');
            } else {
                $user->setEnabled(true);
                $user->setConfirmationToken(null);
                $this->getEm()->persist($user);
                $this->getEm()->flush();

                $this->addFlashSuccess('security.user.enabled');
                $this->sendEmail(
                    $user->getEmail(),
                    'security.email.user',
                    'TuttoSecurityBundle::/emails/user-enabled.html.twig',
                    [
                        'user' => $user
                    ]
                );
            }
        } else {
            $this->addFlashError('security.user.notFound');
            return $this->redirect($this->generateUrl('_registration'));
        }

        return ['user' => $user];
    }

    /**
     * @return string
     */
    protected function generateToken() {
        return md5(time());
    }
} 
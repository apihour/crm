<?php

namespace Tutto\CommonBundle\Controller;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Tutto\CommonBundle\DependencyInjection\ContainerAwareInterface;

use LogicException;
use Exception;
use Swift_Message;
use Tutto\CommonBundle\Entity\AbstractEntity;
use Tutto\CommonBundle\Repository\AbstractEntityRepository;
use Tutto\SecurityBundle\Entity\User;

/**
 * Class AbstractController
 * @package Tutto\CommonBundle\Controller
 */
class AbstractController extends Controller implements ContainerAwareInterface {
    const FLASH_BAG_SUCCESS = 'success';
    const FLASH_BAG_ALERT   = 'alert';
    const FLASH_BAG_ERROR   = 'error';
    const FLASH_BAG_INFO    = 'info';
    const MESSAGE_SUCCESS   = 'flash_bag.message.success';
    const MESSAGE_ALERT     = 'flash_bag.message.alert';
    const MESSAGE_ERROR     = 'flash_bag.message.error';

    /**
     * @param string $message
     * @param array $parameters
     * @return $this
     */
    protected function addFlashSuccess($message = self::MESSAGE_SUCCESS, $parameters = []) {
        $this->addFlashMessage(self::FLASH_BAG_SUCCESS, $message, $parameters);
        return $this;
    }

    /**
     * @param string $message
     * @param array $parameters
     * @return $this
     */
    protected function addFlashError($message = self::MESSAGE_ERROR, $parameters = []) {
        $this->addFlashMessage(self::FLASH_BAG_ERROR, $message, $parameters);
        return $this;
    }

    /**
     * @param string $message
     * @param array $parameters
     * @return $this
     */
    protected function addFlashAlert($message = self::MESSAGE_ALERT, $parameters = []) {
        $this->addFlashMessage(self::FLASH_BAG_ALERT, $message, $parameters);
        return $this;
    }

    /**
     * @param $message
     * @param array $parameters
     * @return $this
     */
    protected function addFlashInfo($message, $parameters = []) {
        $this->addFlashMessage(self::FLASH_BAG_INFO, $message, $parameters);
        return $this;
    }

    /**
     * @param $type
     * @param $message
     * @param array $parameters
     * @return $this
     */
    protected function addFlashMessage($type, $message, $parameters = []) {
        $this->get('session')->getFlashBag()->add($type, $this->trans($message, $parameters));
        return $this;
    }

    /**
     * @param Form $form
     */
    protected function addFormFlashError(Form $form) {
        $this->addFlashError();
        foreach($form->getErrors() as $error) {
            $this->addFlashError($error->getMessage());
        }
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->get('request');
    }

    /**
     * @param array $data
     * @return array|JsonResponse
     */
    protected function getResponse(array $data = []) {
        if($this->getRequest()->isXmlHttpRequest() && $this->getRequest()->get('_format') === 'json') {
            return new JsonResponse($data);
        }

        return $data;
    }

    /**
     * @return null|SessionInterface
     */
    public function getSession() {
        return $this->getRequest()->getSession();
    }

    /**
     * @param $class
     * @return EntityRepository
     */
    public function getRepository($class) {
        $repository = $this->getContainer()->get('doctrine')->getRepository($class);
        if($repository instanceof ContainerAwareInterface) {
            $repository->setContainer($this->getContainer());
        }

        return $repository;
    }

    /**
     * @return Router
     */
    public function getRouter() {
        return $this->get('router');
    }

    /**
     * @param null $name
     * @return EntityManager
     */
    public function getEm($name = null) {
        return $this->getDoctrine()->getManager($name);
    }

    /**
     * @param $id
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function trans($id, array $parameters = [], $domain = null, $locale = null) {
        return $this->get('translator')->trans($id, $parameters, $domain, $locale);
    }

    /**
     * @return bool
     */
    public function isPost() {
        return $this->getRequest()->isMethod('POST');
    }

    /**
     * @return bool
     */
    public function isGet() {
        return $this->getRequest()->isMethod('GET');
    }

    /**
     * @param $email
     * @param $subject
     * @param $template
     * @param array $vars
     * @return int
     */
    protected function sendEmail($email, $subject, $template, array $vars = []) {
        $message = Swift_Message::newInstance()
            ->setSubject($this->trans($subject))
            ->setCharset('utf8')
            ->setTo($email)
            ->setContentType('text/html')
            ->setBody(
                $this->renderView(
                    $template,
                    $vars
                )
            );

        return $this->get('mailer')->send($message);
    }

    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $type
     * @param null $data
     * @param array $options
     * @return Form
     */
    public function createForm($type, $data = null, array $options = []) {
        if($type instanceof ContainerAwareInterface) {
            $type->setContainer($this->getContainer());
        }

        return parent::createForm($type, $data, $options);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer() {
        if($this->container === null) {
            throw new LogicException("ContainerInterface was never deployed");
        }

        return $this->container;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser() {
        /** @var TokenInterface $token */
        $token = $this->container->get('security.context')->getToken();

        if($token !== null) {
            $user = $token->getUser();
            return $user instanceof UserInterface ? $user : null;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isLogged() {
        return $this->getUser() instanceof UserInterface;
    }

    /**
     * @param Form|AbstractType $form
     * @param null|object $entity
     * @param Request $request
     * @param array $options
     * @return array|RedirectResponse
     * @throws Exception
     * @throws MappingException
     */
    protected function processForm($form, $entity = null, Request $request = null, array $options = []) {
        if ($form instanceof AbstractType) {
            $type = $form;
            $form = $this->createForm($type, $entity);
        } elseif (!$form instanceof Form) {
            throw new LogicException("Variable 'form' is not instance of Form or AbstractType.");
        }

        $request = $request !== null ? $request : $this->getRequest();

        if ($request->isMethod('post')) {
            if ($form->handleRequest($request)->isValid()) {
                $this->getEm()->beginTransaction();
                try {
                    if ($entity === null) {
                        $entity = $form->getData();
                    }

                    $repository = $this->getRepository(get_class($entity));
                    if ($repository instanceof AbstractEntityRepository) {
                        $repository->update($entity);
                    } else {
                        $this->getEm()->persist($entity);
                        $this->getEm()->flush();
                    }

                    $this->getEm()->commit();
                    $this->addFlashSuccess();

                    if (isset($options['redirect'])) {
                        $options['redirectParams'] = [];
                        $params = array_merge([], $options['redirectParams']);
                        return $this->redirect($this->generateUrl($options['redirect'], $params));
                    }
                } catch (MappingException $ex) {
                    throw $ex;
                } catch (RouteNotFoundException $ex) {
                    throw $ex;
                } catch (Exception $ex) {
                    $this->getEm()->rollback();
                    $this->addFlashError();
                }
            } else {
                $this->addFlashError();
            }
        }

        return [
            'form'    => $form->createView(),
            'entity'  => $entity,
            'request' => $request
        ];
    }
}
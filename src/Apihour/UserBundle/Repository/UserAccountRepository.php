<?php

namespace Apihour\UserBundle\Repository;

use Apihour\FileBundle\Entity\File;
use Apihour\UserBundle\Entity\User\UserAccount;
use Gaufrette\Exception\FileNotFound;
use Gregwar\ImageBundle\ImageHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Tutto\CommonBundle\Repository\AbstractEntityRepository;
use DateTime;

/**
 * Class UserAccountRepository
 * @package Apihour\UserBundle\Repository
 */
class UserAccountRepository extends AbstractEntityRepository {
    /**
     * @var string
     */
    protected $avatarBasePath;

    /**
     * @param UserAccount $userAccount
     */
    public function update(UserAccount $userAccount) {
        if (($avatar = $userAccount->getPerson()->getAvatar()) !== null && $avatar->getFile() !== null) {
            if ($avatar->getCreatedBy() === null) {
                $avatar->setCreatedBy($this->getUser());
            }

            $avatarFileManager = $this->container->get('apihour.avatar_file_manager');

            try {
                $avatarFileManager->delete($avatar);
            } catch (FileNotFound $ex) { }

            $avatar->setBasePath($this->parsePath($userAccount, $this->getAvatarBasePath()));
            $avatar->setFilename(uniqid('avatar_'));
            $avatar->setExt($avatar->getFile()->getClientOriginalExtension());
            $avatar->setModifiedBy($this->getUser());
            $avatar->setModifiedAt(new DateTime());

            $avatarFileManager->upload($avatar);
        }

        $this->getEm()->persist($userAccount);
        $this->getEm()->flush();
    }

    /**
     * @return string
     */
    public function getAvatarBasePath() {
        return $this->avatarBasePath;
    }

    /**
     * @param string $avatarBasePath
     */
    public function setAvatarBasePath($avatarBasePath) {
        $this->avatarBasePath = (string) $avatarBasePath;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);

        if ($container !== null) {
            $config = $container->getParameter('apihour_user');
            $this->setAvatarBasePath($config['avatar_base_path']);
        }
    }

    /**
     * @param mixed $object
     * @param string $path
     * @return mixed|null|string
     */
    protected function parsePath($object, $path) {
        preg_match_all('/\{(.*)\}/i', $path, $matches);

        if (!empty($matches[1])) {
            $newPath = '/';
            foreach ($matches[1] as $key => $property) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $value    = $accessor->getValue($object, $property);
                $newPath  = preg_replace('/\{('.$property.')\}/i', $value, $path);
            }

            return $newPath;
        }

        return null;
    }
} 
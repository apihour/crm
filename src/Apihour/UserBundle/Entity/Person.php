<?php

namespace Apihour\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

use Apihour\FileBundle\Entity\File;
use DateTime;
use JsonSerializable;

/**
 * Class Person
 * @package Tutto\UserBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="person")
 */
class Person implements JsonSerializable {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Regex(
     *      pattern="/^[A-Za-z]{2}[A-Za-z`\']{0,}$/D",
     *      message="validator:notValid.firstname"
     * )
     *
     * @var string
     */
    protected $firstname = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Regex(
     *      pattern="/^[A-Za-z]{2}[A-Za-z`\']{0,}$/D",
     *      message="validator:notValid.middlename"
     * )
     *
     * @var string
     */
    protected $middlename = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     * @Assert\Regex(
     *      pattern="/^[A-Za-z]{2}[A-Za-z`\']{0,}$/D",
     *      message="validator:notValid.lastname"
     * )
     *
     * @var string
     */
    protected $lastname = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string|null
     */
    protected $www = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @var string
     */
    protected $birthday = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $birthdayPlace = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $taxNumber = null;

    /**
     * @ORM\Column(type="array")
     *
     * @var array
     */
    protected $phones = array();

    /**
     * @ORM\Column(type="array")
     *
     * @var string
     */
    protected $emails = array();

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $bankAccountNumber = null;

    /**
     * @ORM\Column(length=255, nullable=true)
     *
     * @var string
     */
    protected $bankAccountName = null;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $sameAddress = false;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinColumn(name="correspondence_address_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Address
     */
    protected $correspondenceAddress = null;

    /**
     * @ORM\OneToOne(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinColumn(name="home_address_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     * @var Address
     */
    protected $homeAddress = null;

    /**
     * @ORM\ManyToOne(targetEntity="Apihour\FileBundle\Entity\File", cascade={"all"})
     * @ORM\JoinColumn(name="avatar", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     *
     * @var File
     */
    protected $avatar = null;

    public function __construct() {
        $this->setCorrespondenceAddress(new Address());
        $this->setHomeAddress(new Address());
        $this->birthday = new DateTime();
    }

    /**
     * @return File
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * @param File $avatar
     */
    public function setAvatar(File $avatar) {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getBankAccountName() {
        return $this->bankAccountName;
    }

    /**
     * @param string $bankAccountName
     */
    public function setBankAccountName($bankAccountName) {
        $this->bankAccountName = $bankAccountName;
    }

    /**
     * @return string
     */
    public function getBankAccountNumber() {
        return $this->bankAccountNumber;
    }

    /**
     * @param string $bankAccountNumber
     */
    public function setBankAccountNumber($bankAccountNumber) {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    /**
     * @return string
     */
    public function getBirthday() {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     */
    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getBirthdayPlace() {
        return $this->birthdayPlace;
    }

    /**
     * @param string $birthdayPlace
     */
    public function setBirthdayPlace($birthdayPlace) {
        $this->birthdayPlace = $birthdayPlace;
    }

    /**
     * @return Address
     */
    public function getCorrespondenceAddress() {
        return $this->correspondenceAddress;
    }

    /**
     * @param Address $correspondenceAddress
     */
    public function setCorrespondenceAddress($correspondenceAddress) {
        $this->correspondenceAddress = $correspondenceAddress;
    }

    /**
     * @return string
     */
    public function getEmails() {
        return $this->emails;
    }

    /**
     * @param string $emails
     */
    public function setEmails($emails) {
        $this->emails = $emails;
    }

    /**
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    /**
     * @return Address
     */
    public function getHomeAddress() {
        return $this->homeAddress;
    }

    /**
     * @param Address $homeAddress
     */
    public function setHomeAddress($homeAddress) {
        $this->homeAddress = $homeAddress;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getMiddlename() {
        return $this->middlename;
    }

    /**
     * @param string $middlename
     */
    public function setMiddlename($middlename) {
        $this->middlename = $middlename;
    }

    /**
     * @return array
     */
    public function getPhones() {
        return $this->phones;
    }

    /**
     * @param array $phones
     */
    public function setPhones($phones) {
        $this->phones = $phones;
    }

    /**
     * @return boolean
     */
    public function isSameAddress() {
        return $this->sameAddress;
    }

    /**
     * @param boolean $sameAddress
     */
    public function setSameAddress($sameAddress) {
        $this->sameAddress = $sameAddress;
    }

    /**
     * @return string
     */
    public function getTaxNumber() {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     */
    public function setTaxNumber($taxNumber) {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return null|string
     */
    public function getWww() {
        return $this->www;
    }

    /**
     * @param null|string $www
     */
    public function setWww($www) {
        $this->www = $www;
    }


    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize() {
        return [
            'id'            => $this->getId(),
            'firstname'     => $this->getFirstname(),
            'middlename'    => $this->getMiddlename(),
            'lastname'      => $this->getLastname(),
            'birthday'      => $this->getBirthday(),
            'birthdayPlace' => $this->getBirthdayPlace(),
            'taxNumber'     => $this->getTaxNumber(),
        ];
    }
}
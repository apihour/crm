<?php

namespace Apihour\InvoiceBundle\Controller;

use Apihour\InvoiceBundle\Entity\Invoice\InvoiceBuyer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Validator\Constraints\LanguageValidator;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Tutto\SecurityBundle\Configuration\Authorization;
use Apihour\UserBundle\Entity\Role;

/**
 * Class InvoiceController
 * @package Apihour\InvoiceBundle\Controller
 *
 * @Authorization(roles={Role::CONTRACTOR, Role::ADMIN})
 */
class InvoiceController extends AbstractDataGridController {
    /**
     * @Route("/invoices/{page}/{limit}",
     *      name="apihour_invoices_list",
     *      requirements={"page"="\d+", "limit"="\d+"},
     *      defaults={"page"=1, "limit"=30}
     * )
     * @Template()
     */
    public function listAction() {
        
    }
} 
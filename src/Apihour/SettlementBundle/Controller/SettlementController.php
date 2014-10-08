<?php

namespace Apihour\SettlementBundle\Controller;

use Apihour\SettlementBundle\Entity\AbstractSettlement;
use Apihour\SettlementBundle\Form\Type\AbstractSettlementType;
use Apihour\SettlementBundle\Form\Type\BillType;
use Apihour\SettlementBundle\Form\Type\InvoiceType;
use Symfony\Component\HttpFoundation\Request;
use Tutto\DataGridBundle\Controller\AbstractDataGridController;
use LogicException;
use Exception;

/**
 * Annotation
 */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tutto\SecurityBundle\Configuration\Authorization;
use Apihour\UserBundle\Entity\Role;
use Tutto\CommonBundle\Configuration\PageData;
use Tutto\CommonBundle\Configuration\Metadata;

/**
 * Class SettlementController
 * @package Apihour\SettlementBundle\Controller
 *
 * @Authorization(roles={Role::CONTRACTOR_OWNER, Role::CONTRACTOR_TRADER, Role::CONTRACTOR_MANAGER})
 */
class SettlementController extends AbstractDataGridController {
    /**
     * @Route("/settlements/incomes/{page}/{limit}",
     *      name="apihour_settlements_incomes",
     *      requirements={"page"="\d+", "limit"="\d+"},
     *      defaults={"page"=1, "limit"=30}
     * )
     * @Route("/settlements/expense/{page}/{limit}",
     *      name="apihour_settlements_expenses",
     *      requirements={"page"="\d+", "limit"="\d+"},
     *      defaults={"page"=1, "limit"=30}
     * )
     *
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function listAction(Request $request) {
        return ['incomes' => []];
    }

    /**
     * @Route("/settlements/income/create/invoice", name="apihour_settlements_income_create_invoice", defaults={"format"="invoice"})
     * @Route("/settlements/income/create/bill", name="apihour_settlements_income_create_bill", defaults={"format"="bill"})
     * @Route("/settlements/income/create/proforma", name="apihour_settlements_income_create_proforma", defaults={"format"="proforma"})
     *
     * @Template("@ApihourSettlement/Settlement/create.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function createIncomeAction(Request $request) {
        $request->query->add(['type' => 'income']);
        return $this->createAction($request);
    }

    /**
     * @Route("/settlements/expense/create/invoice", name="apihour_settlements_expense_create_invoice", defaults={"format"="invoice"})
     * @Route("/settlements/expense/create/bill", name="apihour_settlements_expense_create_bill", defaults={"format"="bill"})
     * @Route("/settlements/expense/create/proforma", name="apihour_settlements_expense_create_proforma", defaults={"format"="proforma"})
     *
     * @Template("@ApihourSettlement/Settlement/create.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function createExpenseAction(Request $request) {
        $request->query->add(['type' => 'expense']);
        return $this->createAction($request);
    }

    /**
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request) {
        $formType   = $this->createFormOnFormat($request->get('format'));
        $dataClass  = $formType->getDataClass();

        if ($request->get('type') === 'income') {
            $type = AbstractSettlement::TYPE_INCOME;
        } elseif ($request->get('type') === 'expense') {
            $type = AbstractSettlement::TYPE_EXPENSE;
        } else {
            throw new LogicException("Type of settlements not recognize (only: income or expense).");
        }



        return $this->processForm($formType, new $dataClass($type), $request);
    }

    /**
     * @param string $type
     * @return AbstractSettlementType
     */
    protected function createFormOnFormat($type) {
        switch ((string) $type) {
            case 'invoice' : return new InvoiceType(); break;
            case 'bill'    : return new BillType();    break;
            default        : throw new LogicException("Type: '{$type}' not recognise");
        }
    }
} 
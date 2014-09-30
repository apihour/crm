<?php

namespace Tutto\DataGridBundle\Controller;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Tutto\CommonBundle\Controller\AbstractController;
use Tutto\CommonBundle\DependencyInjection\ContainerAwareInterface;
use Tutto\CommonBundle\PropertyAccess\PropertyAccessor;
use Tutto\DataGridBundle\DataGrid\DataGrid;
use Tutto\DataGridBundle\DataGrid\DataProvider\DataProviderInterface;
use Tutto\DataGridBundle\DataGrid\FiltersType\AbstractFiltersType;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\Event;
use Tutto\DataGridBundle\DataGrid\Grid\Column\Event\PostAccessEventInterface;
use Tutto\DataGridBundle\DataGrid\Grid\GridBuilder;
use Tutto\DataGridBundle\DataGrid\Grid\GridInterface;
use Tutto\DataGridBundle\DataGrid\Grid\Row;
use Tutto\DataGridBundle\DataGrid\Helper\FiltersType;
use Tutto\DataGridBundle\DataGrid\Helper\GenerateRoute;
use Tutto\DataGridBundle\DataGrid\Helper\Helper;
use Tutto\DataGridBundle\DataGrid\Helper\Paginator;
use Tutto\DataGridBundle\DataGrid\Helper\Results;
use Closure;
use Exception;

/**
 * Class AbstractDataGridController
 * @package Tutto\DataGridBundle\Controller
 */
abstract class AbstractDataGridController extends AbstractController {
    /**
     * @param GridInterface $grid
     * @param DataProviderInterface $dataProvider
     * @param AbstractFiltersType $filtersType
     * @return Response
     */
    protected function getDataGridResponse(GridInterface $grid, DataProviderInterface $dataProvider, AbstractFiltersType $filtersType, $template = false) {
        $request     = $this->getRequest();

        $gridBuilder = new GridBuilder();
        $gridBuilder->setContainer($this->container);
        $grid->appendSettings($gridBuilder);

        $dataProvider->setLimit($request->get('limit', 1));
        $dataProvider->setOffset($request->get('offset', 0));
        if ($dataProvider instanceof ContainerAwareInterface) {
            $dataProvider->setContainer($this->container);
        }

        $form = $this->createForm($filtersType);
        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {
                $dataProvider->setData($form->getData());
            }
        }

        /** @var Row[] $rows */
        $rows = [];
        foreach ($dataProvider->getResults() as $result) {
            $row = new Row();
            foreach ($gridBuilder->getColumns() as $column) {
                $propertyPath = $column->getPropertyPath();
                if ($propertyPath === false) {
                    $value = $column->getStaticValue();
                } else {
                    $accessor = new PropertyAccessor();
                    $value    = $accessor->getValue($result, $propertyPath);
                }

                $event = new Event($result, $value, $column);

                foreach ($column->getPostAccessEvents() as $listener) {
                    if ($listener instanceof Closure) {
                        $listener($event);
                    } elseif ($listener instanceof PostAccessEventInterface) {
                        $listener->postAccess($event);
                    }
                }

                $row->addEvent($event);
            }
            $rows[] = $row;
        }

        $datagrid = new DataGrid();
        $datagrid->addHelper(new Helper('generateRoute', [new GenerateRoute($this->container), 'generateRoute']));
        $datagrid->addHelper(new Helper('paginator', [new Paginator($dataProvider, $request), 'paginator']));
        $datagrid->addHelper(new Helper('results', [new Results($rows), 'results']));
        $datagrid->addHelper(new Helper('columns', [$gridBuilder, 'getColumns']));
        $datagrid->addHelper(new Helper('attribs', [$gridBuilder, 'getAttributes']));
        $datagrid->addHelper(new Helper('filters', [new FiltersType($form->createView()), 'getFiltersType']));

        if ($template === false) {
            return new Response($this->renderView(
                $this->container->getParameter('tutto_data_grid')['template'],
                ['grid' => $datagrid]
            ));
        } else {
            return new Response($this->renderView(
                $template,
                ['grid' => $datagrid]
            ));
        }
    }

    /**
     * @param FormBuilderInterface $formBuilder
     * @param $object
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function updateData(FormBuilderInterface $formBuilder, $object, Request $request) {
        $data = [$request->get('name') => $request->get('value')];
        $form = $formBuilder->getForm();

        if ($request->isMethod('post')) {
            if ($form->submit($data)->isValid()) {
                try {
                    $this->getEm()->persist($object);
                    $this->getEm()->flush($object);

                    return new JsonResponse(['success' => true, 'message' => $this->trans('xeditable.success.message')]);
                } catch (Exception $ex) {
                    return new JsonResponse(['success' => false, 'message' => $this->trans('xeditable.could_not_update_data')]);
                }
            } else {
                try {
                    $errors = $form->get($request->get('name'))->getErrors();
                } catch (Exception $ex) {
                    $errors = $form->getErrors();
                }

                $message = '';
                foreach ($errors as $error) {
                    $message = $error->getMessage();
                }

                return new JsonResponse([
                    'success' => false,
                    'message' => $message
                ], 300);
            }
        }

        return new Response($this->trans('xeditable.only_post_data'), 300);
    }
}

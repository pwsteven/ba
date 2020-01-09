<?php

namespace App\Controller;

use App\Entity\User;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;


/**
 * Class AdminClientsController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AdminClientsController extends BaseController
{

    /**
     * @var DataTableFactory
     * @var RouterInterface
     */
    private $dataTableFactory;
    private $router;

    public function __construct(DataTableFactory $dataTableFactory, RouterInterface $router)
    {
        $this->dataTableFactory = $dataTableFactory;
        $this->router = $router;
    }

    /**
     * @Route("/admin/clients", name="app_admin_clients")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $table = $this->dataTableFactory->create()
            ->add('firstName', TextColumn::class, [
                'label' => 'Name',
            ])
            ->add('appStarted', BoolColumn::class, [
                'label' => 'Started',
                'trueValue' => 'Yes',
                'falseValue' => 'No',
                'nullValue' => 'No',
            ])
            ->add('appCompleted', BoolColumn::class, [
                'label' => 'Completed',
                'trueValue' => 'Yes',
                'falseValue' => 'No',
                'nullValue' => 'No',
            ])
            ->add('id', TextColumn::class, [
                'label' => 'Actions',
                'className' => 'text-center',
                'render' => function($value) {
                    return '<a href="'.$this->router->generate('app_admin_client_edit', ['id' => $value]).'">Edit</a> - <a href="'.$this->router->generate('app_admin_client_delete', ['id' => $value]).'">Delete</a>';
                }
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => User::class,
            ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('admin/clients.html.twig', [
            'datatable' => $table,
        ]);
    }

    /**
     * @Route("admin/clients/edit/{id}", name="app_admin_client_edit")
     * @param int $id
     * @return Response
     */
    public function clientEdit(int $id)
    {
        return $this->render('admin/clients_edit.html.twig', [

        ]);
    }

    /**
     * @Route("admin/clients/delete/{id}", name="app_admin_client_delete")
     * @param int $id
     * @return Response
     */
    public function clientDelete(int $id)
    {
        return $this->render('admin/clients_delete.html.twig', [

        ]);
    }

}

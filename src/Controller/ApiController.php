<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends BaseController
{
    /**
     * @Route("/api/account", name="api_account", methods={"GET"})
     */
    public function accountApi()
    {
        $user = $this->getUser();
        return $this->json($user, 200, [], [
            'groups' => 'main',
        ]);
    }
}

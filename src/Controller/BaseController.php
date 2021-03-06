<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController
 * @package App\Controller
 */
abstract class BaseController extends AbstractController
{

    /**
     * @return User
     */
    protected function getUser(): ?User
    {
        return parent::getUser();
    }
}
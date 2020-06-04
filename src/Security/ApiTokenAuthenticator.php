<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ApiTokenRepository
     * @var RouterInterface
     */
    private $apiTokenRepository;
    private $router;

    public function __construct(ApiTokenRepository $apiTokenRepository, RouterInterface $router)
    {
        $this->apiTokenRepository = $apiTokenRepository;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        return $request->get('token');
    }

    public function getCredentials(Request $request)
    {
        $authorizationToken = $request->get('token');
        return substr($authorizationToken, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $this->apiTokenRepository->findOneBy([
            'token' => $credentials,
        ]);

        if (!$token){
            throw new CustomUserMessageAuthenticationException('API Token not valid!');
        }

        if ($token->isExpired()){
            throw new CustomUserMessageAuthenticationException('API Token has expired!');
        }

        return $token->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('app_dashboard'));
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new Exception('Not used for entry_point authentication');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}

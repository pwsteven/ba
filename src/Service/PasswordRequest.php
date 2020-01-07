<?php


namespace App\Service;


use App\Repository\UserRepository;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;

class PasswordRequest
{
    /**
     * @var UserRepository
     * @var string
     * @var string
     * @var string
     */
    private $userRepository;
    private $emailUsername;
    private $emailPassword;
    private $emailHost;

    public function __construct(UserRepository $userRepository, string $emailHost, string $emailUsername, string $emailPassword)
    {
        $this->userRepository = $userRepository;
        $this->emailUsername = $emailUsername;
        $this->emailPassword = $emailPassword;
        $this->emailHost = $emailHost;
    }

    public function sendEmail()
    {
        $token = "";
        try {
            $token = Uuid::uuid1();
        } catch (UnsatisfiedDependencyException $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
}

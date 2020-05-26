<?php


namespace App\Service;

use App\Entity\UserLogged;
use Doctrine\ORM\EntityManagerInterface;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Language;
use Sinergi\BrowserDetector\Os;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class UserLogger
 * @package App\Service
 */
class UserLogger extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RequestStack
     */
    private $requestStack;


    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function userLogin(int $userID)
    {

        date_default_timezone_set('Europe/London');
        $browserDetails = new UserLogged();
        $browser = new Browser();
        $os = new Os();
        $device = new Device();
        $language = new Language();
        $browserDetails->setUserID($userID);
        $browserDetails->setBrowser($browser->getName());
        $browserDetails->setOperatingSystem($os->getName());
        $browserDetails->setDevice($device->getName());
        $browserDetails->setOpLanguage($language->getLanguage());
        $browserDetails->setTimeLogged(new \DateTime());
        $browserDetails->setVersion($browser->getVersion());
        $browserDetails->setIsMobile($os->getIsMobile());
        $browserDetails->setIsRobot($browser->getIsRobot());
        $browserDetails->setIpAddress($this->requestStack->getCurrentRequest()->getClientIp());
        $this->entityManager->persist($browserDetails);
        $this->entityManager->flush();

    }

}

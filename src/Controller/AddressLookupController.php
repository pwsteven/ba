<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddressLookupController
{
    /**
     * @var string
     * @var string
     */
    private $getAddressAPIKey;
    private $getAddressAdminAPIKey;

    public function __construct(string $getAddressAPIKey, string $getAddressAdminAPIKey)
    {
        $this->getAddressAPIKey = $getAddressAPIKey;
        $this->getAddressAdminAPIKey = $getAddressAdminAPIKey;
    }

    /**
     * @param Request $request
     * @Route("/address-lookup", name="app_address_lookup", methods={"POST"})
     */
    public function lookupAddress(Request $request)
    {
        $postcode = $request->request->get('postcode');
    }
}

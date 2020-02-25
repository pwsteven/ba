<?php


namespace App\Controller;


use Philcross\GetAddress\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AddressLookupController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class AddressLookupController extends AbstractController
{
    /**
     * @var string
     * @var string
     */
    private $getAddressAPIKey;
    private $getAddressAdminAPIKey;
    private $json;

    public function __construct(string $getAddressAPIKey, string $getAddressAdminAPIKey)
    {
        $this->getAddressAPIKey = $getAddressAPIKey;
        $this->getAddressAdminAPIKey = $getAddressAdminAPIKey;
    }

    /**
     * @param Request $request
     * @Route("/dashboard/address-lookup", name="app_address_lookup", methods={"POST"})
     * @var $response
     * @return mixed
     */
    public function lookupAddress(Request $request)
    {

        $postcode = preg_replace('/[^A-Za-z0-9]+/', '', $request->request->get('postcode'));
        $propertyNumber = "";
        $client = new Client($this->getAddressAPIKey, $this->getAddressAdminAPIKey);
        try {
            $response = $client->find($postcode, $propertyNumber, true);
        } catch (\Exception $exception) {
            if ($exception->getCode() == '404'){
                echo json_encode([
                    'status' => 'not-found',
                    'code' => 404
                ]);
                exit(0);
            }
            if ($exception->getCode() == '400'){
                echo json_encode([
                    'status' => 'invalid',
                    'code' => 400
                ]);
                exit(0);
            }
        }
        $longitude = $response->getLongitude();
        $latitude = $response->getLatitude();
        $status = 'found';
        $i=0;
        $addresses=[];
        foreach ($response->getAddresses() as $address) {
            $addresses[$i] = $address->toArray(['street_address', 'line_2', 'line_3', 'line_4', 'locality', 'town_city', 'county']);
            $i++;
        }
        return $this->json([
            'status' => $status,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'count' => $i,
            'address' => $addresses,
        ]);






    }
}

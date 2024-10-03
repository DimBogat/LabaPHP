<?php

namespace App\Controller;

use App\Model\CountryScenarios;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/country')]
class CountryController extends AbstractController
{
    private CountryScenarios $countryScenarios;

    public function __construct(CountryScenarios $countryScenarios)
    {
        $this->countryScenarios = $countryScenarios;
    }

    #[Route('', name: 'app_country_get_all', methods: ['GET'])]
    public function getAll(): Response
    {
        $countries = $this->countryScenarios->GetAll();
        return $this->json($countries);
    }

    #[Route('/{code}', name: 'app_country_get', methods: ['GET'])]
    public function get(string $code): Response
    {
        try {
            $country = $this->countryScenarios->Get($code);
            return $this->json($country);
        } catch (CountryNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (InvalidCountryCodeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('', name: 'app_country_store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $data = $request->toArray();
        try {
            $country = new Country(
                $data['short_name'],
                $data['full_name'],
                $data['iso_alpha2'],
                $data['iso_alpha3'],
                $data['iso_numeric'],
                (int)$data['population'],
                (float)$data['square']
            );
            $this->countryScenarios->Store($country);
            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (InvalidCountryCodeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (CountryAlreadyExistsException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
        }
    }
    #[Route('/{code}', name: 'app_country_edit', methods: ['PATCH'])]
    public function edit(string $code, Request $request): Response
    {
        $data = $request->toArray();
        try {
            $country = new Country(
                $data['short_name'] ?? '',
                $data['full_name'] ?? '',
                $code,
                $code,
                $code,
                (int)($data['population'] ?? 0),
                (float)($data['square'] ?? 0)
            );
            $updatedCountry = $this->countryScenarios->Edit($code, $country);
            return $this->json($updatedCountry);
        } catch (CountryNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (InvalidCountryCodeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
    #[Route('/{code}', name: 'app_country_delete', methods: ['DELETE'])]
    public function delete(string $code): Response
    {
        try {
            $this->countryScenarios->Delete($code);
            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (CountryNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (InvalidCountryCodeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
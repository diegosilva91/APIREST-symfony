<?php

namespace App\Controller;

use App\Repository\CompaniesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CompanyController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class CompanyController
{
    private $companiesRepository;
    public function __construct(CompaniesRepository $companyRepository)
    {
        $this->companiesRepository=$companyRepository;
    }

    /**
     * @Route("company", name="add_company", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $unique_code = $data['unique_code'];
        $description = $data['description'];
        $logo=$data['logo'];

        if (empty($name) || empty($unique_code)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        $this->companiesRepository->saveCompanies($name, $unique_code, $description,$logo);
        return new JsonResponse(['status' => 'Company created!'], Response::HTTP_CREATED);
    }
    /**
     * @Route("company/{id}", name="get_one_company", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $company = $this->companiesRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $company->getId(),
            'name' => $company->getName(),
            'unique_code' => $company->getUniqueCode(),
            'description' => $company->getDescription(),
            'logo' => $company->getLogo(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("company", name="getAll_company", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $companies = $this->companiesRepository->findAll();
        $data = [];

        foreach ($companies as $company) {
            $data = [
                'id' => $company->getId(),
                'name' => $company->getName(),
                'unique_code' => $company->getUniqueCode(),
                'description' => $company->getDescription(),
                'logo' => $company->getLogo(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("company/{id}", name="update_company", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $company= $this->companiesRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $company->setName($data['name']);
        empty($data['unique_code']) ? true : $company->setUniqueCode($data['unique_code']);
        empty($data['description']) ? true : $company->setDescription($data['description']);

        $updatedCompanies = $this->companiesRepository->updateCompanies($company);

        return new JsonResponse(['status' => 'Company updated!'], Response::HTTP_OK);
    }


}

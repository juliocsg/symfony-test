<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Company;
use App\Entity\Employee;
use App\Repository\CompanyRepository;
use App\Repository\EmployeeRepository;

class CompanyController extends AbstractController
{
    /** crear una nueva empresa */
    #[Route('/company/create', name: 'company_create')]

    public function create(Request $request, EntityManagerInterface $em){
        $company=new Company();
        $company->setName($request->get("name"));
        $em->persist($company);
        $em->flush();
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>[
                "id"=>$company->getId(),
                "name"=>$company->getName()
            ]
        ]);
        return $response;
    }

    /** actualizar una empresa */
    #[Route('/company/{id}/update', name: 'company_update')]
    public function update(Request $request,$id, EntityManagerInterface $em, CompanyRepository $companyRepository){
        $company=$companyRepository->find($id);
        $company_old=$company;
        $companyArray=[];
        if (!is_null($company)){
            $company->setName($request->get("name"));
            $em->persist($company);
            $em->flush();
            $companyArray[]=[
                "old_data"=>[
                    "id"=>$company_old->getId(),
                    "name"=>$company_old->getName()
                ],
                "new_data"=>[
                    "id"=>$company->getId(),
                    "name"=>$company->getName()
                ],
                
            ];
        }else{
            $companyArray[]=[
                "message"=>"Company not found"
            ];
        }
      
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$companyArray
        ]);
        return $response;
    }
    
     /** eliminar una empresa */
     #[Route('/company/{id}/delete', name: 'company_delete')]
     public function delete(Request $request,$id, EntityManagerInterface $em, CompanyRepository $companyRepository){
         $company=$companyRepository->find($id);
         $companyArray=[];
         if (!is_null($company)){
             $em->remove($company);
             $em->flush();
             $companyArray[]=[
                "message"=>"Company is success deleted"
                 
             ];
         }else{
             $companyArray[]=[
                 "message"=>"Company not found"
             ];
         }
       
         $response=new JsonResponse();
         $response->setData([
             "success"=>true,
             "data"=>$companyArray
         ]);
         return $response;
     }

     
    /** obtener una empresa */

    #[Route('/company/{id}', name: 'company_get')]
    public function getPerson(Request $request,$id,CompanyRepository $companyRepository){
        $company=$companyRepository->find($id);
        $companyArray=[];
        if (!is_null($company)){
            $companyArray[]=[
                "id"=>$company->getId(),
                "name"=>$company->getName()
            ];
        }else{
            $companyArray[]=[
                "message"=>"Company not found"
            ];
        }
      
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$companyArray
        ]);
        return $response;
    }

     /* empresa con sus empleados */
   /*   #[Route('/company_employee/{id}', name: 'company_employee_get')]
     public function getCompanyEmployees(Request $request,$id,EmployeeRepository $employeeRepository,CompanyRepository $companyRepository){
        $company = new Company();
        $employee=new Employee();
        $employees_in_company=$employeeRepository->findOneBy(['company_id' => $id]);
         $companyEmployeeArray=[];
         if (!is_null($employees_in_company)){
             $company=$companyRepository->find($id);
            foreach($employees_in_company as $employee_in_company){
                $company->addEmployee($employee_in_company->getEmployee());
            }
            foreach($company->getEmployees() as $employee){

            }
             $companyEmployeeArray[]=[
                 "id"=>$company->getId(),
                 "employees"=>$company->getEmployees()->first()->getFistName()
             ];
         }else{
             $companyEmployeeArray[]=[
                 "message"=>"The company has no employees"
             ];
         }
       
         $response=new JsonResponse();
         $response->setData([
             "success"=>true,
             "data"=>$companyEmployeeArray
         ]);
         return $response;
     }*/
 
        /* busqueda de empresas por nombre */
    #[Route('/companies_search', name: 'company_search_list')]
    public function filterByPerson(Request $request, CompanyRepository $companyRepository){
       $name=$request->get("name");   
       $companyArray=[];
       $companies=$companyRepository->createQueryBuilder('c')
                   ->where('c.name lIKE :name')
                   ->setParameter('name', '%'.$name.'%')
                   ->getQuery()
                   ->execute();
       if (!is_null($companies)){
           foreach($companies as $company){
               $companyArray[]=[
                   "id"=>$company->getId(),
                   "name"=>$company->getName()
               ];
           }
       }

        if (count($companyArray)==0){
            $companyArray[]=[
                "message"=>"Companies not search by filters"
            ];
        }
           
       $response=new JsonResponse();
       $response->setData([
           "success"=>true,
           "data"=>$companyArray
       ]);
       return $response;
    }

    /* lista de empresas */
    #[Route('/companies', name: 'company_list')]
    public function list(Request $request, CompanyRepository $companyRepository){
        $companies=$companyRepository->findAll();
        $companyArray=[];
        foreach($companies as $company){
            $companyArray[]=[
                "id"=>$company->getId(),
                "first_name"=>$company->getName()
            ];
        }
        if (count($companyArray)==0) $companyArray[]=[
            "message"=>"Companies is blank"
        ];
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$companyArray
        ]);
        return $response;
  
    }
}

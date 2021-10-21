<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;

class EmployeeController extends AbstractController
{
   /** crear un empleado */
   #[Route('/employee/create', name: 'employee_create')]
   public function create(Request $request, EntityManagerInterface $em){
       $employee=new Employee();
       $employee->setCompanyId($request->get("company_id"));
       $employee->setPersonId($request->get("person_id"));
       $em->persist($employee);
       $em->flush();
       $response=new JsonResponse();
       $response->setData([
           "success"=>true,
           "data"=>[
               "id"=>$employee->getId(),
               "company_name"=>$employee->getCompany()->getName(),
               "person_name"=>$employee->getPerson()->getFirstName()." ".$employee->getPerson()->getLastName()
           ]
       ]);
       return $response;
   }

   /** actualizar un empleado */
   #[Route('/employee/{id}/update', name: 'employee_update')]
   public function update(Request $request,$id, EntityManagerInterface $em, EmployeeRepository $employeeRepository){
       $employee=$employeeRepository->find($id);
       $employee_old=$employee;
       $employeeArray=[];
       if (!is_null($employee)){
           $employee->setCompanyId($request->get("company_id"));
           $employee->setPersonId($request->get("person_id"));
           $em->persist($employee);
           $em->flush();
           $employeeArray[]=[
               "old_data"=>[
                   "id"=>$employee_old->getId(),
                   "company_name"=>$employee_old->getCompany()->getName(),
                   "person_name"=>$employee_old->getPerson()->getFirstName()." ".$employee->getPerson()->getLastName()
               ],
               "new_data"=>[
                    "id"=>$employee->getId(),
                    "company_name"=>$employee->getCompany()->getName(),
                    "person_name"=>$employee->getPerson()->getFirstName()." ".$employee->getPerson()->getLastName()
               ],
               
           ];
       }else{
           $employeeArray[]=[
               "message"=>"Company not found"
           ];
       }
     
       $response=new JsonResponse();
       $response->setData([
           "success"=>true,
           "data"=>$employeeArray
       ]);
       return $response;
   }
   
    /** eliminar un empleado */
    #[Route('/employee/{id}/delete', name: 'employee_delete')]
    public function delete(Request $request,$id, EntityManagerInterface $em, EmployeeRepository $employeeRepository){
        $employee=$employeeRepository->find($id);
        $employeeArray=[];
        if (!is_null($employee)){
            $em->remove($employee);
            $em->flush();
            $employeeArray[]=[
               "message"=>"Employee is success deleted"
                
            ];
        }else{
            $employeeArray[]=[
                "message"=>"Employee not found"
            ];
        }
      
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$employeeArray
        ]);
        return $response;
    }

    
   /** obtener un empleado */

   #[Route('/employee/{id}', name: 'employee_get')]
   public function getPerson(Request $request,$id, EmployeeRepository $employeeRepository){
       $employee=$employeeRepository->find($id);
       $employeeArray=[];
       if (!is_null($employee)){
           $employeeArray[]=[
                "id"=>$employee->getId(),
                "company_name"=>$employee->getCompany()->getName(),
                "person_name"=>$employee->getPerson()->getFirstName()." ".$employee->getPerson()->getLastName()
           ];
       }else{
           $employeeArray[]=[
               "message"=>"Employee not found"
           ];
       }
     
       $response=new JsonResponse();
       $response->setData([
           "success"=>true,
           "data"=>$employeeArray
       ]);
       return $response;
   }

    /** obtener una persona si es empleado*/

    #[Route('/person_company/{id}', name: 'person_company_get')]
    public function getPersonCompany(Request $request,$id, EmployeeRepository $employeeRepository){
        $employee=$employeeRepository->findOneBy(['person_id' => $id]);
        $employeeArray=[];
        if (!is_null($employee)){
            $employeeArray[]=[
                 "id"=>$employee->getId(),
                 "company_name"=>$employee->getCompany()->getName(),
                 "person_name"=>$employee->getPerson()->getFirstName()." ".$employee->getPerson()->getLastName()
            ];
        }else{
            $employeeArray[]=[
                "message"=>"Person not found in company"
            ];
        }
      
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$employeeArray
        ]);
        return $response;
    }
 
     /* empresa con sus empleados */
     #[Route('/company_employee/{id}', name: 'company_employee_get')]
     public function getCompanyEmployees(Request $request,$id,EmployeeRepository $employeeRepository){

        $employees_in_company=$employeeRepository->findBy(['company_id' => $id]);
         $companyEmployeeArray=[];
         $personArray=[];
         if (!is_null($employees_in_company)){
            foreach($employees_in_company as $employee_in_company){
                $personArray[]=[
                    "id"=>$employee_in_company->getPerson()->getId(),
                    "first_name"=>$employee_in_company->getPerson()->getFirstName(),
                    "last_name"=>$employee_in_company->getPerson()->getLastName(),
                ];
            }
            
             $companyEmployeeArray[]=[
                 "company_id"=>$id,
                 "employees"=>$personArray
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
     }

   /* lista de empleados */
   #[Route('/employees', name: 'employee_list')]
   public function list(Request $request, EmployeeRepository $employeeRepository){
       $employees=$employeeRepository->findAll();
       $employeeArray=[];
       foreach($employees as $employee){
           $employeeArray[]=[
               "id"=>$employee->getId(),
               "company_name"=>$employee->getCompany()->getName(),
               "person_name"=>$employee->getPerson()->getFirstName()." ".$employee->getPerson()->getLastName()
           ];
       }
       if (count($employeeArray)==0) $employeeArray[]=[
           "message"=>"Employees is blank"
       ];
       $response=new JsonResponse();
       $response->setData([
           "success"=>true,
           "data"=>$employeeArray
       ]);
       return $response;
 
   }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\CompanyPhoneNumber;
use App\Repository\CompanyPhoneNumberRepository;

class CompanyPhoneNumberController extends AbstractController
{
    /** agreagr un numero telefonico a la empresa */
    #[Route('/company_phone_number/create', name: 'company_phone_number_create')]
    public function create(Request $request, EntityManagerInterface $em){
        $company_phone_number=new CompanyPhoneNumber();
        $company_phone_number->setCompanyId(intval($request->get("company_id")));
        $company_phone_number->setPhoneNumber(intval($request->get("phone_number")));
        $em->persist($company_phone_number);
        $em->flush();
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>[
                "id"=>$company_phone_number->getId(),
                "company_id"=>$company_phone_number->getCompanyId(),
                "phone_number"=>$company_phone_number->getPhoneNumber()
            ]
        ]);
        return $response;
    }

     /** quitar un numero telefonico a la empresa */
     #[Route('/company_phone_number/{id}/delete', name: 'company_phone_number_delete')]

    public function remove(Request $request, $id, EntityManagerInterface $em, CompanyPhoneNumberRepository $companyPhoneNumberRepository){
        $company_phone_number=$companyPhoneNumberRepository->find($id);
         $companyPhoneNumberArray=[];
         if (!is_null($company_phone_number)){
             $em->remove($company_phone_number);
             $em->flush();
             $companyPhoneNumberArray[]=[
                "message"=>" Company Phone Number is deleted"
                 
             ];
         }else{
             $companyPhoneNumberArray[]=[
                 "message"=>"Company Phone Number not found"
             ];
         }
       
         $response=new JsonResponse();
         $response->setData([
             "success"=>true,
             "data"=>$companyPhoneNumberArray
         ]);
         return $response;
    }
}

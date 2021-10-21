<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PersonPhoneNumber;
use App\Repository\PersonPhoneNumberRepository;

class PersonPhoneNumberController extends AbstractController
{
    /** agendar un numero telefonico a la persona */
    #[Route('/person_phone_number/create', name: 'person_phone_number_create')]
    public function create(Request $request, EntityManagerInterface $em){
        $person_phone_number=new PersonPhoneNumber();
        $person_phone_number->setPersonId(intval($request->get("person_id")));
        $person_phone_number->setPhoneNumber(intval($request->get("phone_number")));
        $em->persist($person_phone_number);
        $em->flush();
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>[
                "id"=>$person_phone_number->getId(),
                "person_id"=>$person_phone_number->getPersonId(),
                "phone_number"=>$person_phone_number->getPhoneNumber()
            ]
        ]);
        return $response;
    }

     /** quitar un numero telefonico a la persona */
     #[Route('/person_phone_number/{id}/delete', name: 'person_phone_number_delete')]

    public function remove(Request $request, $id, EntityManagerInterface $em, PersonPhoneNumberRepository $personPhoneNumberRepository){
        $person_phone_number=$personPhoneNumberRepository->find($id);
         $personPhoneNumberArray=[];
         if (!is_null($person_phone_number)){
             $em->remove($person_phone_number);
             $em->flush();
             $personPhoneNumberArray[]=[
                "message"=>"Phone Number is deleted"
                 
             ];
         }else{
             $personPhoneNumberArray[]=[
                 "message"=>"Phone Number not found"
             ];
         }
       
         $response=new JsonResponse();
         $response->setData([
             "success"=>true,
             "data"=>$personPhoneNumberArray
         ]);
         return $response;
    }
}

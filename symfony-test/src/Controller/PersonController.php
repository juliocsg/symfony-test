<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Person;
use App\Repository\PersonRepository;

class PersonController extends AbstractController
{

    /** crear una nueva persona */
    #[Route('/person/create', name: 'person_create')]

    public function create(Request $request, EntityManagerInterface $em){
        $person=new Person();
        $person->setFirstName($request->get("first_name"));
        $person->setLastName($request->get("last_name"));
        $person->setDocNumber($request->get("doc_number"));
        $em->persist($person);
        $em->flush();
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>[
                "id"=>$person->getId(),
                "first_name"=>$person->getFirstName(),
                "last_name"=>$person->getLastName(),
                "doc_number"=>$person->getDocNumber()
            ]
        ]);
        return $response;
    }

    /** actualizar una persona */
    #[Route('/person/{id}/update', name: 'person_update')]
    public function update(Request $request,$id, EntityManagerInterface $em,PersonRepository $personRepository){
        $person=$personRepository->find($id);
        $person_old=$person;
        $personArray=[];
        if (!is_null($person)){
            $person->setFirstName($request->get("first_name"));
            $person->setLastName($request->get("last_name"));
            $person->setDocNumber($request->get("doc_number"));
            $em->persist($person);
            $em->flush();
            $personArray[]=[
                "old_data"=>[
                    "id"=>$person_old->getId(),
                    "first_name"=>$person_old->getFirstName(),
                    "last_name"=>$person_old->getLastName(),
                    "doc_number"=>$person_old->getDocNumber()
                ],
                "new_data"=>[
                    "id"=>$person->getId(),
                    "first_name"=>$person->getFirstName(),
                    "last_name"=>$person->getLastName(),
                    "doc_number"=>$person->getDocNumber()
                ],
                
            ];
        }else{
            $personArray[]=[
                "message"=>"Person not found"
            ];
        }
      
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$personArray
        ]);
        return $response;
    }
    
     /** eliminar una persona */
     #[Route('/person/{id}/delete', name: 'person_delete')]
     public function delete(Request $request,$id, EntityManagerInterface $em,PersonRepository $personRepository){
         $person=$personRepository->find($id);
         $personArray=[];
         if (!is_null($person)){
             $em->remove($person);
             $em->flush();
             $personArray[]=[
                "message"=>"Person is deleted"
                 
             ];
         }else{
             $personArray[]=[
                 "message"=>"Person not found"
             ];
         }
       
         $response=new JsonResponse();
         $response->setData([
             "success"=>true,
             "data"=>$personArray
         ]);
         return $response;
     }

     
    /** obtener una persona */

    #[Route('/person/{id}', name: 'person_get')]
    public function getPerson(Request $request,$id,PersonRepository $personRepository){
        $person=$personRepository->find($id);
        $personArray=[];
        if (!is_null($person)){
            $personArray[]=[
                "id"=>$person->getId(),
                "first_name"=>$person->getFirstName(),
                "last_name"=>$person->getLastName(),
                "doc_number"=>$person->getDocNumber()
            ];
        }else{
            $personArray[]=[
                "message"=>"Person not found"
            ];
        }
      
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$personArray
        ]);
        return $response;
    }

    /* busqueda de personas por nombre, apellido y nro. documento*/
    #[Route('/persons_search', name: 'persons_search_list')]
     public function filterByPerson(Request $request,PersonRepository $personRepository){
        $first_name=$request->get("first_name");
        $last_name=$request->get("last_name");
        $doc_number=$request->get("first_name");
        $personArray=[];
        $persons=$personRepository->createQueryBuilder('p')
                    ->where('p.first_name lIKE :first_name or 
                            p.last_name LIKE :last_name or
                            p.doc_number LIKE :doc_number')
                    ->setParameter('first_name', '%'.$first_name.'%')
                    ->setParameter('last_name', '%'.$last_name.'%')
                    ->setParameter('doc_number', '%'.$doc_number.'%')
                    ->getQuery()
                    ->execute();
        if (!is_null($persons)){
            foreach($persons as $person){
                $personArray[]=[
                    "id"=>$person->getId(),
                    "first_name"=>$person->getFirstName(),
                    "last_name"=>$person->getLastName(),
                    "doc_number"=>$person->getDocNumber()
                ];
            }
        }else{
            $personArray[]=[
                "message"=>"Persons not search by filters"
            ];
        }
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$personArray
        ]);
        return $response;
     }

    /* lista de personas */
    #[Route('/persons', name: 'person_list')]
    public function list(Request $request,PersonRepository $personRepository){
        $persons=$personRepository->findAll();
        $personArray=[];
        foreach($persons as $person){
            $personArray[]=[
                "id"=>$person->getId(),
                "first_name"=>$person->getFirstName(),
                "last_name"=>$person->getLastName(),
                "doc_number"=>$person->getDocNumber()
            ];
        }
        if (count($personArray)==0) $personArray[]=[
            "message"=>"Persons is blank"
        ];
        $response=new JsonResponse();
        $response->setData([
            "success"=>true,
            "data"=>$personArray
        ]);
        return $response;
  
    }


}

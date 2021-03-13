<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Medico;
use App\Security\JwtAuthenticator;
use Firebase\JWT\JWT;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class MedicoController extends AbstractController
{
     /**
     * @Route("/medicos", name="get_medicos", methods={"GET"})
     */
    public function getMedicos(): JsonResponse {
        $repositorio = $this->getDoctrine()->getRepository(Medico::class);
        $medicos = $repositorio->findAll();
        $data = [];
        foreach ($medicos as $medico) {
          
           
            $data[] = [
                'id' => $medico->getId(),
                'nombre' => $medico->getNombre(),
                'apellidos' => $medico->getApellidos(),
                'especialidad' => $medico->getEspecialidad()->getNombre()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
    
}

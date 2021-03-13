<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Especialidad;
use Firebase\JWT\JWT;
use App\Security\JwtAuthenticator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;



class EspecialidadController extends AbstractController
{
    /**
     * @Route("/especialidades", name="get_especialidades", methods={"GET"})
     */
    public function getEspecialidades(): JsonResponse {
        $repositorio = $this->getDoctrine()->getRepository(Especialidad::class);
        $especialidades = $repositorio->findAll();
        $data = [];
        foreach ($especialidades as $especialidad) {
           
            $data[] = [
                'id' => $especialidad->getId(),
                'nombre' => $especialidad->getNombre()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/especialidades/{id}", name="get_especialidad", methods={"GET"})
     */
    public function getEspecialidad($id): JsonResponse {
        $especialidad = $this->getDoctrine()
                ->getRepository(Especialidad::class)
                ->find($id);

        if ($especialidad) {
            
            $data = [
                'id' => $especialidad->getId(),
                'nombre' => $especialidad->getNombre()
            ];

            return new JsonResponse($data, Response::HTTP_OK);
        }
        return new JsonResponse(['error' => 'No existe la especialidad ' . $id], Response::HTTP_NOT_FOUND);
    }
    
    /**
     * @Route("/especialidades", name="add_especialidad", methods={"POST"})
     */
    public function addEspecialidad(Request $request): JsonResponse {
        $data = $json_decode($request->getContent(), true);

        $nombre = $data['nombre'];
        
        if (empty($nombre)) {
            return new JsonResponse(['error' => 'Faltan parámetros'], Response::HTTP_PARTIAL_CONTENT);
        }

        $especialidad = new Especialidad();
        $especialidad->setNombre($nombre); 

        $em = $this->getDoctrine()->getManager();
        $em->persist($especialidad);
        $em->flush();

        return new JsonResponse(['respuesta' => 'Especialidad añadida'], Response::HTTP_OK);
    }

    /**
     * @Route("/especialidades/{id}", name="borrar_especialidad", methods={"DELETE"})
     */
    public function borrarEspecialidad($id): JsonResponse {
        $especialidad = $this->getDoctrine()
                ->getRepository(Especialidad::class)
                ->find($id);
        if ($especialidad) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($especialidad);
            $em->flush();

            return new JsonResponse(['respuesta' => 'Especialidad borrada'], Response::HTTP_OK);
        }
        return new JsonResponse(['error' => 'No existe la especialidad ' . $id], Response::HTTP_NOT_FOUND);
    }

}

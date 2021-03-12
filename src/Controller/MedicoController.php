<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Medico;

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
                'especialidad' => $medico->getEspecialidad()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
    
    /**
     * @Route("/citas/{id}", name="borrar_cita", methods={"DELETE"})
     */
    public function borrarCita($id, Request $request, ParameterBagInterface $params, UserProviderInterface $userProvider): JsonResponse {
        $em = $this->getDoctrine()->getManager();
        $auth = new JwtAuthenticator($em, $params);
        $credentials = $auth->getCredentials($request);
        $usuario = $auth->getUser($credentials, $userProvider);
        if ($usuario) {
            $cita = $this->getDoctrine()
                    ->getRepository(Cita::class)
                    ->find($id);
            if ($cita) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($cita);
                $em->flush();
                return new JsonResponse(['respuesta' => 'Cita eliminada'], Response::HTTP_OK);
            }
            return new JsonResponse(['error' => 'Cita inexistente'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(['error' => 'Usuario no logueado'], Response::HTTP_UNAUTHORIZED);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Cita;
use Firebase\JWT\JWT;
use App\Security\JwtAuthenticator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Entity\Medico;
use App\Entity\Especialidad;
use App\Entity\Usuario;
use DateTime;

class CitaController extends AbstractController {

    /**
     * @Route("/citas", name="crear_cita", methods={"POST"})
     */
    public function crearCita(Request $request, ParameterBagInterface $params, UserProviderInterface $userProvider): JsonResponse {
        $em = $this->getDoctrine()->getManager();
        $auth = new JwtAuthenticator($em, $params);

        $credentials = $auth->getCredentials($request);

        $usuario = $auth->getUser($credentials, $userProvider);

        if ($usuario) {
            $data = json_decode($request->getContent(), true);

            $medico = $data['medico'];
            
            $med = $this->getDoctrine()
                ->getRepository(Medico::class)
                ->find($medico);
            
            
            $fecha = $data['fecha'];
            //El usuario y el estado se ponen automaticamente al crear la cita.



            if (empty($medico) || empty($fecha)) {
                return new JsonResponse(['error' => 'Faltan parametros'], Response::HTTP_PARTIAL_CONTENT);
            }

            $cita = new Cita();

            $cita->setUsuario($usuario);
            $cita->setFecha(DateTime::createFromFormat('Y-m-d', $fecha));
            $cita->setEstado("Activa");
            $cita->setMedico($med);


            $em->persist($cita);
            $em->flush();

            return new JsonResponse(['respuesta' => 'Cita creada'], Response::HTTP_OK);
        }
        return new JsonResponse(['error' => 'Usuario no logueado'], Response::HTTP_UNAUTHORIZED);
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

    /**
     * @Route("/citas/{id}", name="actualizar_cita", methods={"PUT"})
     */
    public function actualizarCita($id, Request $request): JsonResponse {
        $cita = $this->getDoctrine()
                ->getRepository(Cita::class)
                ->find($id);
        if ($cita) {
            $data = json_decode($request->getContent(), true);

            $medico = $data['medico'];
            $fecha = $data['fecha'];

            if ($medico) {
                $cita->setNombre($nombre);
            }
            if ($fecha) {
                $cita->setFecha(DateTime::createFromFormat('d/m/Y', $cita));
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($cita);
            $em->flush();

            return new JsonResponse(['respuesta' => 'Cita modificada'], Response::HTTP_OK);
        }
        return new JsonResponse(['error' => 'No existe la cita ' . $id], Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/citas", name="get_citas", methods={"GET"})
     */
    public function getCitas(Request $request, ParameterBagInterface $params, UserProviderInterface $userProvider): JsonResponse {
        $em = $this->getDoctrine()->getManager();
        $auth = new JwtAuthenticator($em, $params);

        $credentials = $auth->getCredentials($request);

        $usuario = $auth->getUser($credentials, $userProvider);

        if ($usuario) {

            $data = $this->getCitasUsuario($usuario);
            return new JsonResponse($data, Response::HTTP_OK);
        }

        return new JsonResponse(['error' => 'Usuario no logueado'], Response::HTTP_UNAUTHORIZED);
    }

    //Obtiene las citas del usuario
    private function getCitasUsuario(Usuario $usuario) {
        $citas = $usuario->getCitas();

        $data = [];
        foreach ($citas as $cita) {

            $medico = [
                'id' => $cita->getMedico()->getId(),
                'nombre' => $cita->getMedico()->getNombre(),
                'apellidos' => $cita->getMedico()->getApellidos(),
                'especialidad' => $cita->getMedico()->getEspecialidad()->getNombre()
            ];

            $data[] = [
                'id' => $cita->getId(),
                'fecha' => $cita->getFecha()->format('d/m/Y'),
                'estado' => $cita->getEstado(),
                'medico' => $medico
            ];
        }
        return $data;
    }

}

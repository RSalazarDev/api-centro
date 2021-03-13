<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Usuario;
use Firebase\JWT\JWT;
use App\Security\JwtAuthenticator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use DateTime;


class UsuarioController extends AbstractController {

    /**
     * @Route("/usuarios/login", name="login", methods={"POST"})
     */
    public function login(Request $request) {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $pwd = $data['password'];

        if ($email && $pwd) {
            $usuario = $this->getDoctrine()
                    ->getRepository(Usuario::class)
                    ->findOneBy(['email' => $email]);

            if ($usuario) {
                if (password_verify($pwd, $usuario->getPassword())) {
                    $payload = [
                        "usuario" => $usuario->getEmail(),
                        "exp" => (new \DateTime())->modify("+3 day")->getTimestamp()
                    ];

                    $jwt = JWT::encode($payload, $this->getParameter('jwt_secret'), 'HS256');
                    $data = [
                        'respuesta' => 'Se ha iniciado sesion',
                        'token' => $jwt
                    ];

                    return new JsonResponse($data, Response::HTTP_OK);
                }
                return new JsonResponse(['error' => 'Credenciales inválidas'], Response::HTTP_NOT_FOUND);
            }
            return new JsonResponse(['error' => 'Credenciales inválidas'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(['error' => 'Faltan parámetros'], Response::HTTP_PARTIAL_CONTENT);
    }

    /**
     * @Route("/usuarios/registro", name="registro", methods={"POST"})
     */
    public function registrar(Request $request) {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $nombre = $data['nombre'];
        $apellidos = $data['apellidos'];
        $telefono = $data['telefono'];
        $social = $data['social'];


        if (empty($email) || empty($password) || empty($nombre) || empty($apellidos) || empty($social) || empty($telefono)) {
            return new JsonResponse(['error' => 'Faltan parámetros'], Response::HTTP_PARTIAL_CONTENT);
        }

        $usuario = new Usuario();
        $usuario->setEmail($email);
        $usuario->setNombre($nombre);
        $usuario->setApellidos($apellidos);
        $usuario->setTelefono($telefono);
        $usuario->setSeguridadSocial($social);
        $usuario->setPassword(password_hash($password, PASSWORD_BCRYPT));


        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();
        return new JsonResponse(['respuesta' => 'Usuario añadido'], Response::HTTP_OK);
    }

    /**
     * @Route("/usuarios", name="get_usuario", methods={"GET"})
     */
    public function getUsuario(Request $request, ParameterBagInterface $params, UserProviderInterface $userProvider) {
        $em = $this->getDoctrine()->getManager();
        $auth = new JwtAuthenticator($em, $params);

        $credenciales = $auth->getCredentials($request);

        $usuario = $auth->getUser($credenciales, $userProvider);
        if ($usuario) {

            $data = [
                'id' => $usuario->getId(),
                'usuario' => $usuario->getUsername(),
                'email' => $usuario->getEmail(),
                'nombre' => $usuario->getNombre(),
                'apellidos' => $usuario->getApellidos(),
                'seguridad_social' => $usuario->getSeguridadSocial()
            ];

            return new JsonResponse($data, Response::HTTP_OK);
        }
        return new JsonResponse(['error' => 'Usuario no logueado'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/usuarios", name="actualizar_usuario", methods={"PUT"})
     */
    public function actualizarUsuario(Request $request, ParameterBagInterface $params, UserProviderInterface $userProvider) {
        $em = $this->getDoctrine()->getManager();
        $auth = new JwtAuthenticator($em, $params);

        $credenciales = $auth->getCredentials($request);

        $usuario = $auth->getUser($credenciales, $userProvider);

        if ($usuario) {
            $data = json_decode($request->getContent(), true);
            
            $pwd = $data['password'];
            $nombre = $data['nombre'];
            $apellidos = $data['apellidos'];
            $telefono = $data['telefono'];
            $social = $data['social'];
            
            
            if (!empty($password)) {
                $usuario->setPassword(password_hash($password, PASSWORD_BCRYPT));
            }
            
            $usuario->setNombre($nombre);
            $usuario->setApellidos($apellidos);
            $usuario->setTelefono($telefono);
            $usuario->setSeguridadSocial($social);
            
            $em->persist($usuario);
            $em->flush();
            return new JsonResponse(['respuesta' => 'Usuario modificado correctamente'], Response::HTTP_OK);
        }
        return new JsonResponse(['error' => 'Usuario no logueado'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/usuarios", name="eliminar_usuario", methods={"DELETE"})
     */
    public function borrarUsuario(Request $request, ParameterBagInterface $params, UserProviderInterface $userProvider) {
        $em = $this->getDoctrine()->getManager();
        $auth = new JwtAuthenticator($em, $params);

        $credenciales = $auth->getCredentials($request);

        $usuario = $auth->getUser($credenciales, $userProvider);

        if ($usuario) {
            $em->remove($usuario);
            $em->flush();
            return new JsonResponse(['respuesta' => 'Usuario eliminado correctamente'], Response::HTTP_OK);
        }
        return new JsonResponse(['error' => 'Usuario no logueado'], Response::HTTP_UNAUTHORIZED);
    }

}

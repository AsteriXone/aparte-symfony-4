<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\GrupoCarrera;
use App\Entity\UserCarrera;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registro", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: Comprobar código
            $groupCode = $form->get('groupcode')->getData();
            if (!$groupCode){
                // No groupCode
                $form->get('groupcode')->addError(new FormError('Introduce el código para tu grupo!'));
                $this->addFlash('error-codigo-grupo', 'Error en código de grupo!');
            } else {
                // Si groupCode, comprobar en Base de Datos
                $grupoCarrera = $this->getDoctrine()
                ->getRepository(GrupoCarrera::class)
                ->findOneBy(['codigo_grupo' => $groupCode]);
                if (!$grupoCarrera){
                    // groupCode no existe en Base de Datos
                    $form->get('groupcode')->addError(new FormError('Códig de grupo no válido!'));
                    $this->addFlash('error-codigo-grupo', 'Error en código de grupo!');
                } else {
                    // groupCode coincide en Base de Datos
                    // Comprobar que no hay un usuario con el mismo correo
                    $userAux = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy(['email' => $form->get('email')->getData()]);
                    if ($userAux){
                        // Email existe en la base de datos
                        $form->get('email')->addError(new FormError('Email no válido!'));
                        $this->addFlash('error-codigo-grupo', 'Se ha producido en error!');
                    } else {
                        // No existe usuario con el mismo email
                        // Encode the plain password
                        $user->setPassword(
                            $passwordEncoder->encodePassword(
                                $user,
                                $form->get('password')->getData()
                            )
                        );
                        $user->setRoles(['ROLE_CARRERA', 'ROLE_USER']);

                        // Persist User
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($user);
                        $entityManager->flush();

                        // Persist UserCarrera
                        $userCarrera = new UserCarrera();
                        $userCarrera->setUser($user);
                        $userCarrera->setGrupoCarrera($grupoCarrera);
                        $entityManager2 = $this->getDoctrine()->getManager();
                        $entityManager2->persist($userCarrera);
                        $entityManager2->flush();

                        $this->addFlash('registration-succes', 'Enhorabuena!');
                        return $guardHandler->authenticateUserAndHandleSuccess(
                            $user,
                            $request,
                            $authenticator,
                            'main' // firewall name in security.yaml
                        );
                    }
                }
            }
        }

        return $this->render('registration/registrar.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

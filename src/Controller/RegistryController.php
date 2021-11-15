<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistryController extends AbstractController
{
    #[Route('/registry', name: 'registry')]
    public function registry(Request $request, UserPasswordEncoderInterface $passEncoder): Response
    {   
        
        $regForm = $this -> createFormBuilder()
        ->add('username', TextType::class,['attr' => ['class' => 'form-control form-control-line'],
            'label' => "Nom d'utilisateur"])
        ->add('password', RepeatedType::class,[
            'type' => PasswordType::class,
            'required' => true,
            'first_options' => ['attr' => ['class' => 'form-control form-control-line'],'label' => 'Mot de passe'],
            'second_options' =>  ['attr' => ['class' => 'form-control form-control-line'],'label' => 'Retapez le mot de passe']
        ])
        ->add('Valider', SubmitType::class, ['attr' => ['class' => 'btn btn-lg btn-primary']])  
        ->getForm()  
        ;
        $regForm -> handleRequest($request);
        if ($regForm->isSubmitted() && $regForm->isValid()) {
            $data = $regForm -> getData();
            var_dump($data);
            $user = new User();
            $user -> setUsername($data['username']);
            $user -> setRoles(['ROLE_ADMIN']);
            $user -> setPassword(
                $passEncoder -> encodePassword($user, $data['password'])
            ); 
            var_dump($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this -> redirect($this->generateUrl('app_login'));
        }
        return $this->render('registry/index.html.twig', [
            'regForm' => $regForm-> createview(), 
            'titre' => "S'inscrire",
            'soustitre' => "S'inscrire" 
            
        ]);
    }
}

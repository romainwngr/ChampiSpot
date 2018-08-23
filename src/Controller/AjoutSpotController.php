<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Entity\User;


use App\Entity\Champignon;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AjoutSpotController extends Controller
{
    /**
     * @Route("/ajout", name="ajoutspot")
     */

    public function ajoutSpot(Request $request, ObjectManager $manager, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
        
        $newSpot = new Spot();
        
        $form = $this->createFormBuilder($newSpot)
                     ->add('SPO_photo', HiddenType::class, array(
                        'label' => 'Ajouter une photo',
                     ))
                     ->add('SPO_accessibilite')
                     ->add('SPO_description')

                     ->add('SPO_id_champi', EntityType::class, array(
                        'class' => 'App\Entity\Champignon',
                        'choice_label' => 'id',
                     ))

                    /* ->add('SPO_id_champi', EntityType::class, [
                        'label' => 'Champignon',
                        'class' => 'App\Entity\Champignon',
                        'choice_label' => function (Champignon $champignon) {
                            return $champignon->getCHANom();
                        },
                    ]) */
                     ->add('SPO_id_champi', EntityType::class, array(
                        'label' => 'Champignon',
                        'class' => Champignon::class,
                        'choice_label' => 'CHANom',
                        'attr' => [
                            "class" => "browser-default"
                        ]
                     ))
                     ->add('SPO_id_user', HiddenType::class)
                        
                        
                    

                     ->add('SPO_longitude', HiddenType::class, [
                         'attr' => [
                             "id" => "getLng"
                         ]
                     ])

                     ->add('SPO_latitude', HiddenType::class, [
                        'attr' => [
                            "id" => "getLat"
                        ]
                    ])

                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $userId = $user->getId(); 
            dump($userId);

            $repo = $this->getDoctrine()
            ->getRepository(User::class);
            $users = $repo->find($userId);
            
            
            

            $upload_dir = "uploads/photos/";
            $photo = $form->get('SPO_photo')->getData();
            $photoname = str_replace('data:image/png;base64,', '', $photo);
            $photoname = str_replace(' ', '+', $photoname);
            $data = base64_decode($photoname);
            // déplace le fichier là où doit êtrs stocké
            $file = $upload_dir . md5($data) . ".png";
            $success = file_put_contents($file, $data);
            move_uploaded_file($success, $upload_dir);
            // updates the 'photo' property to store the photo file name
            // instead of its contents

            $newSpot->setSPOIdUser($users);
            $newSpot->setSPOPhoto($file);

            $manager->persist($newSpot);
            $manager->flush();

        }

        return $this->render('ajout_spot/ajout.html.twig', [
            'formSpot' => $form->createView(),   
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}

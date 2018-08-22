<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Entity\Champignon;
use App\Entity\CommentairesUser;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class MapController extends Controller
{
    /**
     * @Route("/search/{id}", name="search")
     */
    public function search($id)
    {
        
        /* Récupère le repo */
        $repo = $this->getDoctrine()
        ->getRepository(Spot::class);
        $spots = $repo->find($id);
        
        $comment = $spots->getCommentairesUsers();
        $longitude = $repo->find($id)->getSPOLongitude();
        $latitude = $repo->find($id)->getSPOLatitude();

        return $this->render('map/search.html.twig', [
            'controller_name' => 'MapController',
            'spots' => $spots,
            'comment' => $comment,
            'longitude' => $longitude,
            'latitude' => $latitude,

        ]);
    }


    /**
     * @Route("/", name="map")
     */

    public function map()
    {
        
        /* Récupère le repo */
        $repo = $this->getDoctrine()
        ->getRepository(Spot::class);
       
        $repoChampis = $this->getDoctrine()
        ->getRepository(Champignon::class);

        if(isset($_POST['submitFilter'])){
            $espece = $_POST['filter'];
            if ($espece != 'Default'){
                $spots = $repo
                ->findBy(array('SPO_id_champi' => $espece));
            }
            dump($spots);
       
        }else
        {
            $spots = $repo->findAll();
        }

        $allChampis = $repoChampis->findAll();
        
        



        return $this->render('index.html.twig', [
            'spots' => $spots,
            'allChampis' => $allChampis
           
           
        ]);
    }

    
}

<?php

namespace App\Controller;

use App\Entity\CatgeoriesTeamsEsport;
use App\Repository\CategoryRepository;
use App\Repository\CatgeoriesTeamsEsportRepository;
use App\Repository\TeamsEsportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MultiInsertController extends AbstractController
{
    private function getRequest()
    {
        return json_decode(Request::createFromGlobals()->getContent());
    }
    public function __invoke(EntityManagerInterface $manager,CategoryRepository $categoryRepo,TeamsEsportRepository $teams)
    {
        $requests = $this->getRequest();
        foreach ($requests as $request){

            $category  = $categoryRepo->findOneBy(["id"=> explode("/",$requests[0]->category)[3]]);

            $team  = $teams->findOneBy(["slug"=>explode("/",$requests[0]->teamEsport)[3]]);

            $categoriesTeams =  (new CatgeoriesTeamsEsport())
                ->setCategory($category)
                ->setTeamEsport($team);


            $manager->persist($categoriesTeams);

        }
        $manager->flush();
        return $this->json([
            "infos" => "ohj",
            "code" =>201
        ],201);







    }






}
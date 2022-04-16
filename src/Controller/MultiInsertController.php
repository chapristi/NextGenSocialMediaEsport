<?php

namespace App\Controller;

use App\Entity\CatgeoriesTeamsEsport;
use App\Repository\CategoryRepository;
use App\Repository\CatgeoriesTeamsEsportRepository;
use App\Repository\TeamsEsportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserJoinTeamRepository;
use Symfony\Component\Security\Core\Security;

class MultiInsertController extends AbstractController
{
    private function getRequest()
    {
        return json_decode(Request::createFromGlobals()->getContent());
    }
    public function __invoke(Security $security , UserJoinTeamRepository $joinTeamRepository , EntityManagerInterface $manager,CategoryRepository $categoryRepo, TeamsEsportRepository $teams)
    {
        $requests = $this->getRequest();
        foreach ($requests as $request){

            $category  = $categoryRepo->findOneBy(["id"=> explode("/",$requests[0]->category)[3]]);

            $team  = $teams->findOneBy(["slug"=>explode("/",$requests[0]->teamEsport)[3]]);
            $ujt = $joinTeamRepository->findByExampleField($security->getUser(),$team);


                if (!empty($ujt) && $ujt[0]->getRole()[0] === "ROLE_ADMIN" ||$security->isGranted('ROLE_ADMIN')){
                    $categoriesTeams =  (new CatgeoriesTeamsEsport())
                        ->setCategory($category)
                        ->setTeamEsport($team);


                    $manager->persist($categoriesTeams);
            }else{
                return $this->json([
                    "infos" => "Access Denied.",
                    "code" =>403
                ],403);

            }

        }
        $manager->flush();
        return $this->json([
            "infos" => "ohj",
            "code" =>201
        ],201);







    }






}
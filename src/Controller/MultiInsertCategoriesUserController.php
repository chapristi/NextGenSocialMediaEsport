<?php

namespace App\Controller;

use App\Entity\CatgeoriesTeamsEsport;
use App\Entity\CatgeoriesUser;
use App\Repository\CategoryRepository;
use App\Repository\CatgeoriesTeamsEsportRepository;
use App\Repository\TeamsEsportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserJoinTeamRepository;
use Symfony\Component\Security\Core\Security;

class MultiInsertCategoriesUserController extends AbstractController
{
    private function getRequest()
    {
        return json_decode(Request::createFromGlobals()->getContent());
    }
    public function __invoke(Security $security , UserJoinTeamRepository $joinTeamRepository , EntityManagerInterface $manager,CategoryRepository $categoryRepo, TeamsEsportRepository $teams)
    {
        $requests = $this->getRequest();
        foreach ($requests as $request){
            $category  = $categoryRepo->findOneBy(["id"=> explode("/",$request->category)[3]]);

            if (!$category){
                    return $this->json([
                        "infos" => "Access Denied.",
                        "code" =>403
                    ],403);
            }

            $categoriesUser =  (new CatgeoriesUser())
                    ->setCategory($category)
                    ;
                $manager->persist($categoriesUser );
            }
        $manager->flush();
        return $this->json([
            "infos" => "l'utilisateur c'est bien fait attribué les categories demandé ",
            "code" =>201
        ],201);


    }


}
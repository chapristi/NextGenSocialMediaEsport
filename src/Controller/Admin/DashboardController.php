<?php

namespace App\Controller\Admin;

use App\Entity\ChatTeam;
use App\Entity\TeamsEsport;
use App\Entity\User;
use App\Entity\UserJoinTeam;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct()
    {

    }
    #[Route('api/admin', name: 'admin')]
    public function index(): Response
    {

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
       return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('./DashBoardAdmin/Admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ConnexionJwt')
            ->setFaviconPath("https://cdn-icons-png.flaticon.com/512/2206/2206368.png")
            ;

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('TeamsEsport', "fab fa-steam", TeamsEsport::class);
        yield MenuItem::linkToCrud('UserJoinTeam', "fab fa-steam", UserJoinTeam::class);
        yield MenuItem::linkToCrud('ChatTeam', "fab fa-steam", ChatTeam::class);

    }
}

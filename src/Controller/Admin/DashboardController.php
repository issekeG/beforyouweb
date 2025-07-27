<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use App\Entity\Realisation;
use App\Entity\RealisationCategory;
use App\Entity\Team;
use App\Entity\Temoignage;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
#[isGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Beforyou');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-home');
        yield MenuItem::linkToCrud('Réalisation Catégorie', 'fas fa-folder-open', RealisationCategory::class);
        yield MenuItem::linkToCrud('Réalisation', 'fas fa-tools', Realisation::class);
        yield MenuItem::linkToCrud('Événement', 'fas fa-calendar-alt', Evenement::class);
        yield MenuItem::linkToCrud('Équipe dirigeante', 'fas fa-users-cog', Team::class);
        yield MenuItem::linkToCrud('Temoignage client', 'fas fa-users-cog', Temoignage::class);

    }
}

<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\RealisationCategoryRepository;
use App\Repository\RealisationRepository;
use App\Repository\TeamRepository;
use App\Repository\TemoignageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TeamRepository $teamRepository, EvenementRepository $evenementRepository, TemoignageRepository $temoignageRepository ,RealisationRepository $realisationRepository, RealisationCategoryRepository $categoryRepository): Response
    {

        $realisations = $realisationRepository->findBy([], ['projetAt' => 'DESC'], 6);
        $categories = $categoryRepository->findAll();
        $teams = $teamRepository->findAll();
        $temoignages = $temoignageRepository->findAll();
        $evenements = $evenementRepository->findBy([], ['evenementAt' => 'DESC'], 3);

        return $this->render('base.html.twig',
            [
                'realisations' => $realisations,
                'categories' => $categories,
                'teams' => $teams,
                'temoignages' => $temoignages,
                'evenements' => $evenements,
            ]
        );
    }


    #[Route('/a-propos-de-beforyou', name: 'app_about')]
    public function about(TemoignageRepository $temoignageRepository ): Response{
        return $this->render('page/about/about.html.twig',[
            'temoignages' => $temoignageRepository->findAll()
        ]);
    }

    #[Route('/nos-realisations', name: 'app_nos_realisations')]
    public function nos_realisation(RealisationRepository $realisationRepository,RealisationCategoryRepository $categoryRepository): Response{
        $realisations = $realisationRepository->findAll();
        return $this->render('page/realisation/portfolio.html.twig',[
            'realisations' => $realisations,
            'categories' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/realisations/{slug}', name: 'app_realisations_detail')]
    public function realisation_detail(string $slug, RealisationRepository $realisationRepository): Response{
        $realisation = $realisationRepository->findOneBy(['slug' => $slug]);
        return $this->render('page/realisation/portfolio-details.html.twig',[
            'realisation' => $realisation
        ]);
    }

    #[Route('/nos-services', name: 'app_nos_services')]
    public function nos_services(): Response{
        return $this->render('page/service/nos-services.html.twig',[]);
    }

    #[Route('/nos-filiales', name: 'app_nos_filiales')]
    public function nos_filiales(): Response{

        return $this->render('page/filiale/filiale.html.twig',[

        ]);
    }

    #[Route('/nos-filiales-detail/{slug}', name: 'app_nos_filiales_detail')]
    public function filiales_detail(string $slug): Response{
        if($slug == "beforyou-industrie"){

            return $this->render('page/filiale/filiale-details.html.twig',[
                'filiale' => "Beforyou Industrie",
                'filiale_contenu' => 'block/filiale-contenu/filiale-industrie-contenu.html.twig',
                'filiale_services_list' => 'block/service-list/industrie-service-list.html.twig',
            ]);
        }
        else if($slug == "beforyou-communication"){

            return $this->render('page/filiale/filiale-details.html.twig',[
                'filiale' => "Beforyou communication",
                'filiale_contenu' => 'block/filiale-contenu/filiale-communication-contenu.html.twig',
                'filiale_services_list' => 'block/service-list/communication-service-list.html.twig',
            ]);
        }
        else if($slug == "beforyou-water"){

            return $this->render('page/filiale/filiale-details.html.twig',[
                'filiale' => "Beforyou water",
                'filiale_contenu' => 'block/filiale-contenu/filiale-water-contenu.html.twig',
                'filiale_services_list' => 'block/service-list/water-service-list.html.twig',
            ]);
        }
        else if($slug == "beforyou-school"){

            return $this->render('page/filiale/filiale-details.html.twig',[
                'filiale' => "Beforyou school",
                'filiale_contenu' => 'block/filiale-contenu/filiale-school-contenu.html.twig',
                'filiale_services_list' => 'block/service-list/school-service-list.html.twig',
            ]);
        }
        else if($slug == "beforyou-print"){

            return $this->render('page/filiale/filiale-details.html.twig',[
                'filiale' => "Beforyou print",
                'filiale_contenu' => 'block/filiale-contenu/filiale-print-contenu.html.twig',
                'filiale_services_list' => 'block/service-list/print-service-list.html.twig',
            ]);
        }

        return $this->render('page/filiale/filiale-details.html.twig',[
            'filiale' => "Beforyou Industrie",
        ]);
    }

    #[Route('/services/{slug}', name: 'app_nos_services_detail')]
    public function services_detail(string $slug): Response{

        switch ($slug) {

            // Partie print
            case 'affiches':
                $service_contenu = 'block/service-detail/print/affiches.html.twig';
                $service = "Créations des affiches";
                $autre_service_nav = 'navigation/autres-service/print/affiche.html.twig';
                break;

            case 'brochures':
                $service_contenu = 'block/service-detail/print/brochures.html.twig';
                $service = "Créations des brochures";
                $autre_service_nav = 'navigation/autres-service/print/brochures.html.twig';
                break;
            case 'broderie-industrielle-textile':
                $autre_service_nav = 'navigation/autres-service/print/broderie-industrielle.html.twig';
                $service_contenu = 'block/service-detail/print/broderie-industrielle.html.twig';
                $service = "Broderie industrielle sur textile (polos, uniformes, casquettes)";
                break;

            case 'cartes-de-visite':
                $autre_service_nav = 'navigation/autres-service/print/cartes-visite.html.twig';
                $service_contenu = 'block/service-detail/print/cartes-de-visite.html.twig';
                $service = "Cartes de visite";
                break;
            case 'depliants':
                $service_contenu = 'block/service-detail/print/depliants.html.twig';
                $service = "Dépliants";
                $autre_service_nav = 'navigation/autres-service/print/depliants.html.twig';
                break;

            case 'impression-numerique':
                $service_contenu = 'block/service-detail/print/impression-numerique.html.twig';
                $service = "Impression numerique";
                $autre_service_nav = 'navigation/autres-service/print/impression-numerique.html.twig';

                break;
            case 'personnalisation-gadgets-objets-publicitaires':
                $service_contenu = 'block/service-detail/print/personnalisation-gadgets.html.twig';
                $service = "Personnalisation de gadgets et objets publicitaires";
                $autre_service_nav = 'navigation/autres-service/print/personnalisation-gadgets-objets-publicitaires.html.twig';

                break;

            case 'stickers':
                $service_contenu = 'block/service-detail/print/stickers.html.twig';
                $service = "Stickers";
                $autre_service_nav = 'navigation/autres-service/print/stickers.html.twig';

                break;

           // Partie communication

            case 'branding-identite-visuelledes-Institutions':
                $autre_service_nav = 'navigation/autres-service/communication/branding-identite-visuelledes-Institutions.html.twig';
                $service = " Branding, identité visuelle des PME & Institutions";
                $service_contenu = 'block/service-detail/communication/branding-identite-visuelle.html.twig';
                break;

            case 'conseils-strategiques-communication-marketing':
                $autre_service_nav = 'navigation/autres-service/communication/conseils-strategiques-communication-marketing.html.twig';

                $service = "Conseils stratégiques en communication et marketing";
                $service_contenu = 'block/service-detail/communication/conseils-strategiques-en-communication.html.twig';
                break;

            case 'creation-communication':
                $autre_service_nav = 'navigation/autres-service/communication/creation-communication.html.twig';

                $service = "Création de la communication (vidéos, visuels, rédaction)";
                $service_contenu = 'block/service-detail/communication/creation-de-la-communication.html.twig';

                break;
            case 'creation-sites-web-applications':
                $autre_service_nav = 'navigation/autres-service/communication/creation-sites-web-applications.html.twig';

                $service = "Création de sites web et applications";
                $service_contenu = 'block/service-detail/communication/creation-sites-web-applications.html.twig';
                break;

            case 'evenementiel':
                $service = "Evènementiel";
                $autre_service_nav = 'navigation/autres-service/communication/evenementiel.html.twig';

                $service_contenu = 'block/service-detail/communication/evenementiel.html.twig';

                break;
            case 'gestion-reseaux-sociaux':
                $autre_service_nav = 'navigation/autres-service/communication/gestion-reseaux-sociaux.html.twig';

                $service = "Gestion de réseaux sociaux";
                $service_contenu = 'block/service-detail/communication/gestion-de-reseaux-sociaux.html.twig';
                break;


            // Partie school
            case 'broderie-professionnelle-sur-tissus':
                $autre_service_nav = 'navigation/autres-service/school/broderie-professionnelle-sur-tissus.html.twig';

                $service_contenu = 'block/service-detail/school/broderie-professionnelle.html.twig';
                $service = "Broderie professionnelle sur tissus";
                break;

            case 'confection-uniformes-sur-mesure':
                $autre_service_nav = 'navigation/autres-service/school/confection-uniformes-sur-mesure.html.twig';

                $service_contenu = 'block/service-detail/school/confection-uniformes.html.twig';
                $service = "Confection d’uniformes sur mesure";
                break;

            case 'creation-logos-chartes-graphiques':
                $autre_service_nav = 'navigation/autres-service/school/creation-logos-chartes-graphiques.html.twig';

                $service_contenu = 'block/service-detail/school/creation-de-logos.html.twig';
                $service = "Création de logos et chartes graphiques";
                break;
            case 'design-documents-administratifs-scolaires':
                $autre_service_nav = 'navigation/autres-service/school/design-documents-administratifs-scolaires.html.twig';

                $service_contenu = 'block/service-detail/school/design-de-documents.html.twig';
                $service = "Design de documents administratifs scolaires";
                break;

            case 'formation':
                $autre_service_nav = 'navigation/autres-service/school/formation.html.twig';

                $service_contenu = 'block/service-detail/school/formation.html.twig';
                $service = "Formation";
                break;

            case 'reprographie':
                $autre_service_nav = 'navigation/autres-service/school/reprographie.html.twig';

                $service_contenu = 'block/service-detail/school/reprographie.html.twig';
                $service = "Reprographie";
                break;

            // Partie Industrie
            case 'construction-batiments':
                $autre_service_nav = 'navigation/autres-service/industrie/construction-batiments.html.twig';

                $service_contenu = 'block/service-detail/industrie/construction-batiments.html.twig';
                $service = "Construction de batiments";
                break;
            case 'etude':
                $service = "Etude";
                $autre_service_nav = 'navigation/autres-service/industrie/etude.html.twig';

                $service_contenu = 'block/service-detail/industrie/etude.html.twig';
                break;
            case 'rehabilitation-batiments':
                $autre_service_nav = 'navigation/autres-service/industrie/rehabilitation-batiments.html.twig';

                $service = "Réhabilitation de bâtiments";
                $service_contenu = 'block/service-detail/industrie/rehabilitation-de-batiments.html.twig';
                break;

            // Partie water
            case 'forage-de-puits':
                $autre_service_nav = 'navigation/autres-service/water/forage-de-puits.html.twig';

                $service = "Forage de puits";
                $service_contenu = 'block/service-detail/water/forage-de-puits.html.twig';
                break;

            case 'installation-pompes-manuelles-motorisees':
                $autre_service_nav = 'navigation/autres-service/water/installation-pompes-manuelles-motorisees.html.twig';

                $service_contenu = 'block/service-detail/water/installation-pompes-manuelles.html.twig';
                $service = "Installation de pompes manuelles et motorisées";
                break;

            case 'suivi-entretien-regulier':
                $autre_service_nav = 'navigation/autres-service/water/suivi-entretien-regulier.html.twig';

                $service = "Suivi et entretien régulier";
                $service_contenu = 'block/service-detail/water/suivi-entretien.html.twig';
                break;

            case 'systemes-stockage-distribution':
                $autre_service_nav = 'navigation/autres-service/water/systemes-stockage-distribution.html.twig';

                $service = "Systemes stockages / distribution";
                $service_contenu = 'block/service-detail/water/systemes-stockage-distribution.html.twig';
                break;

            default:
                break;
        }


        return $this->render('page/service/service-details.html.twig',[
            'service_contenu' => $service_contenu,
            'service' => $service,
            'autre_service_nav' =>$autre_service_nav
        ]);
    }

    #[Route('/notre-equipe', name: 'app_notre_equipe')]
    public function notre_equipes(TeamRepository $teamRepository): Response{
        $teams = $teamRepository->findAll();
        return $this->render('page/equipe/notre-equipe.html.twig',[
            'teams' => $teams
        ]);
    }

    #[Route('/notre-actualites', name: 'app_notre_actualites')]
    public function notre_actualites(EvenementRepository $evenementRepository): Response{
        return $this->render('page/blog/blog.html.twig',[
            'evenements'=>$evenementRepository->findAll()
        ]);
    }

    #[Route('/actualite/{slug}', name: 'app_notre_actualites_detail')]
    public function app_notre_actuality_detail(string $slug, EvenementRepository $evenementRepository): Response{
        $evenement = $evenementRepository->findOneBy(['slug' => $slug]);

        return $this->render('page/blog/blog-details.html.twig',[
            'evenement'=>$evenement
        ]);
    }



    #[Route('/nous-contacter', name: 'app_notre_contact')]
    public function nous_contact(): Response{
        return $this->render('page/contact/contact.html.twig',[]);
    }

    #[Route('/demande-un-devis', name: 'app_demande_devis')]
    public function demander_un_devis(): Response{
        return $this->render('page/devis/devis.html.twig',[]);
    }
}

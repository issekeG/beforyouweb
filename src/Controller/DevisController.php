<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Devis;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact')]
final class DevisController extends AbstractController
{

    #[Route('/message', name: 'app_nouveau_contact', methods: ['POST'])]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();

        // Récupération des données du formulaire
        $contact->setFirstname($request->request->get('prenom'));
        $contact->setLastname($request->request->get('nom'));
        $contact->setEmail($request->request->get('email'));
        $contact->setTelephone($request->request->get('telephone'));
        $contact->setSujet($request->request->get('subject'));
        $contact->setDescription($request->request->get('message'));


        $em->persist($contact);
        $em->flush();

        return $this->redirectToRoute('app_devis_success');
    }



    #[Route('/devis', name: 'app_nouveau_devis', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $devis = new Devis();

        // Récupération des données du formulaire
        $devis->setFullName($request->request->get('name'));
        $devis->setTelephone($request->request->get('phone'));
        $devis->setEmail($request->request->get('email'));
        $devis->setEntreprise($request->request->get('company'));
        $devis->setBudget($request->request->get('budget'));
        $devis->setDelais($request->request->get('deadline'));
        $devis->setDescription($request->request->get('message'));
        $devis->setFiliale($request->request->get('filiale'));

        // Récupération des services (array)
        $services = $request->request->all('services'); // renvoie un array
        $devis->setServices($services);

        // Gérer le fichier (optionnel)
        $uploadedFile = $request->files->get('attachment');
        if ($uploadedFile) {
            $devis->setDocumentFile($uploadedFile);
        }

        $em->persist($devis);
        $em->flush();

        return $this->redirectToRoute('app_devis_success');
    }


    #[Route(name: 'app_devis_index', methods: ['GET'])]
    public function index(DevisRepository $devisRepository): Response
    {
        return $this->render('devis/index.html.twig', [
            'devis' => $devisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_devis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devi = new Devis();
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($devi);
            $entityManager->flush();

            return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/new.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_devis_show', methods: ['GET'])]
    public function show(Devis $devi): Response
    {
        return $this->render('devis/show.html.twig', [
            'devi' => $devi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/edit.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($devi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Board;
use App\Form\BoardType;
use App\Entity\Advisor;
use App\Entity\Demand;
use App\Form\DemandType;
use App\Repository\AdvisorRepository;
use App\Repository\BoardRepository;
use App\Repository\DemandRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/demands/", name="demands")
     * @param DemandRepository $demandRepository
     * @param TagRepository $tagRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(
        DemandRepository $demandRepository,
        TagRepository $tagRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        /* Changement de statut de la demande */
        if (isset($_POST['statutSubmitted'])) {
            $values = explode("-", $_POST['radio']);
            $demand = $demandRepository->findOneBy(['id' => $values[1]]);
            $demand->setStatus($values[0]);
            $entityManager->flush();
            return $this->redirectToRoute('demands');
        }
        $demands = $demandRepository ->findAll();
        $tags = $tagRepository->findAll();

        /* Création d'une demande */
        $demand = new Demand();
        $form = $this->createForm(DemandType::class, $demand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demand->setStatus(1);
            $board = new Board();
            $board->setDemand($demand);
            $entityManager->persist($demand);
            $entityManager->persist($board);
            $entityManager->flush();

            return $this->redirectToRoute('demands');
        }
        return $this->render('admin/demands.html.twig', [
            'demands'=>$demands,
            'tags' => $tags,
            'formDemand' =>$form->createView(),
        ]);
    }


    /**
     * @Route("/admin/advisors", name="advisors")
     * @param AdvisorRepository $advisorRepository
     * @return Response
     */
    public function advisor(AdvisorRepository $advisorRepository)
    {
        $advisors = $advisorRepository->findAll();
        return $this->render('admin/advisors.html.twig', [
            'advisors' => $advisors
        ]);
    }

    /**
     * @Route("/board/{id}", name="board")
     * @param AdvisorRepository $advisorRepository
     * @param Board $board
     * @param Request $request
     * @param DemandRepository $demandRepository
     * @return Response
     */
    public function board(
        AdvisorRepository $advisorRepository,
        Board $board,
        Request $request,
        DemandRepository $demandRepository
    ) {
        $advisor = $advisorRepository->findAll();
        $demand = $demandRepository->findOneBy(['id' => $board->getDemand()]);
        $tags = $demand->getTags()->getValues();

        $advisorsArray = array();
        $totalAdvisors = count($advisor);
        for ($i = 0; $i<$totalAdvisors; $i++) {
            $matches = 0;
            $advisorsTags = $advisor[$i]->getTags()->getValues();
            $totalTags = count($tags);
            for ($j = 0; $j<$totalTags; $j++) {
                $totalTags2 = count($advisorsTags);
                for ($k = 0; $k< $totalTags2; $k++) {
                    if ($advisorsTags[$k] === $tags[$j]) {
                        $matches++;
                    }
                }
            }
            $advisorAndSum = [$matches => $advisor[$i]->getId()] ;
            array_push($advisorsArray, $advisorAndSum);
        }

        $total = count($advisorsArray);
        for ($i = 0; $i<$total; $i++) {
            $total2 = count($advisorsArray);
            for ($j = 0 + $i; $j< $total2; $j++) {
                if (key($advisorsArray[$i]) < key($advisorsArray[$j])) {
                    $temporary = $advisorsArray[$j];
                    $advisorsArray[$j] = $advisorsArray[$i];
                    $advisorsArray[$i] = $temporary;
                }
            }
        }


        $allAdvisorsSorted = array();
        foreach ($advisorsArray as $advisor => $data) {
            foreach ($data as $matches => $id) {
                $advisorSorted = $advisorRepository->findOneBy(['id' => $id]);
                array_push($allAdvisorsSorted, $advisorSorted);
            }
        }



        $form = $this->createForm(BoardType::class, $board);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/constructBoard.html.twig', [
            'advisors' => $allAdvisorsSorted,
            'formBoard' => $form->createView(),

        ]);
    }
}

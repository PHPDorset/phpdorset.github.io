<?php

namespace PhpDorset\Presentation;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class PresentationController
{
    /**
     * @var PresentationRepository
     */
    protected $repository;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param PresentationRepository $eventRepository
     * @param \Twig_Environment $twig
     */
    public function __construct(PresentationRepository $eventRepository, \Twig_Environment $twig)
    {
        $this->repository = $eventRepository;
        $this->twig = $twig;
    }

    /**
     * @param $year
     * @param $month
     * @return JsonResponse
     */
    public function fetchCuesByYearAndMonth($year, $month)
    {
        $hasPdfFile = true;

        $errors = [];

        $presentation = $this->repository->fetchPresentation($year, $month);

        if (is_null($presentation) || !file_exists(realpath($_SERVER["DOCUMENT_ROOT"]) . $presentation->getPdf())) {
            $hasPdfFile = false;
        }

        return $this->twig->render(
            'talk.twig',
            array(
                'hasPresentation' => $hasPdfFile,
                'avatar' => $presentation->getAvatar(),
                'speaker' => $presentation->getSpeaker(),
                'year' => $presentation->getYear(),
                'month' => $presentation->getMonth(),
                'title' => $presentation->getTitle(),
                'feedbackUrl' => $presentation->getFeedbackUrl(),
                'abstract' => $presentation->getAbstract(),
                'video_url' => $presentation->getVideo(),
                'pdf_url' => $presentation->getPdf(),
                'cues' => $presentation->getCues(),
                'resources' => $presentation->getResources(),
                'errors' => $errors
            )
        );
    }

    /**
     * @return JsonResponse
     */
    public function fetchAll()
    {
        $events = $this->repository->fetchAll();
        return new JsonResponse($events);
    }

    /**
     * @return string
     */
    public function fetchTalkList()
    {
        return $this->twig->render(
            'talk_list.twig',
            array(
                'talks' => $this->repository->fetchAll()
            )
        );
    }
}

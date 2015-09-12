<?php

namespace PhpDorset\Talk;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class TalkController
{
    /**
     * @var TalkRepository
     */
    protected $repository;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param TalkRepository $eventRepository
     * @param \Twig_Environment $twig
     */
    public function __construct(TalkRepository $eventRepository, \Twig_Environment $twig)
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

        $talk = $this->repository->fetchTalk($year, $month);

        if (is_null($talk) || !file_exists(realpath($_SERVER["DOCUMENT_ROOT"]) . $talk->getPdf())) {
            $hasPdfFile = false;
        }

        return $this->twig->render(
            'talk.twig',
            array(
                'hasPresentation' => $hasPdfFile,
                'avatar' => $talk->getAvatar(),
                'speaker' => $talk->getSpeaker(),
                'year' => $talk->getYear(),
                'month' => $talk->getMonth(),
                'title' => $talk->getTitle(),
                'feedbackUrl' => $talk->getFeedbackUrl(),
                'abstract' => $talk->getAbstract(),
                'video_url' => $talk->getVideo(),
                'pdf_url' => $talk->getPdf(),
                'cues' => $talk->getCues(),
                'resources' => $talk->getResources(),
                'twitter' => $talk->getTwitter(),
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

<?php

namespace PhpDorset\Talk;

use PhpDorset\Eventbrite\EventbriteService;
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
     * @var EventbriteService
     */
    private $eventbrite;

    /**
     * @param TalkRepository $eventRepository
     * @param \Twig_Environment $twig
     * @param EventbriteService $eventbrite
     */
    public function __construct(TalkRepository $eventRepository, \Twig_Environment $twig, EventbriteService $eventbrite)
    {
        $this->repository = $eventRepository;
        $this->twig = $twig;
        $this->eventbrite = $eventbrite;
    }

    /**
     * @param $year
     * @param $month
     * @param $key
     * @return string
     */
    public function fetchTalk($year, $month, $key)
    {
        $hasPdfFile = true;

        $errors = [];

        $talk = $this->repository->fetchTalk($year, $month, $key);

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
     * @param $year
     * @param $month
     * @return JsonResponse
     */
    public function fetchTalksByYearAndMonth($year, $month)
    {
        $talks = $this->repository->fetchTalks($year, $month);

        if (count($talks) === 1){
            return $this->fetchTalk($year, $month, 1);
        }

        return $this->twig->render(
            'talk_selection.twig',
            array(
                'talks' => $talks,
                'month' => $month,
                'year' => $year
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

    public function fetchHomepageTalks()
    {

        $nextMonth = new \DateTime('now', new \DateTimeZone('Europe/London'));
        $nextMonth->add(new \DateInterval('P1M'));

        $talksNextMonth = $this->repository->fetchTalks($nextMonth->format('Y'), strtolower($nextMonth->format('F')));

        $thisMonth = clone $nextMonth;
        $thisMonth->sub(new \DateInterval('P1M'));

        $talksThisMonth = $this->repository->fetchTalks($thisMonth->format('Y'), strtolower($thisMonth->format('F')));

        return $this->twig->render(
            'homepage.twig',
            array(
                'talksNextMonth' => $talksNextMonth,
                'talksThisMonth' => $talksThisMonth,
                'currentDate' => new \DateTime('now', new \DateTimeZone('Europe/London'))
            )
        );


    }

    public function createTalk()
    {
        $events = $this->eventbrite->getEvents();

        echo '<pre>';print_r($events);exit;


        return $this->twig->render(
            'talk_create.twig'
        );
    }

    public function createFormAction()
    {




    }

}

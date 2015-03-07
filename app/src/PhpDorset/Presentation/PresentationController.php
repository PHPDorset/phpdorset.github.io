<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/04/2014
 * Time: 22:32
 */

namespace PhpDorset\Presentation;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PresentationController
 * @package PhpDorset\Presentation
 */
class PresentationController
{
    /**
     * @var PresentationRepository
     */
    protected $repository;
    private $app;

    /**
     * @param PresentationRepository $eventRepository
     */
    public function __construct(PresentationRepository $eventRepository, $app)
    {
        $this->repository = $eventRepository;
        $this->_app = $app;
    }

    /**
     * @param $year
     * @param $month
     * @return JsonResponse
     */
    public function fetchCuesByYearAndMonth($year, $month)
    {
        $presentation = true;
        $errors = [];

        $cues = array_map(function($cue){
            list($mins,$secs) = explode(':',$cue);
            return ($mins*60)+($secs);
        }, $this->repository->fetchCues($year, $month));

        $video_url = $this->repository->fetchVideo($year, $month);

        $pdf_url = "/presentations/{$year}_{$month}.pdf";
        if(!file_exists(realpath($_SERVER["DOCUMENT_ROOT"]).$pdf_url))
        {
           $presentation = false;
        }

        $title = $this->repository->fetchTitle($year, $month);
        $abstract = $this->repository->fetchAbstract($year, $month);
        $feedbackUrl = $this->repository->fetchFeedbackUrl($year, $month);
        $avatar = $this->repository->fetchAvatar($year, $month);
        $speaker = $this->repository->fetchSpeaker($year, $month);
        $resources = $this->repository->fetchResources($year, $month);

        return $this->_app['twig']->render(
            'talk.twig',
            array(
                'presentation' => $presentation,
                'avatar' => $avatar,
                'speaker' => $speaker,
                'year' => $year,
                'month' => $month,
                'title' => $title,
                'feedbackUrl' => $feedbackUrl,
                'abstract' => $abstract,
                'video_url' => $video_url,
                'pdf_url' => $pdf_url,
                'cues'    => $cues,
                'resources' => $resources,
                'errors'  => $errors
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

    public function fetchTalkList()
    {
        return $this->_app['twig']->render(
            'talk_list.twig',
            array(
                'talks' => $this->repository->fetchAll()
            )
        );
    }


}

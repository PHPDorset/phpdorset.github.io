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
        $cues = $this->repository->fetchCues($year, $month);
        $pdf_url = "/presentations/{$year}_{$month}.pdf";

        return $this->_app['twig']->render(
            'talk.twig',
            array(
                'pdf_url' => $pdf_url,
                'cues'    => $cues
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
}

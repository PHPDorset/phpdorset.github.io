<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/04/2014
 * Time: 23:01
 */

namespace PhpDorset\Presentation;

/**
 * Class PresentationRepository
 * @package PhpDorset\Presentation
 */
class PresentationRepository
{
    /**
     * @var array
     */
    protected $cues;

    /**
     * @param string $cueDatabase
     */
    public function __construct($cueDatabase)
    {
        $this->cues = json_decode(file_get_contents($cueDatabase), true);
    }

    /**
     * @param string $year
     * @param string $month
     * @return array
     */
    public function fetchCues($year, $month)
    {
        return $this->cues[$year][$month]['cues'];
    }


    /**
     * @param $year
     * @param $month
     * @return mixed
     */
    public function fetchVideo($year, $month)
    {
        return $this->cues[$year][$month]['video'];
    }

    /**
     * @param $year
     * @param $month
     * @return mixed
     */
    public function fetchAbstract($year, $month)
    {
        return $this->cues[$year][$month]['abstract'];
    }

    /**
     * @param $year
     * @param $month
     * @return mixed
     */
    public function fetchAvatar($year, $month)
    {
        return $this->cues[$year][$month]['avatar'];
    }

    /**
     * @param $year
     * @param $month
     * @return mixed
     */
    public function fetchFeedbackUrl($year, $month)
    {
        return $this->cues[$year][$month]['feedbackUrl'];
    }


    /**
     * @param $year
     * @param $month
     * @return mixed
     */
    public function fetchTitle($year, $month)
    {
        return $this->cues[$year][$month]['title'];
    }

    /**
     * @param $year
     * @param $month
     * @return mixed
     */
    public function fetchSpeaker($year, $month)
    {
        return $this->cues[$year][$month]['speaker'];
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->cues;
    }
}

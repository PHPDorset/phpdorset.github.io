<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/04/2014
 * Time: 23:01
 */

namespace PhpDorset\Presentation;

/**
 * Class TalkRepository
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
     * @return array
     */
    public function fetchAll()
    {
        return $this->cues;
    }
}

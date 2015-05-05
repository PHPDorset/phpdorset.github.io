<?php

namespace PhpDorset\Presentation;

class PresentationRepository
{
    /**
     * @var array
     */
    protected $cues;

    /**
     * @param array $cues
     */
    public function __construct(array $cues)
    {
        $this->cues = $cues;
    }

    /**
     * @param string $year
     * @param string $month
     * @return Presentation|null
     */
    public function fetchPresentation($year, $month)
    {
        $month = strtolower($month);

        if (!isset($this->cues[$year][$month])) {
            return null;
        }

        return Presentation::createFromArray($month, $year, $this->cues[$year][$month]);
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->cues;
    }
}

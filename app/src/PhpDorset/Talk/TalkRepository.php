<?php

namespace PhpDorset\Talk;

class TalkRepository
{
    /**
     * @var array
     */
    protected $talks;

    /**
     * @param array $talks
     */
    public function __construct(array $talks)
    {
        $this->talks = $talks;
    }

    /**
     * @param string $year
     * @param string $month
     * @return Talk|null
     */
    public function fetchTalk($year, $month)
    {
        $month = strtolower($month);

        if (!isset($this->talks[$year][$month])) {
            return null;
        }

        return Talk::createFromArray($year,$month, $this->talks[$year][$month]);
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->talks;
    }
}

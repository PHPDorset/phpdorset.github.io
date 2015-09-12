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
     * @return Talk[]
     */
    public function fetchTalks($year, $month)
    {
        $month = strtolower($month);

        if(!isset($this->talks[$year][$month])){
            return [];
        }

        $talks = $this->talks[$year][$month];

        if (!isset($talks)) {
            return [];
        }

        return array_map(function($talk) use ($year, $month){
            return Talk::createFromArray($year,$month, $talk);
        }, $talks);
    }

    /**
     * @param string $year
     * @param string $month
     * @param $key
     * @return Talk
     */
    public function fetchTalk($year, $month, $key)
    {
        $month = strtolower($month);

        $talk = $this->talks[$year][$month][$key];

        if (!isset($talk)) {
            return null;
        }

        return Talk::createFromArray($year,$month, $talk);
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->talks;
    }
}

<?php

namespace PhpDorset\Talk;

final class TalkRepository
{
    /**
     * @var array[year][month][id]
     */
    private $talks;

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
     *
     * @return Talk[]
     */
    public function fetchTalks(string $year, string $month): array
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
     *
     * @return Talk
     */
    public function fetchTalk(string $year, string $month, string $key): Talk
    {
        $month = strtolower($month);

        $talk = $this->talks[$year][$month][$key];

        if (!isset($talk)) {
            return null;
        }

        return Talk::createFromArray($year,$month, $talk);
    }

    /**
     * @return Talk[]
     */
    public function fetchAll(): array
    {
        return $this->talks;
    }
}

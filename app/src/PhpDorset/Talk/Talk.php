<?php

namespace PhpDorset\Talk;

class Talk
{
    protected $abstract = '';
    protected $avatar = '';
    protected $cues = [];
    protected $feedbackUrl = '';
    protected $month = '';
    protected $pdf = '';
    protected $resources = [];
    protected $speaker = '';
    protected $title = '';
    protected $video = '';
    protected $year = '';
    protected $twitter = '';

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param string $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = (string)$abstract;
    }

    /**
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = (string)$avatar;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param array $cues
     */
    public function setCues(array $cues)
    {
        $this->cues = $cues;
    }

    /**
     * @return array
     */
    public function getCues()
    {
        return $this->cues;
    }

    /**
     * @param string $feedbackUrl
     */
    public function setFeedbackUrl($feedbackUrl)
    {
        $this->feedbackUrl = (string)$feedbackUrl;
    }

    /**
     * @return string
     */
    public function getFeedbackUrl()
    {
        return $this->feedbackUrl;
    }

    /**
     * @param string $month
     */
    public function setMonth($month)
    {
        $this->month = (string)$month;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param string $pdf
     */
    public function setPdf($pdf)
    {
        $this->pdf = (string)$pdf;
    }

    /**
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * @param array $resources
     */
    public function setResources(array $resources)
    {
        $this->resources = $resources;
    }

    /**
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param string $speaker
     */
    public function setSpeaker($speaker)
    {
        $this->speaker = (string)$speaker;
    }

    /**
     * @return string|array
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = (string)$title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $video
     */
    public function setVideo($video)
    {
        $this->video = (string)$video;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $year
     */
    public function setYear($year)
    {
        $this->year = (string)$year;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string|array $twitter
     */
    public function setTwitter($twitter)
    {
        $twitter = str_replace('https://twitter.com/', '', $twitter);
        $twitters = explode('/', $twitter);

        if (count($twitters) > 1){
            $this->twitter = $twitters;
        }

        $this->twitter = $twitter;
    }

    /**
     * @return string|array
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


    /**
     * @param string $month
     * @param string $year
     * @param array $data
     * @return Talk
     */
    public static function createFromArray($year, $month, array $data)
    {
        $talk = new Talk();
        $talk->setAbstract(isset($data['abstract']) ? $data['abstract'] : '');
        $talk->setAvatar(isset($data['avatar']) ? $data['avatar'] : '');
        $talk->setDate(isset($data['twitter']) ? new \DateTime($data['date'], new \DateTimeZone('Europe/London')) : null);
        $talk->setFeedbackUrl(isset($data['feedbackUrl']) ? $data['feedbackUrl'] : '');
        $talk->setMonth($month);
        $talk->setPdf("/pdfs/{$year}_{$month}.pdf");
        $talk->setResources(isset($data['resources']) ? $data['resources'] : []);
        $talk->setSpeaker(isset($data['speaker']) ? $data['speaker'] : '');
        $talk->setTitle(isset($data['title']) ? $data['title'] : '');
        $talk->setVideo(isset($data['video']) ? $data['video'] : '');
        $talk->setTwitter(isset($data['twitter']) ? $data['twitter'] : '');
        $talk->setYear($year);

        if (isset($data['cues'])) {
            $talk->setCues(array_map(function ($cue) {
                list($mins, $secs) = explode(':', $cue);
                return ($mins * 60) + ($secs);
            }, $data['cues']));
        }

        return $talk;
    }
}

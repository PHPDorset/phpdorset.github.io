<?php

namespace PhpDorset\Talk;

final class Talk
{
    /**
     * @var string
     */
    private $abstract;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string[]
     */
    private $cues;

    /**
     * @var string
     */
    private $feedbackUrl;

    /**
     * @var string
     */
    private $month;

    /**
     * @var string
     */
    private $pdf;

    /**
     * @var string[]
     */
    private $resources;

    /**
     * @var string[]
     */
    private $speaker;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $video;

    /**
     * @var string
     */
    private $year;

    /**
     * @var string
     */
    private $twitter;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var string
     */
    private $ticketLink;

    private function __construct()
    {
    }

    public function __set($key, $value)
    {
        throw new \BadMethodCallException('Talk is Immutable');
    }

    /**
     * @return string
     */
    public function getAbstract(): string
    {
        return $this->abstract;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @return array
     */
    public function getCues(): array
    {
        return $this->cues;
    }

    /**
     * @return string
     */
    public function getFeedbackUrl(): string
    {
        return $this->feedbackUrl;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function getPdf(): string
    {
        return sprintf('/pdfs/%s', $this->pdf);
    }

    /**
     * @return array
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * @return string
     */
    public function getSpeaker(): string
    {
        return $this->speaker;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getTwitter(): string
    {
        return $this->twitter;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return bool
     */
    public function isInTheFuture(): bool
    {
        return $this->date > (new \DateTimeImmutable('now', new \DateTimeZone('Europe/London')));
    }

    /**
     * @return string
     */
    public function getTicketLink(): string
    {
        return $this->ticketLink;
    }

    /**
     * @param string $month
     * @param string $year
     * @param string[] $data
     *
     * @return self
     */
    public static function createFromArray(string $year, string $month, array $data)
    {
        $date = isset($data['date'])
            ? new \DateTimeImmutable($data['date'], new \DateTimeZone('Europe/London'))
            : new \DateTimeImmutable(sprintf('%s %s',$month, $year), new \DateTimeZone('Europe/London'));

        $talk = new Talk();
        $talk->abstract = $data['abstract'] ?? '';
        $talk->avatar = $data['avatar'] ?? '';
        $talk->date = $date;
        $talk->feedbackUrl = $data['feedbackUrl'] ?? '';
        $talk->month = $month;
        $talk->pdf = $data['slides'] ?? '';
        $talk->resources = $data['resources'] ?? [];
        $talk->speaker = $data['speaker'];
        $talk->title = $data['title'];
        $talk->video = $data['video'] ?? '';
        $talk->twitter = str_replace('https://twitter.com/', '', isset($data['twitter']) ? $data['twitter'] : null);
        $talk->year = $year;
        $talk->ticketLink = $data['ticketLink'] ?? 'https://phpdorset.eventbrite.co.uk';

        $talk->cues = array_map(function (string $cue) {
            list($mins, $secs) = explode(':', $cue);
            return ($mins * 60) + ($secs);
        }, $data['cues'] ?? []);

        return $talk;
    }
}

<?php

namespace PhpDorset\EventBrite;

class EventDecorator
{
    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function getName($html = false)
    {
        if ($html) {
            return $this->event->name->html;
        }

        return $this->event->name->text;
    }

    public function getDescription($html = false)
    {
        if ($html) {
            return $this->event->name->html;
        }

        return $this->event->description->text;
    }

    public function getStart()
    {
        $timezone = new \DateTimeZone($this->event->start->timezone);
        $start = new \DateTime($this->event->start->local, $timezone);

        return $start;
    }

    public function getEnd()
    {
        $timezone = new \DateTimeZone($this->event->end->timezone);
        $end = new \DateTime($this->event->end->local, $timezone);

        return $end;
    }

    public function __isset($prop)
    {
        if (method_exists($this, 'get' . ucfirst($prop))) {
            return false;
        }

        return isset($this->event->$prop);
    }

    public function __get($prop)
    {
        return $this->event->$prop;
    }
}


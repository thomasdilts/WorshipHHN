<?php
namespace app\models;

class Ics {
    const DT_FORMAT = 'Ymd\THis'; //define date format here
    public $events;
    function __construct($events) {
        if (count($events) > 0) {
            for ($p = 0; $p <= count($events) - 1; $p++) {
                foreach ($events[$p] as $key => $val) {
                    $events[$p][$key] = $this->sanitize_val($val, $key);
                }
            }
        }
        $this->events = $events;
    }
    private function sanitize_val($val, $key = false) {
        switch ($key) {
            case 'dtend':
            case 'dtstamp':
            case 'dtstart':
                $val = $this->format_timestamp($val);
                break;
            default:
                $val = $this->escape_string($val);
        }
        return $val;
    }
    private function format_timestamp($timestamp) {
        $dt = new \DateTime($timestamp);
        return $dt->format(self::DT_FORMAT);
    }
    private function escape_string($str) {
        return preg_replace('/([,;])/', '$1', $str);
    }
    function prepare($timezone) {
        $cp = array();
        if (count($this->events) > 0) {
            $cp[] = 'BEGIN:VCALENDAR';
            $cp[] = 'VERSION:2.0';
            $cp[] = 'PRODID:-//hacksw/handcal//NONSGML v1.0//EN//b3';
            $cp[] = 'CALSCALE:GREGORIAN';
            for ($p = 0; $p <= count($this->events) - 1; $p++) {
                $cp[] = 'BEGIN:VEVENT';
                foreach ($this->events[$p] as $key => $val) {
                    if ($key === 'url') {
                        $cp[] = 'URL;VALUE=URI:' . $val;
                    } elseif ($key === 'alarm') {
                        $cp[] = 'BEGIN:VALARM';
                        $cp[] = 'TRIGGER:-PT' . $val;
                        $cp[] = 'ACTION:DISPLAY';
                        $cp[] = 'END:VALARM';
                    } elseif ($key === 'dtstart' || $key === 'dtend') {
                        $cp[] = strtoupper($key) . ';TZID='.$timezone.':' . $val;
                    } else {
                        $cp[] = strtoupper($key) . ':' . $val;
                    }
                }
                $cp[] = 'END:VEVENT';
            }
            $cp[] = 'END:VCALENDAR';
        }
        return implode("\r\n", $cp);
    }
}

<?php

namespace App\Providers;

use App\Nova\Meeting;
use Wdelfuego\NovaCalendar\CalendarDay;
use Wdelfuego\NovaCalendar\DataProvider\MonthCalendar;
use Wdelfuego\NovaCalendar\Event;
use App\Nova\User;

class CalendarDataProvider extends MonthCalendar
{
    //
    // Add the Nova resources that should be displayed on the calendar to this method
    //
    // Must return an array with string keys and string or array values;
    // - each key is a Nova resource class name (eg: 'App/Nova/User::class')
    // - each value is either:
    //
    //   1. a string containing the attribute name of a DateTime casted attribute
    //      of the underlying Eloquent model that will be used as the event's
    //      starting date and time (eg.: 'created_at')
    //
    //      OR
    //
    //   2. an array containing two strings; the first is the name of the attribute
    //      that will be used as the event's starting date and time (eg.: 'starts_at'),
    //      the second will be used as the event's ending date and time (eg.: 'ends_at').
    //
    // See https://github.com/wdelfuego/nova-calendar to find out
    // how to customize the way the events are displayed
    //
    public function novaResources() : array
    {
        return [

            // Events without an ending timestamp will always be shown as single-day events:
            Meeting::class => ['inicio', 'termino']

            // Events with an ending timestamp can be multi-day events:
            // SomeResource::class => ['starts_at', 'ends_at'],
        ];
    }

    // Use this method to show events on the calendar that don't
    // come from a Nova resource. Just return an array of dynamically
    // generated events.
    protected function nonNovaEvents() : array
    {
        return [];
    }

    protected function customizeCalendarDay(CalendarDay $day) : CalendarDay
    {
        if($day->start->format('w')  == 3)
        {
            $day->addBadge('❗CEL Carlos Zica❗');
        }

        return $day;
    }

    protected function customizeEvent(Event $event) : Event
    {
        if($event->model())
        {
            $event->name($event->model()->solicitante . ' / Sala: ' . $event-> model()->sala);
            $event->notes($event->model()->inicio->format('H:i') . ' - ' . $event->model()->termino->format('H:i'));
        }
        return $event;
    }
}
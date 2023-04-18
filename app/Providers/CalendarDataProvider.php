<?php

namespace App\Providers;

use App\Nova\Meeting;
use Carbon\Carbon;
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
        $startDate = '2023/04/05';
        $endDate = '2023/12/28';

        $endDate = strtotime($endDate);
        $quartas = [];

        for($i = strtotime('Wednesday', strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i)){
            $newYear = new Carbon($i);
            $quartas[] = (new Event("CEL Zica", $newYear))
                ->addBadges('<pr style="background-color: transparent; color: white; border-radius: 5px; padding: 3.5px; font-weight: bold">Sala da STI 💻</pr>')
                ->withNotes('08:00 - 12:00')
                ->withStyle('sti');
        }
        return $quartas;
    }

    protected function customizeEvent(Event $event) : Event
    {
        if($event->model())
        {
            if($event->model()->sala === 'sti') {
                $event->name($event->model()->solicitante);
                $event->notes($event->model()->inicio->format('H:i') . ' - ' . $event->model()->termino->format('H:i'));
                $event->addBadge('<pr style="background-color: transparent; color: white; border-radius: 5px; padding: 3.5px; font-weight: bold">Sala da STI 💻</pr>');
                $event->addStyle('sti');
            }

            elseif($event->model()->sala === 'comando') {
                $event->name($event->model()->solicitante);
                $event->notes($event->model()->inicio->format('H:i') . ' - ' . $event->model()->termino->format('H:i'));
                $event->addBadge('<pr style="background-color: transparent; color: white; border-radius: 5px; padding: 3.5px; font-weight: bold">Sala do Comando ✈️</pr>');
                $event->addStyle('comando');
            }

            else {
                $event->name($event->model()->solicitante);
                $event->notes($event->model()->inicio->format('H:i') . ' - ' . $event->model()->termino->format('H:i'));
                $event->addBadge('<pr style="background-color: transparent; color: white; border-radius: 5px; padding: 3.5px; font-weight: bold">'. $event->model()->outro . ' 📌' . '</pr>');
                $event->addStyle('outro');

            }

        }
        return $event;
    }

    public function eventStyles() : array
    {
        return [
            'sti' => [
                'color' => 'white',
                'background-color' => 'darkorange'
                ],
            'comando' => [
                'color' => 'white',
                'background-color' => 'darkblue'
                ],
            'outro' => [
                'color' => 'white',
                'background-color' => 'darkmagenta'
                ]
            ];
    }
}

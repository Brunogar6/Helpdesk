<?php

namespace App\Nova;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Devpartners\AuditableLog\AuditableLog;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use NormanHuth\IframePopup\IframePopup;

class Meeting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Meeting>
     */
    public static $model = \App\Models\Meeting::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'solicitante';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Solicitante', 'solicitante'),
            Select::make('Sala da Reunião', 'sala')->options([
                'sti' => 'STI',
                'comando' => 'Comando',
                'outro' => 'Outro'
            ]),
            DependencyContainer::make([
                Text::make('Local da Reunião', 'outro')
            ])->dependsOn('sala', 'outro'),
            Textarea::make('Observações', 'observacoes'),
            DateTime::make('Início', 'inicio')->hideFromIndex(),
            DateTime::make('Término', 'termino')->hideFromIndex(),
            IframePopup::make('', 'url',  function () {
                return 'http://localhost:8081/nova/wdelfuego/nova-calendar';
            })->icon('')->sufText('Reuniões')->hideFromIndex()->hideFromDetail(),


            AuditableLog::make()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function label()
    {
        return 'Reuniões';
    }
}

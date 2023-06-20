<?php

namespace App\Nova;

use App\Nova\Actions\DevolverEquipamento;
use Devpartners\AuditableLog\AuditableLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Lending extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Lending>
     */
    public static $model = \App\Models\Lending::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
            Text::make('Ramal', 'ramal')->hideFromIndex(),
            Text::make('Seção', 'secao')->hideFromIndex(),
            BelongsTo::make('equipment'),
            Date::make('Data de Emprestimo', 'inicio')->hideFromIndex(),
            Date::make('Data de Devolução Prevista', 'previsto'),
            Date::make('Data de Devolução', 'fim')->hideWhenCreating(),
            Boolean::make('Devolvido', 'devolvido')
                ->hideWhenCreating(),

            Textarea::make('Observações', 'observacoes'),

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
        return [
            new DevolverEquipamento()
        ];
    }

    public static function afterCreate(NovaRequest $request, Model $model)
    {

        $equipament = \App\Models\Equipment::find($model->equipment_id);

        $equipament->emprestado = True;
        $equipament->save();
    }

    public static function relatableEquipment(NovaRequest $request, $query)
    {
        return $query->where('emprestado', false);

    }

    public static function label()
    {
        return 'Emprestimos';
    }

}

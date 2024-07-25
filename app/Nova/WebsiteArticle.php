<?php

namespace App\Nova;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Jacobfitzp\NovaTinymce\Tinymce;
use Laravel\Nova\Http\Requests\NovaRequest;

class WebsiteArticle extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\WebsiteArticle>
     */
    public static $model = \Atom\Core\Models\WebsiteArticle::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'short_story',
        'full_story',
        'user.username',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:website_articles,title')
                ->updateRules('unique:website_articles,title,{{resourceId}}'),

            Image::make('Image')
                ->hideFromIndex()
                ->disk('public')
                ->path('website-articles')
                ->prunable()
                ->creationRules('required')
                ->updateRules('nullable'),

            Text::make('Short Story')
                ->sortable()
                ->rules('required', 'max:255'),

            Tinymce::make('Full Story')
                ->fullWidth(),

            BelongsTo::make('User', 'user', User::class)
                ->sortable()
                ->searchable()
                ->default($request->user()->id),

            Boolean::make('Can Comment')
                ->sortable()
                ->trueValue(1)
                ->falseValue(0)
                ->default(1),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}

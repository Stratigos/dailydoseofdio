<?php
/*****************************************************************************
* Renders a search input that uses www.duckduckgo.com to perform a seach
*   of dailydoseofdio.com's content.
* @see https://duckduckgo.com/params
******************************************************************************/
namespace frontend\widgets;

use frontend\widgets\Portlet;
use yii\helpers\Html;

class DuckDuckGoSearchPortlet extends Portlet
{
    public $title = 'Search for a Dose';

    public $htmlOptions = ['class' => 'portlet well'];

    /**
     * Displays the Seach input field
     */
    protected function renderContent()
    {
        $srchFrm = Html::beginForm(
            'https://www.duckduckgo.com/',
            'get',
            [
                'target' => '_blank',
                'id'     => 'ddg-search-form'
            ]
        );
            $srchFrm .= Html::beginTag('div', ['class' => 'input-group']);
                $srchFrm .= Html::hiddenInput('ka', 'h'); // link-font
                $srchFrm .= Html::hiddenInput('kn', '1'); // open links in new window
                $srchFrm .= Html::hiddenInput('kt', 'Helvetica'); // text font
                $srchFrm .= Html::hiddenInput('kae', 'd'); // theme (d = dark theme)
                $srchFrm .= Html::hiddenInput('sites', 'dailydoseofdio.com');
                $srchFrm .= Html::input(
                    'text',
                    'q',
                    null,
                    [
                        'placeholder' => 'Search with DuckDuckGo',
                        'maxlength'   => '255',
                        'class'       => 'form-control'
                    ]
                );
                $srchFrm .= Html::beginTag('span', ['class' => 'input-group-btn']);
                    $srchFrm .= Html::beginTag(
                        'button',
                        [
                            'id'    => 'ddgsearchbtn',
                            'class' => 'btn btn-default',
                            'type'  => 'button'
                        ]
                    );
                        $srchFrm .= Html::tag('span', '', ['class' => 'glyphicon glyphicon-search']);
                    $srchFrm .= Html::endTag('button');
                $srchFrm .= Html::endTag('span');
            $srchFrm .= Html::endTag('div');
        $srchFrm .= Html::endForm();

        echo $srchFrm;

        return;
    } 
}

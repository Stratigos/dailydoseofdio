<?php
/*********************************************************
* Renders a block of text for displaying a Quote
*   TODO: Add cache to store selected Quote for 1 day
**********************************************************/
namespace frontend\widgets;

use frontend\widgets\Portlet;

class DailyQuotePortlet extends Portlet
{
    public $title = 'Daily Dram';

    /**
     * Displays the Quote
     */
    protected function renderContent()
    {
        echo 'Daily Dio Quote Here!';
        return;
    } 
}

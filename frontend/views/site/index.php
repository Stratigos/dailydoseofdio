<?php
    use frontend\widgets\AdSidebar;
    use frontend\widgets\DailyDosePortlet;
    use frontend\widgets\DailyQuotePortlet;
    use frontend\widgets\DuckDuckGoSearchPortlet;
    use frontend\widgets\SocialSidebar;
    use yii\helpers\Html;
    use yii\widgets\ListView;
?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <div class="well well-sm text-center">
                <div class="page-header">
                    <h1>Daily Dose of Dio</h1>
                    <h4>Dedicated to the music, poetry, and life<br/>of Ronnie James Dio</h4>
                </div>
            </div>
            <?= ListView::widget([
                'dataProvider' => $postsDP,
                'itemView'     => '@frontend/views/_partials/postDefault.php',
                'emptyText'    => 'No Doses found.',
                'separator'    => Html::tag('hr'),
                'summary'      => ''
            ]); ?>
            <br />
            <p>            
                <a
                    class="btn btn-primary"
                    href="<?= $archiveUrl ?>"
                >More Doses <span class="glyphicon glyphicon-chevron-right"></span></a>
            </p>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">
            <!-- Side Widget Wells -->
            <?= DuckDuckGoSearchPortlet::widget() ?>
            <?= SocialSidebar::widget() ?>
            <?= AdSidebar::widget() ?>
            <?= DailyQuotePortlet::widget() ?>
            <div class="well">
                <h4>Some Widget Text to Read</h4>
                <p>
                    Shoulder in doner, rump ribeye swine labore kevin landjaeger pork frankfurter fatback dolor veniam
                    prosciutto. Dolore anim magna aute. Chuck jerky brisket pastrami beef excepteur frankfurter.
                    Pastrami sunt ball tip non pariatur shankle. Ut ham prosciutto pork belly lorem in pig. Eu officia
                    nulla, pastrami landjaeger jowl ground round chuck spare ribs minim adipisicing ut andouille\
                    tri-tip. Fatback pork belly meatball laborum andouille.
                </p>
            </div>
            <?= DailyDosePortlet::widget() ?>

        </div>

    </div>
    <!-- /.row -->

    <hr>

</div>
<!-- /.container -->
<?php
    use frontend\widgets\DailyQuotePortlet;
    use frontend\widgets\DuckDuckGoSearchPortlet;
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
            <?= DuckDuckGoSearchPortlet::widget() ?>
            <div class="well">
                <h4>Search for a Dose</h4>
                <form method="get" target="_blank" id="search" action="http://duckduckgo.com/">
                    <div class="input-group">
                        <input type="hidden" name="ka" value="h"/>
                        <input type="hidden" name="kn" value="1"/>
                        <input type="hidden" name="kt" value="Helvetica"/>
                        <input type="hidden" name="kae" value="d"/>
                        <input type="hidden" name="sites" value="dailydoseofdio.com"/>
                        <input
                            class="form-control"
                            type="text"
                            name="q"
                            maxlength="255"
                            placeholder="Powered by DuckDuckGo"
                        />
                        <!-- <input type="submit" value="DuckDuckGo Search" style="visibility: hidden;" /> -->
                        <span class="input-group-btn">
                            <button id="ddgsearchbtn" class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </form> 
            </div>

            <!-- Blog Categories Well -->
            <div class="well">
                <h4>Doses by Category</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
            </div>

            <!-- Side Widget Well -->
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

        </div>

    </div>
    <!-- /.row -->

    <hr>

</div>
<!-- /.container -->
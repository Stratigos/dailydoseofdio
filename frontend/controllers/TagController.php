<?php
/*******************************************************
* Renders views related to Tags and Posts within a Tag
********************************************************/
namespace frontend\controllers;

use common\models\Tag;
use frontend\dataproviders\TagPostsDataProvider;
use yii\web\HttpException;

class TagController extends FrontendController
{
    /**
     * Load and display a list of Posts for a given Tag
     * @return VOID
     */
    public function actionTag($shortname)
    {
        $tag = Tag::find()->where([
            'deleted_at' => 0,
            'shortname'  => $shortname
        ])->one();

        if (!$tag) {
            throw new HttpException(404, 'No such tag.');
        }

        $tagPostsDP = new TagPostsDataProvider(['tag_id' => $tag->id]);

        return $this->render(
            'tag',
            [
                'tag'     => $tag,
                'postsDP' => $tagPostsDP
            ]
        );
    }
}

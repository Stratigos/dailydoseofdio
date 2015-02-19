<?php
/****************************
* View a Post (a "dose")
* @see ArchiveController
*****************************/
namespace frontend\controllers;

use common\models\Post;

class PostController extends FrontendController
{
    /**
     * View a dose of Dio
     * Some vars/properties are formed within the controller action
     *  to leverage controller action caching.
     * @return VOID
     */
    public function actionView($shortname)
    {
        if(!($post = Post::find()->published()->andWhere(['shortname' => $shortname])->one())) {
            throw new HttpException(404, 'No dose found.');
        }
        $date = date(Post::DATE_FORMAT, $post->published_at);

        return $this->render(
            'view',
            [
                'post' => $post,
                'date' => $date
            ]
        );
    }
}

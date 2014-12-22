<?php
/***************************
* CRUD operations for Posts
****************************/
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\dataproviders\PostControllerIndexDataProvider;
use backend\dataproviders\PostControllerRelationalContentDataProvider;
use backend\models\PostMediaFactory;
use common\models\Category;
use common\models\Blog;
use common\models\Blogger;
use common\models\Tag;
use common\models\PostTag;
use common\models\Post;
use common\models\Quote;
use common\models\User;

class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow'   => true,
                        'roles'   => ['@']
                    ],
                    [
                        'actions' => ['selectmediatype', 'create', 'index', 'update'],
                        'allow'   => true,
                        'roles'   => ['author']
                    ],
                    [
                        'actions' => ['delete'],
                        'allow'   => true,
                        'roles'   => ['admin']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new HttpException(403, "Invalid authorization for this action.");
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    /**
     * render inventory as list of Posts
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'createPostUrl'     => Yii::$app->urlManager->createUrl('post/selectmediatype'),
                'postsDataProvider' => new PostControllerIndexDataProvider()
            ]
        );
    }


    /**
     * render a view of a Post's data
     * @param Int $id
     *  valid posts.id value
     */
    public function actionView($id)
    {
        $post = Post::find()->where('id = :_id', [':_id' => $id])->one();

        if($post === NULL) {
            throw new HttpException(404, "Post {$id} Not Found");
        }

        return $this->render(
            'view',
            [
                'indexUrl' => Yii::$app->urlManager->createUrl('post/index'),
                'post'     => $post
            ]
        );
    }

    /**
     * select Post's media type (Quote, Video, Image, Text) before creating
     */
    public function actionSelectmediatype()
    {
        return $this->render(
            'media_type',
            ['post_media_types' => Post::getMediaTypes()]
        );
    }

    /**
     * create a new Post record
     * @param Int $media_type
     *  valid posts.type_id value (@see Post::getMediaTypes())
     */
    public function actionCreate($media_type)
    {
        $post_media_types = Post::getMediaTypes();
        if(!array_key_exists($media_type, $post_media_types)) {
            throw new HttpException(404, 'Invalid Post Media Type.');
        }

        $post_media         = NULL;
        $post_tags          = '';
        $media_type_partial = '';
        $errors             = [];
        $rel_content_dp     = new PostControllerRelationalContentDataProvider();
        $post               = new Post();

        // load Post defaults, relational/taxonomic entities, and load
        //  additional media partial, if needed
        $post->loadDefaultValues();
        $post->type_id      = $media_type;
        $relational_content = $rel_content_dp->formattedContent;
        $post_media         = PostMediaFactory::instantiatePostMedia($post->getMediaTypeName());

        if(Yii::$app->request->isPost) {
            $post_request_data = Yii::$app->request->post();
            $post->load($post_request_data);
            // load Post's media instance here, to preserve form data on error
            if(isset($post_media)) {
                $post_media->load($post_request_data);
            }
            // Set the Post's published_at from a datetimepicker value.
            if( isset($post_request_data['post_published_at_string']) &&
                !empty($post_request_data['post_published_at_string'])
            ) {
                $post->published_at = strtotime($post_request_data['post_published_at_string']);
            }
            // set current User as author
            $post->created_by = Yii::$app->user->id;
            if($post->save()) {
                // check for any media, and save relation to Post
                if($post->type_id && isset($post_media)) {
                    $post_media->post_id = $post->id;
                    if(!$post_media->save()) {
                        $errors[$post_media->className()] = $post_media->getErrors();
                    }
                }
                if(!empty($errors)) {
                    Yii::$app->session->setFlash('success', "Post: {$post->id} created!");
                    return $this->redirect(
                        Yii::$app->urlManager->createUrl(
                            [
                                'post/update',
                                'id'     => $post->id,
                                'errors' => $errors
                            ]
                        )
                    );
                }
                return $this->redirect(['index']);
            } else {
                $errors[] = $post->getErrors();
            }
        }
        
        return $this->render(
            'create',
            [
                'categories' => $relational_content['categories'],
                'blogs'      => $relational_content['blogs'],
                'bloggers'   => $relational_content['bloggers'],
                'tags'       => $relational_content['tags'],
                'post'       => $post,
                'post_tags'  => $post_tags,
                'post_media' => $post_media,
                'errors'     => $errors
            ]
        );
    }

    /**
     * Edit an existing Post record. Current User must have the "updateOwnPost"
     *  permission to perform this Action.
     * @param Int $id
     *  valid posts.id value.
     * @param Array $create_errors
     *  Array of errors from actionCreate() that occurred while
     *  saving the original Post or its relational objects.
     */
    public function actionUpdate($id, $create_errors = NULL)
    {
        $post = Post::find()->where('id = :_id', [':_id' => $id])->one();
        if(empty($post)) {
            throw new HttpException(404, "Post {$id} Not Found");
        }
        if(!Yii::$app->user->can('updatePost', ['post' => $post])) {
            throw new HttpException(403, "You must be the author of this Post.");
        }
        $post_tags      = '';
        $rel_content_dp = new PostControllerRelationalContentDataProvider();
        
        $post_media     = $post ? $post->media : NULL;
        $errors         = (isset($create_errors) && is_array($create_errors) && !empty($create_errors)) ?
            $create_errors :
            []
        ;
        $relational_content = $rel_content_dp->formattedContent;
        // load Tags associated with Post
        if(!empty($post->tags)) {
            $post_tags = ArrayHelper::map($post->tags, 'id', 'name');
            $post_tags = implode(',', $post_tags);
        }

        if(Yii::$app->request->isPost) {
            $post_request_data = Yii::$app->request->post();
            $post->load($post_request_data);
            // Set the Post's published_at from a datetimepicker value.
            if( isset($post_request_data['post_published_at_string']) &&
                !empty($post_request_data['post_published_at_string'])
            ) {
                $post->published_at = strtotime($post_request_data['post_published_at_string']);
            }
            if($post->save()) {
                // check for any media, and save relation to Post
                if($post->type_id && isset($post_media)) {
                    $post_media->load($post_request_data);
                    $post_media->post_id = $post->id;
                    if(!$post_media->save()) {
                        $errors[$post_media->className()] = $post_media->getErrors();
                    }
                }
                // if everything saved correctly, refresh current page
                if(empty($errors)) {
                    Yii::$app->session->setFlash('success', "Post: {$post->id} updated!");
                    return $this->refresh();
                }
            } else {
                $errors = array_merge($errors, $post->getErrors());
            }
        }

        return $this->render(
            'update',
            [
                'categories' => $relational_content['categories'],
                'blogs'      => $relational_content['blogs'],
                'bloggers'   => $relational_content['bloggers'],
                'tags'       => $relational_content['tags'],
                'post'       => $post,
                'authorname' => User::findIdentity($post->created_by)->username,
                'post_tags'  => $post_tags,
                'post_media' => $post_media,
                'errors'     => $errors
            ]
        );
    }

    /**
     * soft delete a Post record
     * @param Int $id
     *  valid posts.id value
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($post = Post::find()->where('id = :_id', [':_id' => $id])->one()) {
            $post->deleted_at = time();
            if($post->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting post: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate post: {$id}";
        // }

        // display errors
    }
}

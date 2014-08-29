<?php
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use common\models\Category;
use common\models\Blog;
use common\models\Blogger;
use common\models\Tag;
use common\models\PostTag;
use common\models\Post;
use common\models\Quote;

/**
 * CRUD operations for Posts
 */
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
                        'actions' => ['view', 'selectmediatype', 'create', 'index', 'update', 'delete'],
                        'allow'   => true,
                        'roles'   => ['@']
                    ]
                ]
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
        $postsDataProvider = new ActiveDataProvider([
            'pagination' => ['pageSize' => 50],
            'query'      => Post::find()->where(['deleted_at' => 0])->orderBy(
                [
                    'published_at' => SORT_DESC,
                    'created_at'   => SORT_DESC
                ]
            )
        ]);

        return $this->render(
            'index',
            [
                'createPostUrl'     => Yii::$app->urlManager->createUrl('post/selectmediatype'),
                'postsDataProvider' => $postsDataProvider
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
                'indexUrl' => Yii::$app->urlManager->createUrl('post/selectmediatype'),
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
            throw new HttpException(404, "Invalid Post Media Type.");
        }

        $post_media         = null;
        $post_tags          = '';
        $media_type_partial = '';
        $errors             = [];
        $categories         = Category::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
        $blogs              = Blog::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC])->all();
        $bloggers           = Blogger::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
        $tags               = Tag::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
        $post               = new Post();

        // load Post defaults, and load additional media partial, if needed
        $post->loadDefaultValues();
        $post->type_id = $media_type;

        // load the Quote, Video, or Image partial-form, if appropriate type
        if($_type = $post->getMediaTypeName()) {
            $_classname         = 'common\\models\\' . ucfirst($_type);
            $post_media         = new $_classname;
            $media_type_partial = "_post_{$_type}_form";
        }

        // create array of relational datatypes' id => name/title for <select>
        $categories = ArrayHelper::map($categories, 'id', 'name');
        $blogs      = ArrayHelper::map($blogs, 'id', 'title');
        $bloggers   = ArrayHelper::map($bloggers, 'id', 'name');
        array_unshift($categories, 'None');
        array_unshift($blogs, 'None');
        array_unshift($bloggers, 'None');

        if(Yii::$app->request->isPost) {
            $post_request_data = Yii::$app->request->post();
            $post->load($post_request_data);
            // Set the Post's published_at from a datetimepicker value.
            if( isset($post_request_data['post_published_at_string']) &&
                !empty($post_request_data['post_published_at_string'])
            ) {
                $post->published_at = strtotime($post_request_data['post_published_at_string']);
            }
            // Save any Tags added to Post
            if( isset($post_request_data['post_tag_names_selected']) &&
                !empty($post_request_data['post_tag_names_selected'])
            ) {
                $post_tags_array = explode(',', $post_request_data['post_tag_names_selected']);
                if(!empty($post_tags_array)) {
                    foreach($post_tags_array as $tag_name) {
                        $tag = Tag::find()->where('name = :_name', [':_name' => $tag_name])->one();
                        if($tag) {
                            $post_tag          = new PostTag();
                            $post_tag->post_id = $post->id;
                            $post_tag->tag_id  = $tag->id;
                            if(!$post_tag->save()) {
                                $errors = array_merge($errors, $post_tag->getErrors());
                            }
                        }
                    }
                }
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
                if(!empty($errors)) {
                    return $this->redirect(
                        Yii::$app->urlManager->createUrl(
                            ['post/update', 'id' => $post->id]
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
                'categories'         => $categories,
                'blogs'              => $blogs,
                'bloggers'           => $bloggers,
                'tags'               => $tags,
                'post'               => $post,
                'post_tags'          => $post_tags,
                'post_media'         => $post_media,
                'errors'             => $errors,
                'media_type_partial' => $media_type_partial
            ]
        );
    }

    /**
     * edit an existing Post record
     * @param Int $id
     *  valid posts.id value
     */
    public function actionUpdate($id)
    {

        $post_media         = null;
        $media_type_partial = '';
        $post_tags          = '';
        $errors             = [];
        $categories         = Category::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
        $blogs              = Blog::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC])->all();
        $bloggers           = Blogger::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
        $tags               = Tag::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
        $post               = Post::find()->where('id = :_id', [':_id' => $id])->one();

        if($post === NULL) {
            throw new HttpException(404, "Post {$id} Not Found");
        }
        // load Tags associated with Post
        if(!empty($post->tags)) {
            $post_tags = ArrayHelper::map($post->tags, 'id', 'name');
            $post_tags = implode(',', $post_tags);
        }
        // load the Quote, Video, or Image, if appropriate type
        if($_type = $post->getMediaTypeName()) {
            $post_media         = $post->media;
            $media_type_partial = "_post_{$_type}_form";
        }

        $categories = ArrayHelper::map($categories, 'id', 'name');
        $blogs      = ArrayHelper::map($blogs, 'id', 'title');
        $bloggers   = ArrayHelper::map($bloggers, 'id', 'name');
        array_unshift($categories, 'None');
        array_unshift($blogs, 'None');
        array_unshift($bloggers, 'None');

        if(Yii::$app->request->isPost) {
            $post_request_data = Yii::$app->request->post();
            $post->load($post_request_data);
            // Set the Post's published_at from a datetimepicker value.
            if( isset($post_request_data['post_published_at_string']) &&
                !empty($post_request_data['post_published_at_string'])
            ) {
                $post->published_at = strtotime($post_request_data['post_published_at_string']);
            }
            // Set all of the Post's Tags
            if(!empty($post->postTags)) {
                foreach($post->postTags as $postTag) {
                    $postTag->delete();
                }
            }
            if( isset($post_request_data['post_tag_names_selected']) &&
                !empty($post_request_data['post_tag_names_selected'])
            ) {
                $post_tags_array = explode(',', $post_request_data['post_tag_names_selected']);
                if(!empty($post_tags_array)) {
                    foreach($post_tags_array as $tag_name) {
                        $tag = Tag::find()->where('name = :_name', [':_name' => $tag_name])->one();
                        if($tag) {
                            $post_tag          = new PostTag();
                            $post_tag->post_id = $post->id;
                            $post_tag->tag_id  = $tag->id;
                            if(!$post_tag->save()) {
                                $errors = array_merge($errors, $post_tag->getErrors());
                            }
                        }
                    }
                }
            }
            if($post->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = array_merge($errors, $post->getErrors());
            }
        }

        return $this->render(
            'update',
            [
                'categories'         => $categories,
                'blogs'              => $blogs,
                'bloggers'           => $bloggers,
                'tags'               => $tags,
                'post'               => $post,
                'post_tags'          => $post_tags,
                'post_media'         => $post_media,
                'errors'             => $errors,
                'media_type_partial' => $media_type_partial
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

<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Blogger;
use common\models\UploadForm;
use Aws\S3\S3Client;


/**
 * CRUD operations for Bloggers
 */
class BloggerController extends Controller
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
                        'actions' => ['create', 'index', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
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
     * render inventory as list of Bloggers
     */
    public function actionIndex()
    {
        $bloggersDataProvider = new ActiveDataProvider([
            'query'      => Blogger::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]),
            'pagination' => ['pageSize' => 10]
        ]);

        return $this->render(
            'index',
            [
                'createBloggerUrl'     => Yii::$app->urlManager->createUrl('blogger/create'),
                'bloggersDataProvider' => $bloggersDataProvider
            ]
        );
    }

    /**
     * create a new Blogger record
     */
    public function actionCreate()
    {
        $errors  = [];
        $image   = new UploadForm();
        $blogger = new Blogger();
        $blogger->loadDefaultValues();

        if(Yii::$app->request->isPost) {
            $blogger->load(Yii::$app->request->post());
            $image->image = UploadedFile::getInstance($image, 'image');
            if(!empty($image) && $image->validate()) {
                $image->image->saveAs('uploads/' . $image->image->baseName . '.' . $image->image->extension);
                $blogger->image = 'uploads/' . $image->image->baseName . '.' . $image->image->extension;
            }
            if($blogger->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $blogger->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'blogger' => $blogger,
                'image'   => $image,
                'errors'  => $errors
            ]
        );
    }

    /**
     * edit an existing Blogger record
     */
    public function actionUpdate($id)
    {
        $blogger = Blogger::find()->where('id = :_id', [':_id' => $id])->one();
        $image   = new UploadForm();
        $errors  = [];

        if($blogger === NULL) {
            throw new HttpException(404, "Blogger {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $blogger->load(Yii::$app->request->post());
            /**
             * @todo MOVE TO UPLOADABLEIMAGEBEHAVIOR::UPLOADIMAGE();
             */
            // ////////////// IMAGE UPLOAD TO S3 SEQUENCE //////////////////////////////////////////////////////////////
            $image->image = UploadedFile::getInstance($image, 'image');
            if(!empty($image) && $image->validate()) {
                // create local file
                $uploaded     = null;
                $filename     = null;
                $dirname      = 'uploads/' . substr($blogger->className(), (strrpos($blogger->className(), '\\') + 1));
                $full_dirname = getcwd() . '/' . $dirname;
                if(!file_exists($full_dirname) && !is_dir($full_dirname)) {
                    error_log("\n\n TRYING TO MAKE DIR: {$full_dirname} \n\n");
                    mkdir($full_dirname, 0774);         
                } 
                if(is_dir($full_dirname)) {
                    $filename = $dirname . '/' . 
                        md5($blogger->id) . '-' . $image->image->baseName . '.' . $image->image->extension
                    ;
                    if($image->image->saveAs($filename)) {
                        // upload the file locally
                        $full_filename = getcwd() . '/' . $filename;
                        if(file_exists($full_filename)) {
                            $client = S3Client::factory(
                                [
                                    'key'    => getenv('AWS_ACCESS_KEY_ID'),
                                    'secret' => getenv('AWS_SECRET_ACCESS_KEY')
                                ]
                            );
                            $uploaded = $client->putObject(
                                [
                                    'Bucket'     => 'ddoddev',
                                    'Key'        => $filename,
                                    'SourceFile' => $full_filename,
                                    'ACL'        => 'public-read'
                                ]
                            );
                            // save the image's path to the Blogger instance, and delete local file
                            if(!empty($uploaded) && isset($uploaded['ObjectURL']) && !empty($uploaded['ObjectURL'])) {
                                $blogger->image_path = $filename;
                                unlink($full_filename);
                            }
                        } else {
                            error_log("\n\n SOMETHING IS FUCKED WITH ACCESSING FULL FILENAME {$full_filename} \n\n");
                        }
                    } else {
                        // add to model's errors
                        error_log("\n\n SOMETHIGN IS FUCKED WITH SAVING AN IMAGE LOCALLY {$filename} \n\n");
                    }
                } else {
                    // add to model's errors
                    error_log("\n\n SOMETHING IS FUCKED WITH MAKING A LOCAL DIR: {$full_dirname} \n\n");
                }
            }
            // ////////////////// END IMAGE UPLOAD SEQUENCE ////////////////////////////////////////////////////////
            if($blogger->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $blogger->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'blogger' => $blogger,
                'image'   => $image,
                'errors'  => $errors
            ]
        );
    }

    /**
     * soft delete a Blogger record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($blogger = Blogger::find()->where('id = :_id', [':_id' => $id])->one()) {
            $blogger->deleted_at = time();
            if($blogger->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting blogger: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate blogger: {$id}";
        // }

        // display errors
    }
}

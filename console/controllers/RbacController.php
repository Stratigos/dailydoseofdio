<?php
/*****************************************************************************
* RBAC for DDOD
******************************************************************************/
namespace console\controllers;

use Yii;
use common\models\User;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * Selects the two users created in the 'seed' migration, creates the
     *  permissions, then the roles, and assigns roles to each User.
     * @see http://www.yiiframework.com/doc-2.0/guide-security-authorization.html
     */ 
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $userTodd = User::find()->where(['username' => 'toddmorningstar'])->one();
        $userLucy = User::find()->where(['username' => 'lucyappleschen'])->one();

        if($userTodd && $userLucy) {
            echo("\n  USERS FOUND, CREATING RBAC SYSTEM...\n");
            // PERMISSIONS ////////////////////////////////////////////////////////

            // Blogs
            $createBlog              = $auth->createPermission('createBlog');
            $createBlog->description = 'Create Blog';
            $auth->add($createBlog);

            $updateBlog              = $auth->createPermission('updateBlog');
            $updateBlog->description = 'Update Blog';
            $auth->add($updateBlog);

            $updateBlog              = $auth->createPermission('viewBlog');
            $updateBlog->description = 'View Blog';
            $auth->add($updateBlog);

            $updateBlog              = $auth->createPermission('deleteBlog');
            $updateBlog->description = 'Delete Blog';
            $auth->add($updateBlog);

            // Bloggers
            $createBlogger              = $auth->createPermission('createBlogger');
            $createBlogger->description = 'Create Blogger';
            $auth->add($createBlogger);

            $updateBlogger              = $auth->createPermission('updateBlogger');
            $updateBlogger->description = 'Update Blogger';
            $auth->add($updateBlogger);

            $updateBlogger              = $auth->createPermission('viewBlogger');
            $updateBlogger->description = 'View Blogger';
            $auth->add($updateBlogger);

            $updateBlogger              = $auth->createPermission('deleteBlogger');
            $updateBlogger->description = 'Delete Blogger';
            $auth->add($updateBlogger);

            // Categories
            $createCategory              = $auth->createPermission('createCategory');
            $createCategory->description = 'Create Category';
            $auth->add($createCategory);

            $updateCategory              = $auth->createPermission('updateCategory');
            $updateCategory->description = 'Update Category';
            $auth->add($updateCategory);

            $updateCategory              = $auth->createPermission('viewCategory');
            $updateCategory->description = 'View Category';
            $auth->add($updateCategory);

            $updateCategory              = $auth->createPermission('deleteCategory');
            $updateCategory->description = 'Delete Category';
            $auth->add($updateCategory);

            // Tags
            $createTag              = $auth->createPermission('createTag');
            $createTag->description = 'Create Tag';
            $auth->add($createTag);

            $updateTag              = $auth->createPermission('updateTag');
            $updateTag->description = 'Update Tag';
            $auth->add($updateTag);

            $updateTag              = $auth->createPermission('viewTag');
            $updateTag->description = 'View Tag';
            $auth->add($updateTag);

            $updateTag              = $auth->createPermission('deleteTag');
            $updateTag->description = 'Delete Tag';
            $auth->add($updateTag);

            // Posts
            $createPost              = $auth->createPermission('createPost');
            $createPost->description = 'Create Post';
            $auth->add($createPost);

            $updatePost              = $auth->createPermission('updatePost');
            $updatePost->description = 'Update Post';
            $auth->add($updatePost);

            $updatePost              = $auth->createPermission('viewPost');
            $updatePost->description = 'View Post';
            $auth->add($updatePost);

            $updatePost              = $auth->createPermission('deletePost');
            $updatePost->description = 'Delete Post';
            $auth->add($updatePost);

            // Pages
            $createPage              = $auth->createPermission('createPage');
            $createPage->description = 'Create Page';
            $auth->add($createPage);

            $updatePage              = $auth->createPermission('updatePage');
            $updatePage->description = 'Update Page';
            $auth->add($updatePage);

            $updatePage              = $auth->createPermission('viewPage');
            $updatePage->description = 'View Page';
            $auth->add($updatePage);

            $updatePage              = $auth->createPermission('deletePage');
            $updatePage->description = 'Delete Page';
            $auth->add($updatePage);

            // Dio Sites
            $createDioSite              = $auth->createPermission('createDioSite');
            $createDioSite->description = 'Create DioSite';
            $auth->add($createDioSite);

            $updateDioSite              = $auth->createPermission('updateDioSite');
            $updateDioSite->description = 'Update DioSite';
            $auth->add($updateDioSite);

            $updateDioSite              = $auth->createPermission('viewDioSite');
            $updateDioSite->description = 'View DioSite';
            $auth->add($updateDioSite);

            $updateDioSite              = $auth->createPermission('deleteDioSite');
            $updateDioSite->description = 'Delete DioSite';
            $auth->add($updateDioSite);

            // ROLES //////////////////////////////////////////////////////////////

            // creating "author" role and giving permission for almost everything 
            //  except modifying Pages and taxonomic records
            $author = $auth->createRole('author');
            $auth->add($author);
            $auth->addChild($author, $createPost);
            $auth->addChild($author, $updatePost);
            $auth->addChild($author, $viewPost);
            $auth->addChild($author, $deletePost);
            $auth->addChild($author, $createDioSite);
            $auth->addChild($author, $updateDioSite);
            $auth->addChild($author, $viewDioSite);
            $auth->addChild($author, $deleteDioSite);
            $auth->addChild($author, $viewPage);
            $auth->addChild($author, $viewBlog);
            $auth->addChild($author, $viewBlogger);
            $auth->addChild($author, $viewCategory);
            $auth->addChild($author, $createTag);
            $auth->addChild($author, $viewTag);

            // creating "admin" role which does everything "author" does
            //  and also everything else :)
            $admin = $auth->createRole('admin');
            $auth->add($admin);
            $auth->addChild($admin, $createPage);
            $auth->addChild($admin, $updatePage);
            $auth->addChild($admin, $deletePost);
            $auth->addChild($admin, $createBlog);
            $auth->addChild($admin, $updateBlog);
            $auth->addChild($admin, $deleteBlog);
            $auth->addChild($admin, $createBlogger);
            $auth->addChild($admin, $updateBlogger);
            $auth->addChild($admin, $deleteBlogger);
            $auth->addChild($admin, $createCategory);
            $auth->addChild($admin, $updateCategory);
            $auth->addChild($admin, $deleteCategory);
            $auth->addChild($admin, $updateTag);
            $auth->addChild($admin, $deleteTag);
            $auth->addChild($admin, $author);

            // ASSIGNMENTS

            // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
            // usually implemented in your User model.
            $auth->assign($author, $userLucy->id);
            $auth->assign($admin, $userTodd->id);

            echo("\n  FINISHED CREATING ROLES AND PERMISSIONS, AND ASSIGNING TO USERS.\n");
        } else {
            echo("\n  ERROR: UNABLE TO LOCATE SEEDED USERS! NO RBAC PERMISSIONS, ROLES, OR ASSIGNMENTS CREATED.\n");
            return 1;
        }
        echo("\n  END OF RBAC PROCEDURE.\n");
        return 0;
    }
}
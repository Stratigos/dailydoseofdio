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

            $viewBlog              = $auth->createPermission('viewBlog');
            $viewBlog->description = 'View Blog';
            $auth->add($viewBlog);

            $deleteBlog              = $auth->createPermission('deleteBlog');
            $deleteBlog->description = 'Delete Blog';
            $auth->add($deleteBlog);

            // Bloggers
            $createBlogger              = $auth->createPermission('createBlogger');
            $createBlogger->description = 'Create Blogger';
            $auth->add($createBlogger);

            $updateBlogger              = $auth->createPermission('updateBlogger');
            $updateBlogger->description = 'Update Blogger';
            $auth->add($updateBlogger);

            $viewBlogger              = $auth->createPermission('viewBlogger');
            $viewBlogger->description = 'View Blogger';
            $auth->add($viewBlogger);

            $deleteBlogger              = $auth->createPermission('deleteBlogger');
            $deleteBlogger->description = 'Delete Blogger';
            $auth->add($deleteBlogger);

            // Categories
            $createCategory              = $auth->createPermission('createCategory');
            $createCategory->description = 'Create Category';
            $auth->add($createCategory);

            $updateCategory              = $auth->createPermission('updateCategory');
            $updateCategory->description = 'Update Category';
            $auth->add($updateCategory);

            $viewCategory              = $auth->createPermission('viewCategory');
            $viewCategory->description = 'View Category';
            $auth->add($viewCategory);

            $deleteCategory              = $auth->createPermission('deleteCategory');
            $deleteCategory->description = 'Delete Category';
            $auth->add($deleteCategory);

            // Tags
            $createTag              = $auth->createPermission('createTag');
            $createTag->description = 'Create Tag';
            $auth->add($createTag);

            $updateTag              = $auth->createPermission('updateTag');
            $updateTag->description = 'Update Tag';
            $auth->add($updateTag);

            $viewTag              = $auth->createPermission('viewTag');
            $viewTag->description = 'View Tag';
            $auth->add($viewTag);

            $deleteTag              = $auth->createPermission('deleteTag');
            $deleteTag->description = 'Delete Tag';
            $auth->add($deleteTag);

            // Posts
            $createPost              = $auth->createPermission('createPost');
            $createPost->description = 'Create Post';
            $auth->add($createPost);

            $updatePost              = $auth->createPermission('updatePost');
            $updatePost->description = 'Update Post';
            $auth->add($updatePost);

            $viewPost              = $auth->createPermission('viewPost');
            $viewPost->description = 'View Post';
            $auth->add($viewPost);

            $deletePost              = $auth->createPermission('deletePost');
            $deletePost->description = 'Delete Post';
            $auth->add($deletePost);

            // Pages
            $createPage              = $auth->createPermission('createPage');
            $createPage->description = 'Create Page';
            $auth->add($createPage);

            $updatePage              = $auth->createPermission('updatePage');
            $updatePage->description = 'Update Page';
            $auth->add($updatePage);

            $viewPage              = $auth->createPermission('viewPage');
            $viewPage->description = 'View Page';
            $auth->add($viewPage);

            $deletePage              = $auth->createPermission('deletePage');
            $deletePage->description = 'Delete Page';
            $auth->add($deletePage);

            // Dio Sites
            $createDioSite              = $auth->createPermission('createDioSite');
            $createDioSite->description = 'Create DioSite';
            $auth->add($createDioSite);

            $updateDioSite              = $auth->createPermission('updateDioSite');
            $updateDioSite->description = 'Update DioSite';
            $auth->add($updateDioSite);

            $viewDioSite              = $auth->createPermission('viewDioSite');
            $viewDioSite->description = 'View DioSite';
            $auth->add($viewDioSite);

            $deleteDioSite              = $auth->createPermission('deleteDioSite');
            $deleteDioSite->description = 'Delete DioSite';
            $auth->add($deleteDioSite);

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
            $auth->addChild($admin, $author);
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
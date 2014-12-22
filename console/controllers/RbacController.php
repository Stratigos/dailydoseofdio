<?php
/*****************************************************************************
* RBAC for DDOD
******************************************************************************/
namespace console\controllers;

use Yii;
use backend\rbac\AuthorRule;
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

            // RULES //////////////////////////////////////////////////////////
            $authorRule = new AuthorRule;
            $auth->add($authorRule);

            // PERMISSIONS ////////////////////////////////////////////////////
            $updatePost              = $auth->createPermission('updatePost');
            $updatePost->description = 'Update Post';
            $auth->add($updatePost);

            $updateOwnPost              = $auth->createPermission('updateOwnPost');
            $updateOwnPost->description = 'Update Own Post';
            $updateOwnPost->ruleName    = $authorRule->name;
            $auth->add($updateOwnPost);

            // add "updateOwnPost" to "updatePost" Permission
            $auth->addChild($updateOwnPost, $updatePost);

            // ROLES //////////////////////////////////////////////////////////
            $author = $auth->createRole('author');
            $auth->add($author);
            $auth->addChild($author, $updateOwnPost);

            $admin = $auth->createRole('admin');
            $auth->add($admin);
            $auth->addChild($admin, $author);
            $auth->addChild($admin, $updatePost);

            // ASSIGNMENTS
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
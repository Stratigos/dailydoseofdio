<?php
/****************************************************************************************
* RBAC Rule to check if User is the author of a Post
*
* @see http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#using-rules
*****************************************************************************************/
namespace backend\rbac;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the User ID.
     * @param Item $item the associated Role or Permission.
     * @param array $params parameters passed to
     *  ManagerInterface::checkAccess().
     * @return Boolean a value indicating whether the Rule permits the Role or
     *  Permission with which it is associated.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['post']) ? $params['post']->created_by == $user : false;
    }
}

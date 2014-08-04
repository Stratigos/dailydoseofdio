<?php

use yii\db\Schema;
use common\models\User;

/**
 * Migration to initialize DDoD Web Application
 */
class m130524_201442_init extends \yii\db\Migration
{
    /**
     * creates the following tables:
     *  + pages
     *  + diosites
     *  + categories
     *  + tags
     *  + blogs
     *  + bloggers
     *  + users
     *  
     * creates the following instances/records:
     *  + user: admin 
     */
    public function up()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%posts}}',
            [
                'id'           => Schema::TYPE_PK,
                'type_id'      => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
                'category_id'  => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'blog_id'      => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'blogger_id'   => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'title'        => Schema::TYPE_STRING  . '(128) NOT NULL',
                'shortname'    => Schema::TYPE_STRING  . '(128) NOT NULL',
                'body'         => Schema::TYPE_TEXT    . ' DEFAULT NULL',
                'status'       => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
                'published_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'created_at'   => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'updated_at'   => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'deleted_at'   => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%pages}}',
            [
                'id'         => Schema::TYPE_PK,
                'title'      => Schema::TYPE_STRING  . '(64) NOT NULL',
                'shortname'  => Schema::TYPE_STRING  . '(32) NOT NULL',
                'body'       => Schema::TYPE_TEXT    . ' DEFAULT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'deleted_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%diosites}}',
            [
                'id'         => Schema::TYPE_PK,
                'title'      => Schema::TYPE_STRING  . '(64) NOT NULL',
                'url'        => Schema::TYPE_STRING  . '(2000) NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'deleted_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%tags}}',
            [
                'id'         => Schema::TYPE_PK,
                'name'       => Schema::TYPE_STRING  . '(32) NOT NULL',
                'shortname'  => Schema::TYPE_STRING  . '(32) NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'deleted_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%categories}}',
            [
                'id'                => Schema::TYPE_PK,
                'name'              => Schema::TYPE_STRING  . '(32) NOT NULL',
                'shortname'         => Schema::TYPE_STRING  . '(32) NOT NULL',
                'short_description' => Schema::TYPE_STRING  . '(255) DEFAULT NULL',
                'description'       => Schema::TYPE_STRING  . '(2000) DEFAULT NULL',
                'created_at'        => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'updated_at'        => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
                'deleted_at'        => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%blogs}}',
            [
                'id'                => Schema::TYPE_PK,
                'title'             => Schema::TYPE_STRING   . '(128) NOT NULL',
                'shortname'         => Schema::TYPE_STRING   . '(32) NOT NULL',
                'image'             => Schema::TYPE_STRING   . '(255) DEFAULT NULL',
                'short_description' => Schema::TYPE_STRING   . '(255) DEFAULT NULL',
                'description'       => Schema::TYPE_STRING   . '(2000) DEFAULT NULL',
                'keywords'          => Schema::TYPE_STRING   . '(2000) DEFAULT NULL',
                'rank'              => 'TINYINT(3) UNSIGNED NOT NULL DEFAULT 0',
                'status'            => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
                'created_at'        => Schema::TYPE_INTEGER  . ' UNSIGNED NOT NULL DEFAULT 0',
                'updated_at'        => Schema::TYPE_INTEGER  . ' UNSIGNED NOT NULL DEFAULT 0',
                'deleted_at'        => Schema::TYPE_INTEGER  . ' UNSIGNED NOT NULL DEFAULT 0'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%bloggers}}',
            [
                'id'                => Schema::TYPE_PK,
                'name'              => Schema::TYPE_STRING   . '(64) NOT NULL',
                'shortname'         => Schema::TYPE_STRING   . '(32) NOT NULL',
                'image'             => Schema::TYPE_STRING   . '(255) DEFAULT NULL',
                'short_description' => Schema::TYPE_STRING   . '(255) DEFAULT NULL',
                'description'       => Schema::TYPE_STRING   . '(2000) DEFAULT NULL',
                'dio_favorite'      => Schema::TYPE_STRING   . '(255) DEFAULT NULL',
                'rank'              => 'TINYINT(3) UNSIGNED NOT NULL DEFAULT 0',
                'status'            => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
                'created_at'        => Schema::TYPE_INTEGER  . ' UNSIGNED NOT NULL DEFAULT 0',
                'updated_at'        => Schema::TYPE_INTEGER  . ' UNSIGNED NOT NULL DEFAULT 0',
                'deleted_at'        => Schema::TYPE_INTEGER  . ' UNSIGNED NOT NULL DEFAULT 0'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%users}}',
            [
                'id'                   => Schema::TYPE_PK,
                'username'             => Schema::TYPE_STRING   . ' NOT NULL',
                'auth_key'             => Schema::TYPE_STRING   . '(32) NOT NULL',
                'password_hash'        => Schema::TYPE_STRING   . ' NOT NULL',
                'password_reset_token' => Schema::TYPE_STRING,
                'email'                => Schema::TYPE_STRING   . ' NOT NULL',
                'role'                 => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
                'status'               => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
                'created_at'           => Schema::TYPE_INTEGER  . ' NOT NULL DEFAULT 0',
                'updated_at'           => Schema::TYPE_INTEGER  . ' NOT NULL DEFAULT 0',
            ],
            $tableOptions
        );

        // create initial admin user
        $password       = 'admin';
        $user           = new User();
        $user->username = 'admin';
        $user->password = $password;
        $user->email    = 'dont@spam.me';
        try {
            $user->save();
        } catch(Exception $e) {
            echo("\n");
            echo($e->getMessage());
            echo("\n");
        }
        echo(
            "\n    New user with username: '{$user->username}' and password '{$password}' created." . 
            "\n    ~ !! After migrations finish, log in, and update this user with a secure password !! ~\n"
        );
    }

    public function down()
    {
        $this->dropTable('{{%posts}}');
        $this->dropTable('{{%pages}}');
        $this->dropTable('{{%diosites}}');
        $this->dropTable('{{%tags}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%blogs}}');
        $this->dropTable('{{%bloggers}}');
        $this->dropTable('{{%users}}');
    }
}

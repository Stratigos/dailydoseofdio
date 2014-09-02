<?php
use yii\db\Schema;
use yii\db\Migration;
use common\models\Category;
use common\models\Tag;
use common\models\Blog;
use common\models\Blogger;
use common\models\User;

/**
 * Migration to initialize DDoD Web Application
 */
class m130524_201442_init extends Migration
{
    /**
     * creates the following tables:
     *  + posts
     *  + post_tags
     *  + pages
     *  + diosites
     *  + categories
     *  + tags
     *  + blogs
     *  + bloggers
     *  + users
     *  
     * creates the following instances/records:
     *  + categories: Rainbow, Black Sabbath, Dio
     *  + blogs: Doses
     *  + bloggers: Todd Stargazer
     *  + user: admin 
     */
    public function up()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        // atomic content item (Post), and its relational members
        
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
                // TODO: CREATE INDEXES FOR PUBLISHED, ADMIN LIST, BLOG/BLOGGER/CATEGORY/etc INDEXES HERE
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%quotes}}',
            [
                'id'      => Schema::TYPE_PK,
                'post_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'body'    => Schema::TYPE_TEXT    . ' DEFAULT NULL',
                'source'  => Schema::TYPE_STRING  . '(2000) DEFAULT NULL',
                'KEY idx_quote_post (post_id)'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%videos}}',
            [
                'id'      => Schema::TYPE_PK,
                'post_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'embed'   => Schema::TYPE_STRING  . '(2000) NOT NULL',
                'title'   => Schema::TYPE_STRING  . '(128) DEFAULT NULL',
                'KEY idx_video_post (post_id)'
            ],
            $tableOptions
        );

        $this->createTable(
            '{{%post_tags}}',
            [
                'post_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'tag_id'  => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'PRIMARY KEY (post_id, tag_id)'
            ],
            $tableOptions
        );

        // remaining content datatypes or content taxonomy datatypes

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

        // administrative datatypes
        
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

        // create initial Categories
        $_cats = [
            ['name' => 'Rainbow',       'shortname' => 'rainbow'],
            ['name' => 'Black Sabbath', 'shortname' => 'black-sabbath'],
            ['name' => 'Dio',           'shortname' => 'dio'] // the band...
        ];
        foreach($_cats as $_cat) {
            $category            = new Category;
            $category->name      = $_cat['name'];
            $category->shortname = $_cat['shortname'];
            try {
                $category->save();
                // if(!$category->save()) {
                //     echo(print_r($category->getErrors(), 1));
                // }
            } catch(Exception $e) {
                echo("\n");
                echo($e->getMessage());
                echo("\n");
            }
        }
        echo("\n    FINISHED ADDING CATEGORIES \n");

        // create some sample Tags
        $_tags = [
            ['name' => '70s',            'shortname' => '70s'],
            ['name' => '80s',            'shortname' => '80s'],
            ['name' => 'Music Industry', 'shortname' => 'music-industry'],
            ['name' => 'Poetic Lyrics',  'shortname' => 'poetic-lyrics'],
            ['name' => 'Rockin Solos',   'shortname' => 'rockin-solos']
        ];
        foreach($_tags as $_tag) {
            $tag            = new Tag;
            $tag->name      = $_tag['name'];
            $tag->shortname = $_tag['shortname'];
            try {
                $tag->save();
            } catch(Exception $e) {
                echo("\n");
                echo($e->getMessage());
                echo("\n");
            }
        }
        echo("\n    FINISHED ADDING SAMPLE TAGS \n");

        // create initial Blog
        $blog            = new Blog;
        $blog->title     = 'Doses';
        $blog->shortname = 'doses';
        try {
            $blog->save();
        } catch (Exception $e) {
            echo("\n");
            echo($e->getMessage());
            echo("\n");
        }
        echo("\n    FINISHED ADDING FIRST BLOG \n");

        // create initial Blogger
        $blogger            = new Blogger;
        $blogger->name      = 'Todd Stargazer';
        $blogger->shortname = 'todd-stargazer';
        try {
            $blogger->save();
        } catch (Exception $e) {
            echo("\n");
            echo($e->getMessage());
            echo("\n");
        }
        echo("\n    FINISHED ADDING FIRST BLOGGER \n");

        // create initial admin User
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
        $this->dropTable('{{%quotes}}');
        $this->dropTable('{{%videos}}');
        $this->dropTable('{{%post_tags}}');
        $this->dropTable('{{%pages}}');
        $this->dropTable('{{%diosites}}');
        $this->dropTable('{{%tags}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%blogs}}');
        $this->dropTable('{{%bloggers}}');
        $this->dropTable('{{%users}}');
    }
}

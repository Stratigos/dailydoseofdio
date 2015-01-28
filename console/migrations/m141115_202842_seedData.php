<?php
/*****************************************************************************
* Add Posts and other data to the db for testing, etc.
******************************************************************************/
use yii\db\Schema;
use yii\db\Migration;
use common\models\Page;
use common\models\Post;
use common\models\Category;
use common\models\Tag;
use common\models\Blog;
use common\models\Blogger;
use common\models\User;

class m141115_202842_seedData extends Migration
{

    public function up()
    {
        // create initial administrative Users
        $users = [
            [
                'username' => 'toddmorningstar',
                'email'    => 'dont@spam.me'
            ],
            [
                'username' => 'lucyappleschen',
                'email'    => 'dont@spam2.me'
            ]
        ];
        $password = 'admin';
        foreach($users as $usr) {
            $user           = new User();
            $user->username = $usr['username'];
            $user->password = $password;
            $user->email    = $usr['email'];
            try {
                $user->save();
            } catch(Exception $e) {
                echo("\n");
                echo($e->getMessage());
                echo("\n");
            }
            echo(
                "\n    New User created with id: {$user->id},  username: '{$user->username}'," .
                " and password '{$password}'."
            );
        }

        // get User data for Post authorship
        $userTodd = User::find()->where(['username' => 'toddmorningstar'])->one();
        $userLucy = User::find()->where(['username' => 'lucyappleschen'])->one();

        // create initial Page
        $page            = new Page;
        $page->title     = 'About';
        $page->shortname = 'about';
        $page->body     = '<p><h3><em>We Rock!</em></h3></p>';
        try {
            $page->save();
        } catch(Exception $e) {
            echo("\n");
            echo($e->getMessage());
            echo("\n");
        }
        echo("\n    FINISHED ADDING ABOUT PAGE \n");

        // create initial Posts
        for($i = 0; $i < 24; $i++) {
            // create some sample posts by Lucy and Todd
            $time          = time();
            $created_by_id = $userTodd->id;
            if($i % 3 == 0) {
                $created_by_id = $userLucy->id;
            }

            $post               = new Post;
            $post->type_id      = 0;
            $post->category_id  = 0;
            $post->blog_id      = 0;
            $post->blogger_id   = 0;
            $post->status       = 1;
            $post->title        = "Test Post {$i}";
            $post->shortname    = "test-post-{$i}";
            $post->body         = '<p>This is some initial content: ' . mt_rand() . '</p>';
            $post->created_by   = $created_by_id;
            $post->created_at   = $time;
            $post->published_at = $time;
            try {
                if(!$post->save()) {
                    echo("\n        ERROR SAVING POST {$i} : \n");
                    echo(print_r($post->getErrors(), 1));
                }
            } catch(Exception $e) {
                echo("\n");
                echo($e->getMessage());
                echo("\n");
            }
        }
        echo("\n    FINISHED ADDING INITIAL DRAFT POSTS \n");

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
            ['name' => '70s',              'shortname' => '70s'],
            ['name' => '80s',              'shortname' => '80s'],
            ['name' => 'Music Industry',   'shortname' => 'music-industry'],
            ['name' => 'Poetic Lyrics',    'shortname' => 'poetic-lyrics'],
            ['name' => 'Rockin Solos',     'shortname' => 'rockin-solos'],
            ['name' => 'Live Performance', 'shortname' => 'live-performance'],
            ['name' => 'Music Videos',     'shortname' => 'rockin-solos'],
            ['name' => 'Covers',           'shortname' => 'covers']
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

        echo("\n    ~ !! After migrations finish, log in, and update all users with a secure password !! ~\n");

        return TRUE;
    }

    public function down()
    {
        echo("\n DELETING ALL Post, Page, Category, Tag, Blog, Blogger, and User RECORDS... \n");
        Page::deleteAll();
        Post::deleteAll();
        Category::deleteAll();
        Tag::deleteAll();
        Blog::deleteAll();
        Blogger::deleteAll();
        User::deleteAll();
        echo("\n ...FINISHED \n");

        return TRUE;
    }
}

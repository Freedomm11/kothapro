<?php
namespace App\controllers;

use App\models\ImageManager;
use App\models\QueryBuilder;
use App\models\Template;
use Delight\Auth\Auth;
use JasonGrimes\Paginator;
use App\models\FunctionManager;
use SimpleMail;
use Tamtamchik\SimpleFlash\Flash;
use PDO;



class HomeController {

    public $qb;
    public $tpl;
    public $pdo;
    public $func;
    public $img;
    public $flash;
    public $auth;



    public function __construct(PDO $pdo, QueryBuilder $qb, Template $template, FunctionManager $func,
                                ImageManager $img, Flash $flash, Auth $auth)
    {
        $this->qb = $qb;
        $this->tpl = $template;
        $this->pdo = $pdo;
        $this->func = $func;
        $this->img = $img;
        $this->flash = $flash;
        $this->auth = $auth;
    }



    public function homepage()
    {
        $totalItems = $this->qb->getAll('posts');
        $itemsPerPage = 4;
        $currentPage = $_GET['page'] ?? 1;
        $urlPattern = '?page=(:num)';

        $paginator = new Paginator(count($totalItems), $itemsPerPage, $currentPage,
            $urlPattern);

        $posts = $this->qb->getPosts('posts', $itemsPerPage, $currentPage);

        echo $this->tpl->getPage('public/homepage',
            ['posts' => $posts,
             'paginator' => $paginator
            ]);
    }


    public function category($vars)
    {
        $totalItems = $this->qb->getCountInCategory('posts', $vars['id']);
        $itemsPerPage = 4;
        $currentPage = $_GET['page'] ?? 1;
        $urlPattern = $vars['id'].'?page=(:num)';

        $paginator = new Paginator(count($totalItems), $itemsPerPage, $currentPage,
            $urlPattern);

        $postsInCategory = $this->qb->getPostsInCategory('posts', $vars['id'], $itemsPerPage, $currentPage);

        echo $this->tpl->getPage('public/category',
            ['postsCategory' => $postsInCategory,
             'paginator' => $paginator
            ]);
    }


    public function showPost()
    {
        $post = $this->qb->getOnePost('posts', $_GET['id']);
        $postsCategory = $this->qb->getCategoryPosts('posts', $post['category']);
        $postsAlsoLike = $this->func->removeItemArray($_GET['id'], $postsCategory, 'id' );

        $prevPost = $this->qb->getPrevPost('posts', $_GET['id']);
        $nextPost = $this->qb->getNextPost('posts', $_GET['id']);

        $this->qb->update('posts', ['views' => $post['views']+1], $_GET['id']);

        if ($prevPost['id'] == null):
            $displayPrev = 'none'; else: $var = 6; endif;
        if ($nextPost['id'] == null):
            $displayNext = 'none'; $var = 12; endif;

        if (!count($postsAlsoLike) < 3):
            shuffle($postsAlsoLike); else: $display = 'none';  endif;

        $comments = $this->qb->getComments();
        $commentReplies = $this->qb->getCommentReplies();

        $userId = $this->auth->getUserId();

            if (isset($_POST['btn-comments'])){

                if(isset($_GET['reply']))
                {$reply = $_GET['reply'];} else {$reply = 0;}

                $this->qb->insert([
                    'text' => $_POST['text'],
                    'date' => date('M d, Y'),
                    'parent_id' => $reply,
                    'post_id' => $_GET['id'],
                    'avatar_id' => $userId,
                    ], 'comments');

                header("Location: /post/?id=".$_GET['id']);
            }

        echo $this->tpl->getPage('public/show', [
            'post' => $post,
            'postsAlsoLike' => $postsAlsoLike,
            'prevPost' => $prevPost,
            'nextPost' => $nextPost,
            'display' => $display,
            'displayPrev' => $displayPrev,
            'displayNext' => $displayNext,
            'var' => $var,
            'auth' => $this->auth,
            'comments' => $comments,
            'replies'=> $commentReplies,
            ]);
    }


    public function addCategory()
    {
        $this->qb->insert([
            'title' => lcfirst($_POST['title']),
        ], 'categories');

        header('Location: /admin/categories');
    }


    public function subscription()
    {
        if (isset($_POST['btn-newsletter'])) {

            if (!$this->qb->checkEmailSubscription('subscription', $_POST['email']))
            {
                $this->qb->insert([
                    'email' => $_POST['email'],
                    'date' => date('M d, Y'),
                ], 'subscription');

                SimpleMail::make()
                    ->setTo($_POST['email'], 'dear friend')
                    ->setSubject('Subscription')
                    ->setMessage("<strong> Thank you for subscribing to blog news. </strong>")
                    ->setHtml()
                    ->send();

                header("Location: /");
            }
            else{
                die('You are already subscribed');
            }
        }
    }


}




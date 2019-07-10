<?php
namespace App\models;
use League\Plates\Engine;



class Template {

    public $templates;
    public $qb;


    public function __construct(Engine $engine, QueryBuilder $qb)
    {
        $this->templates = $engine;
        $this->qb = $qb;
    }


    public function getPage($layout, $data)
    {
        $popularPosts = $this->qb->getPopularPost('posts');
        $latestPosts = $this->qb->getLatestPost('posts');
        $categories = $this->qb->getAll('categories');
        $adminAvatar = $this->qb->getAdminAvatar('users','admin');

        $this->templates->addData([
            'popularPosts' => $popularPosts,
            'latestPosts'  => $latestPosts,
            'categories'   => $categories,
            'adminAvatar' =>  $adminAvatar,
        ]);

        echo $this->templates->render('public/include/header');
        echo $this->templates->render($layout, $data);
        echo $this->templates->render('public/include/footer');
    }


    public function getAdminPage($layout, $data)
    {
        $adminAvatar = $this->qb->getAdminAvatar('users','admin');

        $this->templates->addData([
            'adminAvatar' =>  $adminAvatar,
        ]);

        echo $this->templates->render('admin/include/header');
        echo $this->templates->render('admin/include/sidebar');
        echo $this->templates->render($layout, $data);
        echo $this->templates->render('admin/include/footer');

    }

}
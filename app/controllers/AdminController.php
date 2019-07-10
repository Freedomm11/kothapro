<?php

namespace App\controllers;

use App\models\ImageManager;
use App\models\Template;
use App\models\QueryBuilder;
use Delight\Auth\Auth;
use PDO;



class AdminController {

    public $tpl;
    public $qb;
    public $home;
    public $img;
    public $pdo;
    public $auth;


    public function __construct( Template $template, QueryBuilder $qb, HomeController $home,
                                ImageManager $img, PDO $pdo, Auth $auth )
    {
        $this->tpl = $template;
        $this->qb = $qb;
        $this->home = $home;
        $this->img = $img;
        $this->pdo = $pdo;
        $this->auth = $auth;
    }


    //Main Page AdminPanel
    public function admin()
    {
        $this->tpl->getAdminPage('admin/admin', [null]);
    }



    //Posts
    public function adminPosts()
    {
        $posts = $this->qb->getAll('posts');
        $this->tpl->getAdminPage('admin/posts/view', ['posts' => $posts]);
    }


    public function adminPostCreate()
    {
        if (isset($_POST['btn-post'])){

            if (empty($_POST['title']) or empty($_POST['description'])
            or empty($_POST['category_id']) or empty(is_uploaded_file($_FILES['image']['tmp_name'])))
            {
                 echo 'Пожалуйста, заполните все поля!';
                 exit;
            }

            $image = $this->img->uploadImage();

            $this->qb->insert([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'category' => $_POST['category_id'],
                'picture' => $image,
                'date' => date('M d, Y'),
            ],
                'posts');

            header('Location: /admin/posts');
        }

        $category = $this->qb->getAll('categories');
        echo $this->tpl->getAdminPage('admin/posts/create', ['categoryInView' => $category]);
    }


    public function adminPostEdit($vars)
    {
        if (isset($_POST['btn-post-edit'])){

            $image =  $this->img->uploadImage();

            $this->qb->update('posts', [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'category' => $_POST['category_id'],
                'picture' => $image,
            ], $vars['id']);

            header('Location: /admin/posts');
        }

        $post = $this->qb->getOne('posts', $vars['id']);
        $category = $this->qb->getAll('categories');

        $this->tpl->getAdminPage('admin/posts/edit', [
            'post' => $post,
            'categoryInView' => $category,
        ]);
    }


    public function adminDeletePost($vars)
    {
        $this->qb->delete('posts', $vars['id'] );
        header('Location: /admin/posts');
    }




    //Categories
    public function adminCategories()
    {
        $category = $this->qb->getAll('categories');
        $this->tpl->getAdminPage('admin/categories/view', ['categoryInView' => $category]);
    }


    public function adminCategoryCreate()
    {
        if (isset($_POST['btn-category'])){
            $this->home->addCategory();
        }

        $this->tpl->getAdminPage('admin/categories/create', [null]);
    }


    public function adminCategoryEdit($vars)
    {
        if (isset($_POST['btn-category-edit'])){
            $this->qb->update('categories', [
                'title' => $_POST['title'],
            ], $vars['id']);

            header('Location: /admin/categories');
        }

        $category = $this->qb->getOne('categories', $vars['id']);
        $this->tpl->getAdminPage('admin/categories/edit', ['category' => $category]);
    }


    public function adminDeleteCategory($vars)
    {
        $this->qb->delete('categories', $vars['id'] );
        header('Location: /admin/categories');
    }




    //Users
    public function adminUsers()
    {
        $users = $this->qb->getAll('users');
        $this->tpl->getAdminPage('admin/users/view', ['allUsers' => $users]);
    }


    public function adminUserCreate()
    {
        if (isset($_POST['btn-admin-create'])){

            try {
                $userId = $this->auth->admin()->createUser($_POST['email'], $_POST['password'], $_POST['username']);

                if (is_uploaded_file($_FILES['image']['tmp_name']))
                {
                    $image = $this->img->uploadAvatar();
                    $this->qb->update('users', ['avatar' => $image], $userId);
                }

                if($_POST['role'] == 'admin'){
                    try {
                        $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
                    }
                    catch (\Delight\Auth\UnknownIdException $e) {
                        die('Unknown user ID');
                    }
                } elseif ($_POST['role'] == 'user'){
                    try {
                        $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::AUTHOR);
                    }
                    catch (\Delight\Auth\UnknownIdException $e) {
                        die('Unknown user ID');
                    }
                }
                if($_POST['status'] == 'isBanned'){
                   $this->qb->update('users', ['status' => 2], $userId);
                }

                header('Location: /admin/users');
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                die('Invalid email address');
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                die('Invalid password');
            }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
                die('User already exists');
            }
        }

        $this->tpl->getAdminPage('admin/users/create', [null]);
    }


    public function adminUserEdit($vars)
    {
        if (isset($_POST['btn-user-edit'])){

            if (is_uploaded_file($_FILES['image']['tmp_name']))
            {
                $image = $this->img->uploadAvatar();
                $this->qb->update('users', ['avatar' => $image], $vars['id']);
            }

            $this->qb->update('users', [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'roles_mask' => $_POST['role'],
            ], $vars['id']);

            if (!empty($_POST['password'])){
                try {
                    $this->auth->admin()->changePasswordForUserById($vars['id'], $_POST['password']);
                }
                catch (\Delight\Auth\UnknownIdException $e) {
                    die('Unknown ID');
                }
                catch (\Delight\Auth\InvalidPasswordException $e) {
                    die('Invalid password');
                }
            }

            if (!empty($_POST['status']))
            {
                $this->qb->update('users', ['status' => 2], $vars['id']);
            } else  if (empty($_POST['status']))
                $this->qb->update('users', ['status' => 0], $vars['id']);

            header('Location: /admin/users');
        }

        $user = $this->qb->getOne('users', $vars['id']);
        $this->tpl->getAdminPage('admin/users/edit', [
            'oneUser' =>  $user,
        ]);
    }


    public function adminDeleteUser($vars)
    {
        $this->qb->delete('users', $vars['id'] );
        header('Location: /admin/users');
    }

}
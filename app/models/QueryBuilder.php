<?php

namespace App\models;

use Aura\SqlQuery\QueryFactory;
use Faker\Factory;
use PDO;


class QueryBuilder {

    private $pdo;
    private $queryFactory;

    public function __construct(PDO $pdo, QueryFactory $qf)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $qf;
    }



    // QueryBuilder

    public function getAll($table)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
               ->from($table);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getOne($table, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('id =:id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    public function insert($data, $table)
    {
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }


    public function update($table, $data, $id)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id =:id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }


    public function delete($table, $id)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id =:id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }



    //QueryBuilder Posts
    public function getOnePost($table, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('id =:id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if ($id <> $result['id'] or $id == null):
            include '../app/views/404.php'; endif;

        return $result;
    }


    public function getCategoryPosts($table, $category)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('category =:category')
            ->bindValues(['category' => $category]);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getPrevPost($table, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('id >:id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getNextPost($table, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->orderBy(['id DESC'])
            ->where('id <:id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getPosts($table, $itemsPerPage, $currentPage)
    {
        $select = $this->queryFactory->newSelect();
        $select
            ->cols(['*'])
            ->from($table)
            ->orderBy(['id DESC'])
            ->setPaging($itemsPerPage)
            ->page($currentPage);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getPopularPost($table)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->orderBy(['views DESC'])
            ->limit(3);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getLatestPost($table)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->orderBy(['id DESC'])
            ->limit(4);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getCountInCategory($table, $category)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('category =:category')
            ->bindValue('category', $category);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getPostsInCategory($table, $category, $itemsPerPage, $currentPage)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->orderBy(['id DESC'])
            ->where('category =:category')
            ->setPaging($itemsPerPage)
            ->page($currentPage)
            ->bindValue('category', $category);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }



    //QueryBuilder Comments
    public function getComments()
    {
        $select= $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from('users')
            ->join(
                'LEFT',             // the join-type
                'comments AS c',        // join to this table ...
                'users.id = c.avatar_id' // ... ON these conditions
            )
            ->where('parent_id=:parent_id')
            ->bindValue('parent_id', 0);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getCommentReplies()
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from('users')
            ->join(
                'LEFT',             // the join-type
                'comments AS c',        // join to this table ...
                'users.id = c.avatar_id' // ... ON these conditions
            );

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }



    //Subscription
    public function checkEmailSubscription($table, $email)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('email =:email')
            ->bindValue('email', $email);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }



    //Avatars
    public function getAdminAvatar($table, $username)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('username=:username')
            ->bindValue('username', $username);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }




//    //Other Query
//
//    public function faker()
//    {
//        $faker = Factory::create();
//        $insert = $this->queryFactory->newInsert();
//        $insert->into('posts');
//
//        for($i=0; $i<30; $i++) {
//            $insert->cols([
//                'title' => $faker->words(3, true),
//                'description' => $faker->text($maxNbChars = 4000),
//                'category' => $faker->randomElement(['travel', 'nature', 'food']),
//                'date' => date('M d, Y'),
//                'views' => $faker->randomDigit,
//            ]);
//            $insert->addRow();
//        }
//
//        $sth = $this->pdo->prepare($insert->getStatement());
//        $sth->execute($insert->getBindValues());
//    }


}
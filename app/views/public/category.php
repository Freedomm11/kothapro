<? use App\models\FunctionManager;?>

<div class="kotha-default-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">

                <? foreach ($postsCategory as $post):?>
                    <article class="single-blog">
                        <div class="post-thumb">
                            <a href="#"><img src="/uploads/<?=$post['picture']; ?>" alt=""></a>
                        </div>
                        <div class="post-content">
                            <div class="entry-header text-center text-uppercase">
                                <a href="/category/<?=$post['category']; ?>" class="post-cat"><?=$post['category']; ?></a>
                                <h2><a href="/post/?id=<?=$post['id']; ?>"><?=$post['title'];?></a></h2>
                            </div>
                            <div class="entry-content cut-text">
                                <p><? FunctionManager::cutText($post['description'], 500)?></p>
                            </div>
                            <div class="continue-reading text-center text-uppercase">
                                <a href="/post/?id=<?=$post['id']; ?>">Continue Reading</a>
                            </div>
                            <div class="post-meta">
                                <ul class="pull-left list-inline author-meta">
                                    <li class="author">By <a href="#"><?=$post['author']; ?> </a></li>
                                    <li class="date"> On <?=$post['date']; ?></li>
                                </ul>
                                <ul class="pull-right list-inline social-share">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </article>
                <? endforeach;?>


                <div class="post-pagination  clearfix">
                    <ul class="pagination">

                        <? if ($paginator->getPrevUrl()): ?>
                            <li><a href="<?=$paginator->getPrevUrl(); ?>">&laquo;</a></li>
                        <? endif; ?>

                        <? foreach ($paginator->getPages() as $page): ?>
                            <? if ($page['url']): ?>
                                <li <?=$page['isCurrent'] ? 'class="active"' : ''; ?>>
                                    <a href="<?=$page['url']; ?>"><?=$page['num']; ?></a>
                                </li>
                            <? else: ?>
                                <li class="disabled"><span><?=$page['num']; ?></span></li>
                            <? endif; ?>
                        <? endforeach; ?>

                        <? if ($paginator->getNextUrl()): ?>
                            <li><a href="<?=$paginator->getNextUrl(); ?>">&raquo;</a></li>
                        <? endif; ?>

                    </ul>
                </div>
            </div>

            <div class="col-sm-4">
                <?=$this->insert('public/include/sidebar')?>
            </div>

        </div>
    </div>
</div>




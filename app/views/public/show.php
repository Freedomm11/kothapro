<div class="kotha-default-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <article class="single-blog">
                    <div class="post-thumb">
                        <img src="/uploads/<?=$post['picture']; ?>" alt="">
                    </div>
                    <div class="post-content">
                        <div class="entry-header text-center text-uppercase">
                            <a href="/category/<?=$post['category']; ?>" class="post-cat"><?=$post['category']; ?></a>
                            <h2><?=$post['title']; ?></h2>
                        </div>
                        <div class="entry-content">
                            <p> <?=$post['description']; ?></p>
                        </div>

                        <div class="post-meta">
                            <ul class="pull-left list-inline author-meta">
                                <li class="author">By <a href="#"><?=$post['author']; ?></a></li>
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

                <div class="top-comment"><!--top comment-->
                    <img src="/assets/front/images/comment.jpg" class="pull-left img-circle" alt="">
                    <h4><a href="#">Ricard Goff</a></h4>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy hello ro mod tempor
                        invidunt ut labore et dolore magna aliquyam erat.</p>
                    <ul class="list-inline social-share">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>

                <div class="row"><!--blog next previous-->
                   <div style="display: <? echo $displayPrev ?>" class="col-md-<?=$var; ?>">
                        <div class="single-blog-box">
                            <a href="/post/?id=<?=$prevPost['id']; ?>">
                                <img src="/uploads/th-pagination/<?=$prevPost['picture']; ?>" alt="">
                                <div class="overlay">
                                    <div class="promo-text">
                                        <p><i class=" pull-left fa fa-angle-left"></i></p>
                                        <h5> <?=$prevPost['title']; ?></h5>
                                    </div>
                                </div>
                            </a>
                         </div>
                    </div>
                    <div style="display: <? echo $displayNext ?>" class="col-md-<?=$var; ?>">
                        <div class="single-blog-box">
                            <a href="/post/?id=<?=$nextPost['id']; ?>">
                                <img src="/uploads/th-pagination/<?=$nextPost['picture']; ?>" alt="">
                                <div class="overlay">
                                    <div class="promo-text">
                                        <p><i class="pull-right fa fa-angle-right"></i></p>
                                        <h5> <?=$nextPost['title'] ?></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div style="display: <? echo $display;?>" class="related-post-carousel"><!--related post carousel-->
                    <div class="related-heading">
                        <h4>You might also like</h4>
                    </div>
                    <div class="related-post-carousel-items">

                        <? foreach ($postsAlsoLike as $posts): ?>
                            <div class="single-item">
                                <a href=/post/?id=<?=$posts['id']; ?>>
                                    <img src="/uploads/<?= $posts['picture']; ?>" alt="">
                                    <h4><?=$posts['title']; ?></h4>
                                </a>
                            </div>
                        <? endforeach; ?>

                    </div>
                </div>


                <? if ($auth->hasAnyRole(\Delight\Auth\Role::SUPER_ADMIN, \Delight\Auth\Role::ADMIN, \Delight\Auth\Role::AUTHOR )): ?>

                    <div class="comment-area">
                        <div class="comment-heading">
                            <h3> <span id="totalComments"></span> Thoughts </h3>
                        </div>

                        <? foreach ($comments as $comment): ?>
                            <? if ($comment['post_id'] == $_GET['id']): ?>

                                <div class="single-comment">
                                    <div class="media">
                                        <div class="media-left text-center">
                                            <img class="media-object" src="/uploads/avatars/comments/<?=$comment['avatar']; ?>" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading">
                                                <h3 class="text-uppercase">
                                                    <a href="#"><?=$comment['username']; ?></a>
                                                    <a  href="/post/?id=<?=$_GET['id']; ?>&reply=<?=$comment['id']; ?>#bottom" class="pull-right reply-btn">reply</a>
                                                </h3>
                                            </div>
                                            <p class="comment-date">
                                                <?=$comment['date']; ?>
                                            </p>
                                            <p class="comment-p">
                                                <?=$comment['text']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            <? foreach ($replies as $reply): ?>
                                <? if ($comment['id'] == $reply['parent_id']): ?>

                                    <div class="single-comment single-comment-reply">
                                        <div class="media">
                                            <div class="media-left text-center">
                                                 <img class="media-object" src="/uploads/avatars/comments/<?=$reply['avatar']; ?>" alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="media-heading">
                                                    <h3 class="text-uppercase"><a href="#"><?=$reply['username']; ?></a></h3>
                                                </div>
                                                <p class="comment-date">
                                                    <?=$reply['date']; ?>
                                                </p>
                                                <p class="comment-p">
                                                    <?=$reply['text']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                 <? endif; ?>
                             <? endforeach; ?>

                            <? endif; ?>
                        <? endforeach; ?>

                    </div>

                <? if(!$auth->isBanned()): ?>
                    <a name="bottom" href=""></a>
                    <!--leave comment-->
                    <div class="leave-comment">

                        <h4>Leave a reply</h4>
                        <form class="form-horizontal contact-form"  action="" method="post" >
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="6" name="text" placeholder="Write Massage" required></textarea>
                                </div>
                            </div>
                            <button    name="btn-comments" type="submit" class="btn send-btn">Post Comment</button>
                        </form>
                    </div>
                <? endif ?>
                <? else: ?>
                    <div class="leave-comment">
                        <h4>Для того, что бы увидеть комментарии, необходимо
                            <a class="text-danger" href="/login">авторизоваться</a>
                        </h4>
                    </div>
               <? endif ?>

            </div>

            <div class="col-sm-4">
                <?=$this->insert('public/include/sidebar') ?>
            </div>

        </div>
    </div>
</div>
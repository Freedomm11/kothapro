<aside class="widget latest-post-widget">
    <h2 class="widget-title text-uppercase text-center">Latest Posts</h2>
    <ul>
        <?php  foreach ($latestPosts as $post):?>
        <li class="media">
            <div class="media-left">
                <a href="/post/?id=<? echo $post['id']; ?>" class="popular-img"><img src="/uploads/thumbnail/<?php echo $post['picture'];?>" alt="">
                </a>
            </div>
            <div class="latest-post-content">
                <h2 class="text-uppercase"><a href="/post/?id=<? echo $post['id']; ?>"><?php echo $post['title'];?></a></h2>
                <p><?php echo $post['date'];?></p>
            </div>
        </li>
        <?php endforeach;?>

    </ul>
</aside>
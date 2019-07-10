<aside class="widget widget-popular-post">
    <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
    <ul>
        <?php  foreach ($popularPosts as $post):?>
            <li>
                <a href="/post/?id=<? echo $post['id']; ?>" class="popular-img"><img src="/uploads/<?php echo $post['picture'];?>" alt="">
                </a>
                <div class="p-content">
                    <h4><a href="/post/?id=<? echo $post['id']; ?>" class="text-uppercase"><?php echo $post['title'];?></a></h4>
                    <span class="p-date"><?php echo $post['date'];?></span>
                </div>
            </li>
        <?php endforeach;?>

    </ul>
</aside>
<div class="modal">
    <div class="modal-card">
        <h1><i class="fas fa-exclamation-triangle"></i></h1>
        <h3>Are you sure</h3>
        <p>Do you really want to delete the post: #1 - php dev</p>
        <div class="btnAction">
            <button id="cancel">Cancel</button>
            <button id="delete">Delete</button>
        </div>
    </div>
</div>
<div class="cardContainer">

    <h2>My posts</h2>

    <?php if (count($posts) >= 1) : ?>

        <div class="page">
            <p>Página <?= $paginator->page() ?> de <?= $paginator->pages() ?> </p>
        </div>

        <?php foreach ($posts as $i => $post) : ?>

            <div class="post">
                <div class="post_banner">
                    <img src="<?= $post->hasPhoto ? loadImg($post->photoPath) : loadImg("img/blogImg/defaultBanner.png") ?>" alt="">
                </div>
                <div class="post_info">
                    <h3><?= $post->title ?></h3>
                    <p class="postDescript">
                        <?= $post->description ?>
                    </p>
                    <div class="moreInfo">
                        <div class="author">
                            <i class="fas fa-user"></i>
                            <?= $post->author ?>
                        </div>
                        <div class="date">
                            <i class="far fa-calendar-alt"></i>
                            <?= $post->updated_at ?? $post->created_at ?>
                        </div>
                        <div class="readMore">
                            <a href="<?= url("post/show/$post->id") ?>">
                                <i class="fab fa-readme"></i>
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
                <?php if (canModify($post->user_id)) : ?>
                    <div class="actionBtn">
                        <button class="deletePost" data-id="<?= $post->id ?>" data-title="<?= $post->title ?>" data-index="<?= $i ?>">
                            <i class="fas fa-trash-alt"></i>
                            Delete
                        </button>

                        <a href="<?= url("post/update/$post->id") ?>">
                            <button class="editPost" data-id="<?= $post->id ?>" data-title="<?= $post->title ?>">
                                <i class="fas fa-edit"></i>
                                Update
                            </button>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        <?php endforeach ?>

        <div class="pagination">
            <?= $paginator->render(); ?>
        </div>


        <script type="module" src="<?= loadJs("indexPost.js") ?>"></script>
    <?php else : ?>

        <div class="noPost">
            <h2>Ops! You don't have any post yet!</h2>
            <p>Click in the link below to create your fist one</p>
            <a href="<?= url("post/create") ?>">Create a post</a>
        </div>

    <?php endif ?>
</div>
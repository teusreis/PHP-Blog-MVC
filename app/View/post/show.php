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

<section class="main">
    <h2><?= $post->title ?></h2>
    <div class="info">
        <div class="author">
            <i class="fas fa-user"></i>
            <?= $post->author ?>
        </div>
        <div class="date">
            <i class="far fa-calendar-alt"></i>
            <?= $post->updated_at ?? $post->created_at ?>
        </div>
    </div>

    <p class="description">
        <?= $post->description ?>
    </p>
    
    <div class="imgCard">
        <img src="<?= loadImg("userImg/bannerTest.png"); ?>" alt="">
    </div>

    <?php foreach ($post->paragraph as $para) : ?>

        <p><?= $para ?></p>

    <?php endforeach ?>

    <?php if (canModify($post->user_id)) : ?>
        <div class="actionBtn">
            <button class="deletePost" data-id="<?= $post->id ?>" data-title="<?= $post->title ?>" data-index="<?= $i ?>">
                <i class="fas fa-trash-alt"></i>
                Delete
            </button>

            <a href="<?= url("post/edit/$post->id") ?>">
                <button class="editPost" data-id="<?= $post->id ?>" data-title="<?= $post->title ?>">
                    <i class="fas fa-edit"></i>
                    Update
                </button>
            </a>
        </div>
    <?php endif ?>
</section>

<script type="module" src="<?= loadJs("showPost.js"); ?>"></script>
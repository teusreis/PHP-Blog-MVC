<div class="headerBackground"></div>
<header>
    <form action="<?= url("post/search") ?>" method="get">
        <label for="search">Search for a post</label>
        <input type="text" name="search" id="search" placeholder="Ex: php" value="">
        <button type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</header>

<div class="cardContainer">

    <?php foreach ($posts as $i => $post) : ?>
        <div class="post">
            <div class="post_banner">
                <img src="<?= loadImg($post->photoPath ?? "img/blogImg/defaultBanner.png"); ?>" alt="">
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
        </div>

    <?php endforeach ?>

</div>

<script>
    const form = document.querySelector("form");

    form.addEventListener("submit", event => {
        event.preventDefault();

        if (!form.search.value == "") {
            form.submit();
        }
    })
</script>
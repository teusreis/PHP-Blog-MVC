<h2 class="title">New Post</h2>

<form id="post" action="<?= isset($post) ? url("post/edit") : url("post/create") ?>" method="post">

    <?php if (isset($id)) : ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif ?>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="post[title]" name="id" id="title" value="<?= $post->title ?? "" ?>">
        <div class="errorMenagem"></div>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="post[description]" id="description" cols="50" rows="5"><?= $post->description ?? "" ?></textarea>
        <div class="errorMenagem"></div>
    </div>
    <div class="paragraph-container">

        <?php if (isset($post)) : ?>

            <?php foreach ($post->paragraph as $i => $para) : ?>

                <div class="form-group">
                    <label for="">Paragraph <?= $i ?></label>
                    <textarea name="post[paragraph][]" class="para" id="" cols="30" rows="10"><?= $para ?? "" ?></textarea>
                    <div class="errorMenagem"></div>
                </div>

            <?php endforeach ?>

        <?php else : ?>

            <div class="form-group">
                <label for="">Paragraph 1</label>
                <textarea name="post[paragraph][]" class="para" id="" cols="30" rows="10"></textarea>
                <div class="errorMenagem"></div>
            </div>

        <?php endif ?>

    </div>
    <div class="btnContainer">
        <div class="actionBtn">
            <button class="btnExPara"><i class="fas fa-minus"></i></button>
            <button class="btnNewPara"><i class="fas fa-plus"></i></button>
        </div>
        <div class="submitWapper">
            <button type="submit" id="btnSubmit">Post</button>
        </div>
    </div>
</form>

<script src="<?= loadJs("createPost.js") ?>"></script>
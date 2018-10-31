<!-- Blog Entries Column -->
<div class="col-md-8">
    <br>
    <?php if (count($data['populars'])) { ?>
    <h2 class="my-4">
        Популярные записи
    </h2>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="slick-list">
                <?php
                foreach ($data['populars'] as $popular) {
                    ?>
                    <!-- Blog Post -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text"><?= mb_substr($popular['text'], 0, 75) ?>...</p>
                            <a href="/post/?id=<?= $popular['id'] ?>" class="btn btn-primary">Читать полностью &rarr;</a>
                        </div>
                        <div class="card-footer text-muted">
                            Размещено <?=date('Y-m-d H:i:s', $popular['updated_at']) ?> пользователем <?=$popular['author']?>
                            <br>
                            Обсуждения (<?=$popular['comments_count']?> )
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
        $errors = $_SESSION['post_errors'] ?? null;
        $inputs = $_SESSION['inputs_post'] ?? null;
    ?>
    <br>
    <form action="/post/add" method="post">
        <h2>Добавить запись</h2>
        <div class="form-group">
            <label for="formGroupExampleInput">Автор</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Имя автора" name="author" value="<?=$inputs['author'] ?? ''?>">
            <?php
            if ($errors['author']) {
                foreach ($errors['author'] as $key => $error) {
                    ?>
                    <p class="small error"><?=$error?></p>
                    <?php
                }
            }
            ?>

        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Текст записи</label>
            <textarea type="text" class="form-control" id="formGroupExampleInput2" placeholder="Введите текст" name="text"><?=$inputs['text'] ?? ''?></textarea>
            <?php
            if ($errors['text']) {
                foreach ($errors['text'] as $key => $error) {
                    ?>
                    <p class="small error"><?=$error?></p>
                    <?php
                }
            }
            ?>
        </div>
        <div class="form-group">
            <button class="btn btn-success">Добавить запись</button>
        </div>
    </form>

    <hr>

    <h1 class="my-4">
        <small>Список записей</small>
    </h1>

    <?php
        foreach ($data['posts'] as $post) {
            ?>
            <!-- Blog Post -->
            <div class="card mb-4">
                <div class="card-body">
                    <p class="card-text"><?= mb_substr($post['text'], 0, 100) ?>...</p>
                    <a href="/post/?id=<?= $post['id'] ?>" class="btn btn-primary">Читать полностью &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                    Размещено <?=date('Y-m-d H:i:s', $post['updated_at']) ?> пользователем <?=$post['author']?>
                </div>
            </div>
    <?php
        }
    ?>

    <?php if (!$data['pages']) { ?>
        <h3>Записи отсутствуют</h3>
    <?php } ?>


    <?php if (count($data['pages']) > 5) { ?>
<!--     Pagination-->
    <ul class="pagination justify-content-center mb-4">
        <?php
        foreach (range(1,$data['pages']) as $page) {
        ?>
            <li class="page-item <?= $data['current_page'] == $page ? 'active' : ''?>">
                <a class="page-link" href="/?page=<?=$page?>"><?=$page?></a>
            </li>
        <?php } ?>
    </ul>
    <?php } ?>

</div>



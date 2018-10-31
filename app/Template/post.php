<div class="col-md-8">

    <h1 class="my-4">
        <small>Запись №<?= $data['post']['id']?></small>
    </h1>

    <div class="card mb-4">
        <div class="card-body">
            <p class="card-text"><?= $data['post']['text'] ?></p>
        </div>
        <div class="card-footer text-muted">
            Размещено <?=date('Y-m-d H:i:s', $data['post']['updated_at']) ?> пользователем <?=$data['post']['author']?>
        </div>
    </div>

    <h2 class="my-4">
        <small>Комментарии (<?= count($data['comments'])?>)</small>
    </h2>

    <?php
        $errors = $_SESSION['comment_errors'] ?? null;
        $inputs = $_SESSION['inputs'] ?? null;
    ?>

    <form action="/comment/add" method="post">
        <h4>Добавить комментарий</h4>
        <input type="hidden" name="post_id" value="<?=$data['post']['id']?>">
        <form>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Имя автора" name="author" value="<?=$inputs['author'] ?? ''?>">
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
                <div class="col">
                    <input type="text" class="form-control" placeholder="Введите текст" name="text" value="<?=$inputs['text'] ?? ''?>"">
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
            </div>
            <br>
        <div class="form-group">
            <button class="btn btn-success">Добавить</button>
        </div>
    </form>

        <hr>

    <?php
        foreach ($data['comments'] as $comment) {
    ?>
        <div class="card mb-4">
            <div class="card-body">
                <p class="card-text"><?= $comment['text'] ?></p>
            </div>
            <div class="card-footer text-muted">
                Размещено <?=date('Y-m-d H:i:s', $comment['updated_at']) ?> пользователем <?=$comment['author']?>
            </div>
        </div>

    <?php } ?>

</div>
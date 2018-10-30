<!-- Blog Entries Column -->
<div class="col-md-8">

    <h1 class="my-4">
        <small>Список записей по запросу: <?=$data['search_str']?></small>
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


<!--    <!-- Pagination -->
<!--    <ul class="pagination justify-content-center mb-4">-->
<!--        <li class="page-item">-->
<!--            <a class="page-link" href="#">&larr; Older</a>-->
<!--        </li>-->
<!--        <li class="page-item disabled">-->
<!--            <a class="page-link" href="#">Newer &rarr;</a>-->
<!--        </li>-->
<!--    </ul>-->

</div>



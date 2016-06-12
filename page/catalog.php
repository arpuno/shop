<?php if ($_SESSION['login']): ?>
        <div class="dialog-wrap" id="dg-wrap">
          <div class="dg-window">
            <div class="dg-control-wrap">
              <span class="dg-close" id="dg-close"></span>
            </div>

            <span id="dg-edit">
              <div class="dg-title">
                Редактирование
              </div>
              <div class="dg-content">
                <div class="dg-input-wrap">
                  Название:<br>
                  <input class="dg-input" name="title">
                </div>

                <div class="dg-input-wrap">
                  Исполнитель:<br>
                  <input class="dg-input" name="artist">
                </div>

                <div class="dg-input-wrap">
                  Год:<br>
                  <input class="dg-input" name="year">
                </div>

                <div class="dg-input-wrap">
                  Жанр:<br>
                  <input class="dg-input" name="genre">
                </div>

                <div class="dg-input-wrap">
                  Состояние:<br>
                  <input class="dg-input" name="cond">
                </div>

                <div class="dg-input-wrap">
                  Цена:<br>
                  <input class="dg-input" name="price">
                </div>

                <div class="dg-input-wrap">
                  Количество:<br>
                  <input class="dg-input" name="amount">
                </div>
              </div>
              <div class="dg-commit-wrap">
                <span class="dg-commit-button" id="dg-edit-commit">сохранить</span>
              </div>
            </span>

            <span id="dg-remove">
              <div class="dg-title">
                Удаление товара
              </div>
              <div class="dg-content">
                Вы действительно хотите удалить товар?
              </div>
              <div class="dg-commit-wrap">
                <span class="dg-commit-button" id="dg-remove-commit">удалить</span>
              </div>
            </span>
          </div>
        </div>

<?php endif; ?>
        <div class="ct-nav-panel">
          <span class="ct-np-menu">
<?php foreach ($data['nav'] as $v) { ?>
            <a class="ct-np-link <?= $v[2] ? 'ct-np-link-active' : ''; ?>" href="/?p=catalog&s=<?= $sort; ?>&n=<?= $v[1]; ?>"><?= $v[0]; ?></a>
<?php } ?>
          </span>

<?php if ($_SESSION['login']): ?>
          <a class="ct-np-text-button" id="item-add" href="/?p=add-item">Добавить</a>
<?php endif; ?>
        </div>

        <div class="catalog">
          <span class="ct-table">
            <span class="ct-tr">
              <span class="ct-tc ct-cw-img">
              </span>

              <span class="ct-tc ct-cw-data">
                <?= $data['sort']['title'][1]; ?>
                <a class="ct-th-link" href="/?p=catalog&s=<?= $data['sort']['title'][0]; ?>">Название/Исполнитель</a>
              </span>

              <span class="ct-tc ct-cw-genre">
                <?= $data['sort']['genre'][1]; ?>
                <a class="ct-th-link" href="/?p=catalog&s=<?= $data['sort']['genre'][0]; ?>">Жанр</a>
              </span>

              <span class="ct-tc ct-cw-cond">
                <?= $data['sort']['cond'][1]; ?>
                <a class="ct-th-link" href="/?p=catalog&s=<?= $data['sort']['cond'][0]; ?>">Состояние</a>
              </span>

              <span class="ct-tc ct-cw-price">
                <?= $data['sort']['price'][1]; ?>
                <a class="ct-th-link" href="/?p=catalog&s=<?= $data['sort']['price'][0]; ?>">Цена</a>
              </span>

              <span class="ct-tc ct-cw-amount">
                <?= $data['sort']['amount'][1]; ?>
                <a class="ct-th-link" href="/?p=catalog&s=<?= $data['sort']['amount'][0]; ?>">Кол-во</a>
              </span>
            </span>
<?php foreach($data['cat'] as $v) { /* вывод строк */ ?>

            <span class="ct-tr <?= !$v['amount'] ? 'ct-outofstock' : ''; ?>" data-id="<?= $v['id']; ?>">
              <span class="ct-tc ct-cw-img">
                <img class="ct-img" src="style/image/record.png" width="77" height="53">
<?php if ($_SESSION['login']): ?>
                <div class="ct-control-wrap">
                  <span class="ct-control-button ct-edit"></span>
                  <span class="ct-control-button ct-remove"></span>
                </div>
<?php endif; ?>
              </span>

              <span class="ct-tc ct-cw-title">
                <div class="ct-title-wrap">
                  <span class="ct-title" data-val="<?= $v['title']; ?>"><?= $v['title']; ?></span>
                </div>

                <div class="ct-artist-wrap">
                  <span class="ct-artist" data-val="<?= $v['artist']; ?>"><?= $v['artist']; ?></span>
                 (<span class="ct-year" data-val="<?= $v['year']; ?>"><?= $v['year']; ?></span>)
                </div>
              </span>

              <span class="ct-tc ct-cw-genre">
                <span class="ct-genre" data-val="<?= $v['genre']; ?>"><?= $v['genre']; ?></span>
              </span>

              <span class="ct-tc ct-cw-cond">
                <span class="ct-cond" data-val="<?= $v['cond']; ?>"><?= $v['cond']; ?></span>
              </span>

              <span class="ct-tc ct-cw-price">
                <span class="ct-price" data-val="<?= $v['price']; ?>"><?= $v['price']; ?></span>$
              </span>

              <span class="ct-tc ct-cw-amount">
                <span class="ct-amount" data-val="<?= $v['amount']; ?>"><?= $v['amount'] ?: 'нет в<br>наличии'; ?></span>
              </span>
            </span>
<?php } ?>
          </span>

<?php if (!$data['cat']): ?>
          <div class="ct-noitems-wrap">
            <span class="ct-noitems-text">товаров нет :(</span>
          </div>
<?php endif; ?>
        </div>

        <div class="ct-nav-panel">
          <span class="ct-np-menu">
<?php foreach ($data['nav'] as $v) { ?>
            <a class="ct-np-link <?= $v[2] ? 'ct-np-link-active' : ''; ?>" href="/?p=catalog&s=<?= $sort; ?>&n=<?= $v[1]; ?>"><?= $v[0]; ?></a>
<?php } ?>
          </span>

<?php if ($_SESSION['login']): ?>
          <a class="ct-np-text-button" id="item-add" href="/?p=add-item">Добавить</a>
<?php endif; ?>
        </div>
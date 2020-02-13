<?php

$this->title = "История";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a class="btn-sm btn-warning" href="/admin/users/" title="Назадь">Назадь</a>
        </div>
        <h4 class="panel-title"><b>История удалении</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Пользователь</th>
                    <th>Описание</th>
                    <th>Дата и время</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach ($histories as $history) { $i++; ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$history->about?></td>
                        <td><?=$history->text?></td>
                        <td><?=date('H:i d.m.Y', strtotime($history->date_cr) )?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $programs
 */
?>
<?php
$this->assign('title', __('Programs'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Programs')],
]);
?>

<div class="card card-danger card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title">
            <i class="fas fa-trash text-danger"></i>
            <?= __('Elementos eliminados') ?>
        </h2>
        <div class="d-flex ml-auto">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control-sm',
                'templates' => ['inputContainer' => '{{content}}']
            ]); ?>
            <?= $this->Form->postLink(
                __('Vaciar Papelera'),
                ['action' => 'emptyTrash'],
                [
                    'class' => 'btn btn-danger btn-sm ml-2',
                    'escape' => false,
                    'confirm' => __("¿Seguro que desea vaciar la papelera?\nEsta acción no se puede revertir")
                ]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-chevron-left fa-fw"></i>' . __('Volver'),
                ['action' => 'index'],
                [
                    'class' => 'btn btn-primary btn-sm ml-2',
                    'escape' => false
                ]
            ) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('regime') ?></th>
                    <th><?= $this->Paginator->sort('abbr') ?></th>
                    <th><?= $this->Paginator->sort('area_id') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($programs->toArray())) : ?>
                    <tr>
                        <td colspan="7" class="text-muted">
                            <?= __('No hay elementos eliminados') ?>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($programs as $program) : ?>
                        <tr>
                            <td><?= $this->Number->format($program->id) ?></td>
                            <td><?= h($program->name) ?></td>
                            <td><?= h($program->regime) ?></td>
                            <td><?= h($program->abbr) ?></td>
                            <td><?= h($program->area->abbr) ?></td>
                            <td><?= h($program->deleted) ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink(__('Restaurar'), ['action' => 'restore', $area->id], ['class' => 'btn btn-xs btn-outline-info', 'escape' => false, 'confirm' => __('¿Seguro que desea restaurar este elemento?')]) ?>
                                <?= $this->Form->postLink(__('Eliminar'), ['action' => 'hardDelete', $area->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __("¿Seguro que desea eliminar permanentemente este elemento?\nEsta acción no se puede revertir")]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-flex flex-column flex-md-row">
        <div class="text-muted">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </div>
        <ul class="pagination pagination-sm mb-0 ml-auto">
            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
    <!-- /.card-footer -->
</div>
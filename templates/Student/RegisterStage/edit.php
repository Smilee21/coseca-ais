<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */

?>
<?php
$this->assign('title', __('Registro de Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Registro de Estudiante')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($student) ?>
    <div class="card-body">
        <?= $this->element('form/register', ['student' => $student]) ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Button->save() ?>
            <?= $this->Button->cancel(['url' => ['controller' => 'Stages', 'action' => 'index']]) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>
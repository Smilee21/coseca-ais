<?php

/**
 * @var \App\View\AppView $this
 */

use App\Utility\Tenants;
use Cake\Core\Configure;

$this->layout = 'CakeLte.login';
?>

<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg"><?= __('Registrar un nuevo estudiante') ?></p>
        <?= $this->Form->create() ?>
        <?= $this->Form->control('dni', [
            'placeholder' => __('Cedula'),
            'label' => false,
            'append' => '<i class="fas fa-id-card"></i>',
            'required' => true,
            'type' => 'text',
            'title' => __('Introduzca una cedula de identidad valida'),
            'minlength' => '7',
            'maxlength' => '8',
            'pattern' => '^[0-9]{7,8}$',
        ]) ?>
        <?= $this->Form->control('first_name', [
            'placeholder' => __('Nombres'),
            'label' => false,
            'append' => '<i class="fas fa-user"></i>',
            'required' => true,
        ]) ?>
        <?= $this->Form->control('last_name', [
            'placeholder' => __('Apellidos'),
            'label' => false,
            'append' => '<i class="fas fa-user"></i>',
            'required' => true,
        ]) ?>
        <?= $this->Form->control('email', [
            'placeholder' => __('Email'),
            'label' => false,
            'append' => '<i class="fas fa-envelope"></i>',
            'required' => true,
            'title' => __('Introduzca un correo electronico valido'),
            'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$',
        ]) ?>
        <?= $this->Form->control('tenant_filters.0.tenant_id', [
            'label' => false,
            'append' => '<i class="fas fa-flag"></i>',
            'required' => true,
            'options' => Tenants::getTenantList($this->getRequest()->getQuery()),
            'empty' => __('Seleccione Programa...'),
        ]) ?>
        <?= $this->Form->control('password', [
            'placeholder' => __('Contraseña'),
            'label' => false,
            'append' => '<i class="fas fa-lock"></i>',
            'required' => true,
            'minlength' => '4',
        ]) ?>
        <?= $this->Form->control('password_confirm', [
            'type' => 'password',
            'placeholder' => __('Confirmar contraseña'),
            'label' => false,
            'append' => '<i class="fas fa-lock"></i>',
            'required' => true,
            'minlength' => '4',
        ]) ?>

        <?php if (Configure::read('Users.reCaptcha.registration')) : ?>
            <div class="row mb-3">
                <div class="col">
                    <?= $this->User->addReCaptcha() ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-8">
                <?php if (Configure::read('Users.Tos.required')) : ?>
                    <?= $this->Form->control('tos', [
                        'label' => 'I agree to the <a href="#">terms</a>',
                        'type' => 'checkbox',
                        'custom' => true,
                        'escape' => false,
                        'required' => true,
                    ]) ?>
                <?php endif; ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control(__('Guardar'), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary btn-block',
                ]) ?>
            </div>
        </div>

        <?= $this->Form->end() ?>
        <?= $this->Html->link(__('Ya estoy registrado'), ['action' => 'login']) ?>
    </div>
    <!-- /.register-card-body -->
</div>
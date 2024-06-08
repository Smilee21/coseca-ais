<div class="row">

    <!-- Collapses -->
    <div class="col-lg-3">
        <div class="row" >
            <!-- Collapse Filters -->
            <div class="card text-black w-100" style="max-width: 18rem;">
                <div class="card-header card-primary card-outline">
                    <h4> 
                        <span class="d-flex w-100" data-toggle="collapse" href="#collapse-filters">                    
                            <?= __('Filtros') ?>
                            <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                        </span>
                    </h4>
                </div>
                <div class="card-body collapse show" id="collapse-filters">
                    <?= $this->Form->create(null, ['type' => 'GET', 'valueSources' => ['query', 'context']]) ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('area_id', ['label' => __('Area'), 'empty' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('program_id', ['label' => __('Programas'), 'empty' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('tenant_id', ['label' => __('Sede'), 'empty' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('status', ['label' => __('Estado')]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('state', ['label' => __('Fase')]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('lapse', ['label' => __('Lapso')]) ?>
                            </div>
                        </div>

                        <?= $this->Form->control('dni_order', ['label' => __('Ordenar por DNI'), 'options' => ['asc' => 'ASC', 'desc' => 'DESC'], 'empty' => true]) ?>

                        <?= $this->Button->search() ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
            <!-- End Collapse Filters -->
        </div>

        <div class="row">
            <!-- Collapse Show Fields -->
            <div class="card text-black w-100" style="max-width: 18rem;">
                    <div class="card-header card-warning card-outline ">
                        <h4> 
                            <span class="d-flex w-100" data-toggle="collapse" href="#collapse-fields">                    
                                <?= __('Campos') ?>
                                <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                            </span>
                        </h4>
                    </div>
                    <div class="card-body collapse hidden" id="collapse-fields">
                        <h4><?= _("TEST 1") ?></h4>
                    </div>
            </div>
            <!-- End Collapse Show Fields -->
        </div>

        <div class="row">
            <!-- Collapse Wrap -->
            <div class="card text-black w-100" style="max-width: 18rem;">
                    <div class="card-header card-success card-outline ">
                        <h4> 
                            <span class="d-flex w-100" data-toggle="collapse" href="#collapse-wrap">                    
                                <?= __('Agrupar') ?>
                                <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                            </span>
                        </h4>
                    </div>
                    <div class="card-body collapse hidden" id="collapse-wrap">
                        <h4><?= _("TEST 2") ?></h4>
                    </div>
            </div>
            <!-- End Collapse Wrap -->  
        </div>
    </div>
    
    <!-- Table of Reports -->
    <div class="col-lg-9">
        <div class="card card-primary card-outline table-responsive p-0 overflow-scroll" style="max-height: 1110px;">
            <div class="card-header d-flex flex-column flex-md-row align-items-center">
                <h4>Reporte</h4>
                <!-- Create Button Export To .CSV -->
                <div class="d-flex ml-auto">
                    <?= $this->Html->link(__('Exportar'), ['action' => '#export_csv'], ['class' => 'btn btn-success btn-sm ml-2']) ?>
                </div>
            </div>
            <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th><?= _('Área') ?></th>
                            <th><?= _('Programa')?></th>
                            <th><?= _('Cédula')?></th>
                            <th><?= _('Nombre')?></th>
                            <th><?= _('Apellido')?></th>
                            <th><?= _('Lapso')?></th> 
                            <th><?= _('Estatus')?></th> 
                            <th><?= _('Etapa')?></th>
                            <th><?= _('Institución')?></th> 
                            <th><?= _('Proyecto')?></th> 
                            <th><?= _('Tutor')?></th> 

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            //Debug | Remove on deployed
                            /* dd($results->toArray()); */ 
                        ?>
                        <?php foreach ($results as $result) : ?>
                            <tr>                                
                                <td><?= $result->student->tenant->program->area_label ?></td>
                                <td><?= $result->student->tenant->program->name ?></td>
                                <td><?= $result->student->dni ?></td>
                                <td><?= $result->student->first_name ?></td>
                                <td><?= $result->student->last_name ?></td>

                                <!-- Lapses not found -->
                                <td><?= /* $result->student */ _("LAPSO") ?></td>

                                <td><?= $result->status ?></td>
                                <td><?= $result->stage ?></td>

                                <!-- Institutions and Project not founds -->
                                <td><?= /* $result->student */ _('Institucion') ?></td>
                                <td><?= /* $result->student */ _('Proyecto') ?></td>

                                <!-- The adscriptions is an Array Object -->
                                <td><?php foreach ($result->student->student_adscriptions as $adscription) : ?> 
                                    <?= $adscription->tutor->name ?>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div>
    <!-- End Table of Reports -->

</div>
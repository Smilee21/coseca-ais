<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Table\Traits\BasicTableTrait;
use App\Utility\Stages;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * StudentStages Model
 *
 * @property \App\Model\Table\StudentsTable&\Cake\ORM\Association\BelongsTo $Students
 * @property \App\Model\Table\LapsesTable&\Cake\ORM\Association\BelongsTo $Lapses
 *
 * @method \App\Model\Entity\StudentStage newEmptyEntity()
 * @method \App\Model\Entity\StudentStage newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentStage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StudentStage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentStage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentStagesTable extends Table
{
    use BasicTableTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('student_stages');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Footprint.Footprint');

        $this->addBehavior('LastElement', [
            'fieldGroup' => 'student_id',
        ]);

        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Lapses', [
            'foreignKey' => 'lapse_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('student_id')
            ->notEmptyString('student_id');

        $validator
            ->scalar('stage')
            ->maxLength('stage', 255)
            ->requirePresence('stage', 'create')
            ->notEmptyString('stage');

        $validator
            ->integer('lapse_id')
            ->notEmptyString('lapse_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['student_id', 'stage'], 'This stage & student combination has already been used'));
        $rules->add($rules->existsIn('student_id', 'Students'), ['errorField' => 'student_id']);
        $rules->add($rules->existsIn('lapse_id', 'Lapses'), ['errorField' => 'lapse_id']);

        return $rules;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findByStudentStage(Query $query, array $options = []): Query
    {
        if (empty($options['stage'])) {
            throw new InvalidArgumentException('param stage is necessary');
        }

        if (empty($options['student_id'])) {
            throw new InvalidArgumentException('param student_id is necessary');
        }

        if ($options['stage'] instanceof StageField) {
            $options['stage'] = $options['stage']->value;
        }

        return $query->where([
            'student_id' => $options['student_id'],
            'stage' => $options['stage'],
        ]);
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findStageList(Query $query, array $options = []): Query
    {
        if (empty($options['student'])) {
            throw new InvalidArgumentException(
                __('param student_id is necessary, and has to be an {0} instance', Student::class)
            );
        }

        /** @var Student $student */
        $student = $options['student'];
        $listStages = $student->getStageFieldList();
        $keyField = $options['keyField'] ?? 'stage';

        $query->find('objectList', ['keyField' => $keyField])
            ->where(['student_id' => $student->id]);

        return $query->formatResults(function ($results) use ($listStages) {
            /** @var \Cake\Collection\CollectionInterface $results */
            $studentStages = $results->toArray();

            return array_map(function ($item) use ($studentStages) {
                return [
                    'stageField' => $item,
                    'studentStage' => $studentStages[$item->value] ?? null,
                ];
            }, $listStages);
        });

        return $query;
    }

    /**
     * @param array $options
     * @return StudentStage
     */
    public function create(array $options): StudentStage
    {
        if (empty($options['stage'])) {
            throw new InvalidArgumentException('param stage is necessary');
        }

        if (empty($options['student_id'])) {
            throw new InvalidArgumentException('param student_id is necessary');
        }

        if (empty($options['lapse_id'])) {
            throw new InvalidArgumentException('param lapse_id is necessary');
        }

        if (empty($options['status'])) {
            $options['status'] = StageField::from($options['stage'])->getDefaultStatus()->value ?? StageStatus::WAITING->value;
        }

        $studentStage = $this->newEntity($options);

        return $this->saveOrFail($studentStage);
    }

    /**
     * @param StudentStage $entity
     * @param string $newStatus
     * @return StudentStage
     */
    public function updateStatus(StudentStage $entity, string $newStatus): StudentStage
    {
        $entity->status = $newStatus;

        return $this->saveOrFail($entity);
    }

    /**
     * @param StudentStage $entity
     * @param StageStatus $newStatus
     * @param boolean $forced
     * @return StudentStage|bool
     */
    public function close(StudentStage $entity, StageStatus $newStatus, bool $forced = false): StudentStage|bool
    {
        try {
            return $this->closeOrFail($entity, $newStatus, $forced);
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * @param StudentStage $entity
     * @param StageStatus $newStatus
     * @param boolean $forced
     * @return StudentStage|null
     */
    public function closeOrFail(StudentStage $entity, StageStatus $newStatus, bool $forced = false): ?StudentStage
    {
        $this->updateStatus($entity, $newStatus->value);

        return $this->createNext($entity, $forced);
    }

    /**
     * @param StudentStage $entity
     * @param boolean $forced
     * @return StudentStage|null
     */
    public function createNext(StudentStage $entity, bool $forced = false): ?StudentStage
    {
        if ($forced || in_array($entity->status_obj, [StageStatus::SUCCESS])) {
            if (empty($entity->student)) {
                $this->loadInto($entity, ['Students']);
            }
            $nextStageField = Stages::getNextStageField($entity->stage_obj, $entity->student->type_obj);

            if ($nextStageField) {
                return $this->create([
                    'stage' => $nextStageField->value,
                    'student_id' => $entity->student_id,
                    'lapse_id' => $entity->lapse_id,
                ]);
            }
        }

        return null;
    }
}

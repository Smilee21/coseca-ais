<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Filters cell
 */
class FiltersCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected $_validCellOptions = [];

    protected $Students;

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->Students = $this->fetchTable('Students');
        $this->viewBuilder()->addHelper('Button');
    }

    /**
     * @param bool $isFiltered
     * @param string $filterKey
     * @return void
     */
    public function adminStudents(bool $isFiltered = false, string $filterKey = 'f')
    {
        $tenants = $this->Students->Tenants->find('listLabel');
        $lapses = $this->Students->Lapses->find('list', [
            'keyField' => 'name',
            'valueField' => 'name',
        ]);

        $this->set(compact('tenants', 'lapses'));
        $this->set(compact('isFiltered', 'filterKey'));
    }

    /**
     * @param bool $isFiltered
     * @param string $filterKey
     * @return void
     */
    public function adminPrograms(bool $isFiltered = false, string $filterKey = 'f')
    {
        $this->set(compact('isFiltered', 'filterKey'));
    }

    /**
     * @param bool $isFiltered
     * @param string $filterKey
     * @return void
     */
    public function adminInstitutions(bool $isFiltered = false, string $filterKey = 'f')
    {
        $this->set(compact('isFiltered', 'filterKey'));
    }

    /**
     * @param bool $isFiltered
     * @param string $filterKey
     * @return void
     */
    public function adminTutors(bool $isFiltered = false, string $filterKey = 'f')
    {
        $this->set(compact('isFiltered', 'filterKey'));
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\ProgramArea;
use Cake\ORM\Entity;

/**
 * Program Entity
 *
 * @property int $id
 * @property string $name
 * @property string $area
 * @property string $regime
 * @property string $abbr
 *
 * @property \App\Model\Entity\Tenant[] $tenants
 */
class Program extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'area' => true,
        'regime' => true,
        'abbr' => true,
        'tenants' => true,
    ];

    public function _getAreaLabel()
    {
        return ProgramArea::from($this->area)->label();
    }

}

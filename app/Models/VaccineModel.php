<?php

namespace App\Models;

use CodeIgniter\Model;

class VaccineModel extends Model
{
    protected $table = 'vaccines';
    protected $primaryKey = 'id';

    /**
     * Fetch vaccines with due stage and description
     */
    public function getVaccinesGroupedByStage()
    {
        $rows = $this->db->table('stage_vaccines sv')
            ->select([
                'vs.id AS stage_id',
                'vs.stage_label',
                'v.name',
                'sv.dose_label',
                'sv.display_order'
            ])
            ->join('vaccination_stages vs', 'vs.id = sv.vaccination_stage_id')
            ->join('vaccines v', 'v.id = sv.vaccine_id')
            ->orderBy('vs.id', 'ASC')
            ->orderBy('sv.display_order', 'ASC')
            ->get()
            ->getResultArray();

        // Group vaccines by stage
        $grouped = [];
        foreach ($rows as $row) {
            $label = $row['name'];
            if (!empty($row['dose_label'])) {
                $label .= ' - ' . $row['dose_label'];
            }

            $grouped[$row['stage_id']]['stage_label'] = $row['stage_label'];
            $grouped[$row['stage_id']]['vaccines'][] = $label;
        }

        return $grouped;
    }
}

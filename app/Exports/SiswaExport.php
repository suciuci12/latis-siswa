<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromCollection, WithHeadings
{
    protected $lembaga_id;
    protected $search;

    public function __construct($lembaga_id, $search)
    {
        $this->lembaga_id = $lembaga_id;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Siswa::query();

        if ($this->lembaga_id) {
            $query->where('lembaga_id', $this->lembaga_id);
        }

        if ($this->search) {
            $s = $this->search;
            $query->where(function($q) use ($s) {
                $q->where('nis','like',"%$s%")
                  ->orWhere('nama','like',"%$s%");
            });
        }

        return $query->get(['nis','nama','email','lembaga_id']);
    }

    public function headings(): array
    {
        return ['NIS','Nama','Email','Lembaga ID'];
    }
}

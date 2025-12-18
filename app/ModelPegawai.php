<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPegawai extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama', 'email', 'bidang', 'alamat'];
    protected $useTimestamps    = false;

    public function cari($katakunci)
    {
        $builder = $this->builder(); // ✅ PENTING

        $arr_katakunci = explode(' ', $katakunci);

        foreach ($arr_katakunci as $kata) {
            $builder->groupStart()
                    ->like('nama', $kata)
                    ->orLike('email', $kata)
                    ->orLike('alamat', $kata)
                    ->groupEnd();
        }

        return $builder;
    }
}

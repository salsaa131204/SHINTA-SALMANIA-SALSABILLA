<?php

namespace App\Controllers;

use App\Models\ModelPegawai;

class Pegawai extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ModelPegawai();
    }

    public function index()
    {
        $jumlahBaris = 5;
        $katakunci = $this->request->getGet('katakunci');

        if ($katakunci) {
            $pencarian = $this->model->cari($katakunci);
        } else {
            $pencarian = $this->model;
        }

        $data = [
            'katakunci'   => $katakunci,
            'dataPegawai' => $pencarian->orderBy('id', 'desc')->paginate($jumlahBaris),
            'pager'       => $this->model->pager,
            'nomor'       => ($this->request->getVar('page') == 1) ? 0 : $this->request->getVar('page')
        ];

        return view('pegawai_view', $data);
    }

    public function simpan()
    {
        $validasi = \Config\Services::validation();

        $aturan = [
            'nama' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Nama harus diisi',
                    'min_length' => 'Nama minimal 5 karakter'
                ]
            ],
            'email' => [
                'rules'  => 'required|min_length[5]|valid_email',
                'errors' => [
                    'required'   => 'Email harus diisi',
                    'min_length' => 'Email minimal 5 karakter',
                    'valid_email'=> 'Email tidak valid'
                ]
            ],
            'alamat' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Alamat harus diisi',
                    'min_length' => 'Alamat minimal 5 karakter'
                ]
            ]
        ];

        if (! $this->validate($aturan)) {
            return json_encode([
                'sukses' => false,
                'error'  => $validasi->listErrors()
            ]);
        }

        $data = [
            'id'     => $this->request->getPost('id'),
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'bidang' => $this->request->getPost('bidang'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $this->model->save($data);

        return json_encode([
            'sukses' => true,
            'pesan'  => 'Data pegawai berhasil disimpan'
        ]);
    }

    public function edit($id)
    {
        return json_encode($this->model->find($id));
    }

    public function hapus($id)
    {
        $this->model->delete($id);
        return redirect()->to(site_url('pegawai'));
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CustomerController extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        helper(['url', 'form']); 
    }

    /**
     * Menampilkan daftar customer dengan pagination dan fungsionalitas pencarian.
     */
    public function index()
    {
        $perPage = 10;
        $search_query = $this->request->getGet('search');

        // PENTING: Buat instance model baru di sini untuk memastikan query selalu bersih
        // dari sisa filter pada request sebelumnya. Ini adalah kunci utama perbaikan.
        $model = new CustomerModel(); 

        // Terapkan filter LIKE jika ada kata kunci pencarian
        if ($search_query) {
            $model->groupStart()
                  ->like('id_customer', $search_query)
                  ->orLike('nama_customer', $search_query)
                  ->orLike('no_hp', $search_query)
                  ->orLike('email', $search_query)
                  ->groupEnd();
        }

        $data = [
            'title'        => 'Data Customer',
            'customers'    => $model->paginate($perPage, 'customers'),
            'pager'        => $model->pager,
            'search_query' => $search_query,
            'active_menu'  => 'customer',
        ];
        
        return view('customer/index', $data);
    }

    /**
     * Menampilkan form untuk membuat customer baru.
     */
    public function create()
    {
        $data = [
            'title'      => 'Tambah Customer Baru',
            'validation' => \Config\Services::validation(),
        ];
        return view('customer/create', $data);
    }

    /**
     * Menyimpan data customer baru ke database.
     */
    public function store()
    {
        if (!$this->validate($this->customerModel->getValidationRules())) {
            return redirect()->back()->withInput();
        }

        $this->customerModel->save([
            'id_customer'   => $this->request->getPost('id_customer'),
            'nama_customer' => $this->request->getPost('nama_customer'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
        ]);

        session()->setFlashdata('success', 'Data customer baru berhasil ditambahkan.');
        return redirect()->to('/customer');
    }

    /**
     * Menampilkan form untuk mengedit data customer.
     */
    public function edit($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            throw new PageNotFoundException('Data customer dengan ID ' . $id . ' tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Data Customer',
            'customer'   => $customer,
            'validation' => \Config\Services::validation(),
        ];
        return view('customer/edit', $data);
    }

    /**
     * Memperbarui data customer di database.
     */
    public function update($id)
    {
        $oldCustomer = $this->customerModel->find($id);
        if (!$oldCustomer) {
            throw new PageNotFoundException('Data customer yang akan diperbarui tidak ditemukan.');
        }
        
        $rules = $this->customerModel->getValidationRules();
        $rules['id_customer'] = 'required|max_length[50]'; 

        if (strtolower($this->request->getPost('email')) === strtolower($oldCustomer['email'])) {
            $rules['email'] = 'permit_empty|valid_email';
        } else {
            $rules['email'] = 'permit_empty|valid_email|is_unique[customer.email,id,' . $id . ']';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->customerModel->update($id, [
            'id_customer'   => $this->request->getPost('id_customer'),
            'nama_customer' => $this->request->getPost('nama_customer'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
        ]);

        session()->setFlashdata('success', 'Data customer berhasil diperbarui.');
        return redirect()->to('/customer');
    }

    /**
     * Menghapus data customer dari database.
     */
    public function delete($id)
    {
        if (!$this->customerModel->find($id)) {
            session()->setFlashdata('error', 'Gagal menghapus: Data customer tidak ditemukan.');
            return redirect()->to('/customer');
        }

        $this->customerModel->delete($id);
        
        session()->setFlashdata('success', 'Data customer berhasil dihapus.');
        return redirect()->to('/customer');
    }
}
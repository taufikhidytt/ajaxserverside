<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends Back_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model', 'users');
    }

    public function index()
    {
        $data['data'] = $this->users->get();
        $this->load->view('users/index', $data);
    }

    public function add()
    {
        // $this->_validation();

        $this->form_validation->set_rules('nama_lengkap', 'Nama lengkap', 'required|is_unique[users.nama_lengkap]|min_length[2]');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $error = array(
                'nama_lengkap'      => form_error('nama_lengkap'),
                'username'      => form_error('username'),
                'password'      => form_error('password'),
                'jenis_kelamin'      => form_error('jenis_kelamin'),
                'alamat'      => form_error('alamat'),
            );
            return $this->sendError('Gagal Simpan data.',  $error);
        } else {
            $data = [
                'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap')),
                'username' => htmlspecialchars($this->input->post('username')),
                'password' => $this->input->post('password'),
                'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
                'alamat' => htmlspecialchars($this->input->post('alamat')),
            ];
            $this->users->add($data);

            if ($this->db->affected_rows() > 0) {
                return $this->sendSuccess('', 'Congratulations, you have successfully saved the data!');
            } else {
                return $this->sendError('Gagal Simpan Data');
            }
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('nama_lengkap', 'Nama lengkap', 'required|is_unique[users.nama_lengkap]|min_length[2]');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $error = array(
                'nama_lengkap'      => form_error('nama_lengkap'),
                'username'      => form_error('username'),
                'password'      => form_error('password'),
                'jenis_kelamin'      => form_error('jenis_kelamin'),
                'alamat'      => form_error('alamat'),
            );
            return $this->sendError('Gagal Simpan data.',  $error);
        } else {
            $where = [
                'id_users' => $this->input->post('id'),
            ];

            $data = [
                'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap')),
                'username' => htmlspecialchars($this->input->post('username')),
                'password' => $this->input->post('password'),
                'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
                'alamat' => htmlspecialchars($this->input->post('alamat')),
            ];
            $this->users->update($where, $data);

            if ($this->db->affected_rows() > 0) {
                return $this->sendSuccess('', 'Congratulations, you have successfully saved the data!');
            } else {
                return $this->sendError('Gagal Simpan Data');
            }
        }
    }

    public function delete()
    {
        $data = $this->input->post(null, true);
        $this->users->del($data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Selamat Anda Berhasil Menghapus Data');
            redirect('users');
        } else {
            $this->session->set_flashdata('error', 'Anda Gagal Menghapus Data');
            redirect('users');
        }
    }

    private function _validation()
    {
        $id = $this->input->post('id');;
        $nama_lengkap = $this->input->post('nama_lengkap');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $alamat = $this->input->post('alamat');

        $data = array();
        $data['input'] = array();
        $data['message_error'] = array();
        $data['status'] = true;

        if ($id == null) {
            $query = $this->db->query("SELECT nama_lengkap FROM users WHERE nama_lengkap = '$nama_lengkap'");
        } else {
            $query = $this->db->query("SELECT nama_lengkap FROM users WHERE nama_lengkap = '$nama_lengkap' AND id_users != '$id'");
        }

        if ($nama_lengkap == '') {
            $data['input'][] = 'nama_lengkap';
            $data['message_error'][] = 'nama lengkap tidak boleh kosong';
            $data['status'] = false;
        } elseif (strlen($nama_lengkap) < 3) {
            $data['input'][] = 'nama_lengkap';
            $data['message_error'][] = 'nama lengkap minimal 4 karakter';
            $data['status'] = false;
        } elseif ($query->num_rows() > 0) {
            $data['input'][] = 'nama_lengkap';
            $data['message_error'][] = 'nama lengkap sudah ada';
            $data['status'] = false;
        }

        if ($username == '') {
            $data['input'][] = 'username';
            $data['message_error'][] = 'username tidak boleh kosong';
            $data['status'] = false;
        }

        if ($password == '') {
            $data['input'][] = 'password';
            $data['message_error'][] = 'password tidak boleh kosong';
            $data['status'] = false;
        }

        if ($jenis_kelamin == '') {
            $data['input'][] = 'jenis_kelamin';
            $data['message_error'][] = 'jenis kelamin tidak boleh kosong';
            $data['status'] = false;
        }

        if ($alamat == '') {
            $data['input'][] = 'alamat';
            $data['message_error'][] = 'alamat tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->from('users');
        if ($id) {
            $this->db->where('id_users', $id);
        }
        return $this->db->get();
    }

    public function add($data)
    {
        $this->db->insert('users', $data);
    }

    public function update($where, $data)
    {
        $this->db->where($where);
        $this->db->update('users', $data);
    }

    public function del($data)
    {
        $this->db->where('id_users', $data['id']);
        $this->db->delete('users');
    }
}

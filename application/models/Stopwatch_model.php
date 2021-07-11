<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Stopwatch_model
 *
 * This Model for ...
 *
 * @package        CodeIgniter
 * @category    Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Stopwatch_model extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
    }

    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    public function index()
    {
        //
    }

    public function all()
    {
        return $this->db->get('stopwatch');
    }

    public function getWhere($where)
    {
        $this->db->where($where);
        return $this->db->get('stopwatch');
    }

    public function insert($data)
    {
        return $this->db->insert('stopwatch', $data);
    }

    public function update($tanggal, $data)
    {
        $this->db->where('start', $tanggal);
        return $this->db->update('stopwatch', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('stopwatch');
    }

    public function sumWhere($kategori)
    {
        $this->db->select_sum('period');
        $this->db->where('kategori', $kategori);
        return $query = $this->db->get('stopwatch');
    }

    // ------------------------------------------------------------------------

}

/* End of file Stopwatch_model.php */
/* Location: ./application/models/Stopwatch_model.php */

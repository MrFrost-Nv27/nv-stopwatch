<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Kategori_model
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

class Kategori_model extends CI_Model
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
        return $this->db->get('kategori');
    }

    public function getWhere($where)
    {
        $this->db->where($where);
        return $this->db->get('kategori');
    }

    public function kategori()
    {
        return $this->db->query("SELECT * FROM kategori WHERE aktif = 'Y'");
    }

    // ------------------------------------------------------------------------

}

/* End of file Kategori_model.php */
/* Location: ./application/models/Kategori_model.php */

<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Period_model
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

class Period_model extends CI_Model
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
    public function jumlahPeriod($s, $ms = false)
    {
        $data = [];
        $ms   = $ms;
        if ($ms = true) {
            $s = round($s / 1000);
        }
        if ($s < 60) {
            $data['time'] = $s;
            $data['prop'] = 'Detik';
        } elseif ($s > 60) {
            if ($s < 3600) {
                $data['time'] = $s / 60;
                $data['prop'] = 'Menit';
                $data['time'] = round($data['time']);
            } elseif ($s > 3600) {
                $data['time'] = $s / 3600;
                $data['prop'] = 'Jam';
                $data['time'] = round($data['time'], 1);
            }
        }
        return $data;
    }

    // ------------------------------------------------------------------------

}

/* End of file Period_model.php */
/* Location: ./application/models/Period_model.php */

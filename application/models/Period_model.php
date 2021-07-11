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
    public function jumlahPeriod($ktg)
    {
        $data = [];
        $ms   = $this->Stopwatch_model->sumWhere($ktg)->row_array()['period'];
        if ($ms < 60000) {
            $data['time'] = $ms / 1000;
            $data['prop'] = 'Detik';
            $data['time'] = round($data['time']);
        } elseif ($ms > 60000) {
            if ($ms < 3600000) {
                $data['time'] = $ms / 60000;
                $data['prop'] = 'Menit';
                $data['time'] = round($data['time']);
            } elseif ($ms > 3600000) {
                $data['time'] = $ms / 3600000;
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

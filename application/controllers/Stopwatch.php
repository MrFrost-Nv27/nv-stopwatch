<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Controller Stopwatch
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Stopwatch extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Stopwatch_model');
        $this->load->model('Kategori_model');
        $this->load->model('Period_model');
    }

    public function index()
    {
        $data['datatimer'] = $this->Stopwatch_model->all()->result_array();
        $data['kategori']  = $this->Kategori_model->kategori();
        $this->load->view('stopwatch/home', $data);
        $this->load->view('stopwatch/ajax');
    }

    public function datatimer()
    {
        $datatimer = $this->Stopwatch_model->all()->result_array();
        $no        = 1;
        foreach ($datatimer as $timer) {
            $seconds = $timer['start'] / 1000;
            $tbody   = array();
            $tbody[] = $no++;
            $tbody[] = $timer['kategori'];
            $tbody[] = date("d-F-Y G:i:s", $seconds);
            $tbody[] = $this->formatMilliseconds($timer['period']);
            $aksi    = "<a href='javascript:void(0)' id='tombolhapus' role='button' data-idrow=" . $timer['id'] . " ><i class='fa fa-trash'/></a>";
            $tbody[] = $aksi;
            $data[]  = $tbody;
        }

        if ($datatimer) {
            echo json_encode(array('data' => $data));
        } else {
            echo json_encode(array('data' => 0));
        }
    }

    public function recins()
    {
        // id yang telah diparsing pada ajax ajax.php data{id:id}
        $data['kategori'] = $this->input->post('kategori');
        $data['start']    = $this->input->post('tanggal');
        $data['period']   = $this->input->post('waktu');

        $this->Stopwatch_model->insert($data);
        echo json_encode($data);
    }

    public function recupd()
    {
        // id yang telah diparsing pada ajax ajax.php data{id:id}
        $tanggal        = $this->input->post('tanggal');
        $data['period'] = $this->input->post('waktu');

        $editdata = $this->Stopwatch_model->update($tanggal, $data);
        echo json_encode($editdata);
    }

    public function recdel()
    {
        // id yang telah diparsing pada ajax ajax.php data{id:id}
        $id = $this->input->post('idrecord');

        $hapusdata = $this->Stopwatch_model->delete($id);
        echo json_encode($hapusdata);
    }

    public function formatMilliseconds($milliseconds)
    {
        $seconds      = floor($milliseconds / 1000);
        $minutes      = floor($seconds / 60);
        $hours        = floor($minutes / 60);
        $milliseconds = $milliseconds % 1000;
        $seconds      = $seconds % 60;
        $minutes      = $minutes % 60;

        $format = '%u:%02u:%02u';
        $time   = sprintf($format, $hours, $minutes, $seconds);
        return $time;
    }
}

/* End of file Stopwatch.php */
/* Location: ./application/controllers/Stopwatch.php */

<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Extending The Controller
 *
 * @author Rudy R
 *
 */
/* load the MX_Loader class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{
    public function __construct()
    {
        // $this->load->library('session');
        parent::__construct();
    }

    /**
     * Layouting for Backend
     */
    public function AdminLayout($data = [], $view = null)
    {
        //$this->load->view('layouts/admin/_header', $data);
        // AuthmenuByurl();
        if ($view) {
            $data["content"] = $view;
            $this->load->view('layouts/admin/_content', $data);
        }
        //$this->load->view('layouts/admin/_footer');
    }

    /**
     * Layouting for Frintend
     */
    public function FrontLayout($data = [], $view = null)
    {
        //$this->load->view('layouts/admin/_header', $data);

        if ($view) {
            $data["content"] = $view;
            $this->load->view('layouts/main/_content', $data);
        }
        //$this->load->view('layouts/admin/_footer');
    }

    public function cleanLayout($data = [], $view = null)
    {
        if ($view) {
            $data["content"] = $view;
            $this->load->view('layouts/main/_cleancontent', $data);
        }
    }

    public function dd($data = null)
    {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
        die();
    }
}

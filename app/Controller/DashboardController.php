<?php

namespace App\Controller;

require_once '../Database/Databases.php';
require_once 'UriController.php';
include_once '../protected.php';
date_default_timezone_set('Asia/Jakarta');

use App\Database\Databases;
use App\Controller\UriController;

class DashboardController
{
    public function __construct()
    {
        $this->db = new Databases();
        $this->home = new UriController();
    }

    public function zeusEmp()
    {
        // Zeus
        $sqlActive = "SELECT * FROM company WHERE company_name='PT Zeus Kimiatama Indonesia'";
        $mysqli = $this->db->connect();
        $result = $mysqli->query($sqlActive);
        $fetch = $result->fetch_object();
        return $fetch->IdCompany;
    }
    public function acmeEmp()
    {
        // Acme
        $sqlActive = "SELECT * FROM company WHERE company_name='PT Acme Indonesia'";
        $mysqli = $this->db->connect();
        $result = $mysqli->query($sqlActive);
        $fetch = $result->fetch_object();
        return $fetch->IdCompany;
    }
    public function pkmEmp()
    {
        // Pkm
        $sqlActive = "SELECT * FROM company WHERE company_name='PT Powerindo Kimia Mineral'";
        $mysqli = $this->db->connect();
        $result = $mysqli->query($sqlActive);
        $fetch = $result->fetch_object();
        return $fetch->IdCompany;
    }
    public function mwaEmp()
    {
        // mwa
        $sqlActive = "SELECT * FROM company WHERE company_name='PT Miltonia Warna Asia'";
        $mysqli = $this->db->connect();
        $result = $mysqli->query($sqlActive);
        $fetch = $result->fetch_object();
        return $fetch->IdCompany;
    }

    public function statistikTotalKaryawan()
    {
        // total karyawan aktif
        $sqlActive = "SELECT COUNT(id_employee) AS active FROM employee WHERE is_resigned=0";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();
        // total karyawan resign
        $sqlActive = "SELECT COUNT(id_employee) AS resigned FROM employee WHERE is_resigned=1";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchResign = $resultActive->fetch_object();
        // total karyawan active zeus
        $zeus = $this->zeusEmp();
        $sqlActive = "SELECT COUNT(id_employee) AS zeus FROM employee WHERE is_resigned=0 AND comp_id=$zeus";
        $mysqli = $this->db->connect();
        $resultZeus = $mysqli->query($sqlActive);
        $fetchZeus = $resultZeus->fetch_object();
        // total karyawan active Acme
        $acme = $this->acmeEmp();
        $sqlActive = "SELECT COUNT(id_employee) AS acme FROM employee WHERE is_resigned=0 AND comp_id=$acme";
        $mysqli = $this->db->connect();
        $resultAcme = $mysqli->query($sqlActive);
        $fetchAcme = $resultAcme->fetch_object();
        // total karyawan active pkm
        $pkm = $this->pkmEmp();
        $sqlActive = "SELECT COUNT(id_employee) AS pkm FROM employee WHERE is_resigned=0 AND comp_id=$pkm";
        $mysqli = $this->db->connect();
        $resultPkm = $mysqli->query($sqlActive);
        $fetchPkm = $resultPkm->fetch_object();
        // total karyawan active mwa
        $mwa = $this->mwaEmp();
        $sqlActive = "SELECT COUNT(id_employee) AS mwa FROM employee WHERE is_resigned=0 AND comp_id=$mwa";
        $mysqli = $this->db->connect();
        $resultMwa = $mysqli->query($sqlActive);
        $fetchMwa = $resultMwa->fetch_object();

        $data[0]['label'] = "PT Zeus kimiatama Indonesia";
        $data[0]['value'] = $fetchZeus->zeus ? $fetchZeus->zeus : 0;
        $data[0]['color'] = "#00a8f3";
        $data[1]['label'] = "PT Acme Indonesia";
        $data[1]['value'] = $fetchAcme->acme ? $fetchAcme->acme : 0;
        $data[1]['color'] = "#00ffdc";
        $data[2]['label'] = "PT Powerindo Kimia mineral";
        $data[2]['value'] = $fetchPkm->pkm ? $fetchPkm->pkm : 0;
        $data[2]['color'] = "#ff7f27";
        $data[3]['label'] = "PT Miltonia Warna Asia";
        $data[3]['value'] = $fetchMwa->mwa ? $resultMwa->mwa : 0;
        $data[3]['color'] = "#f80032";
        // $data[4]['label'] = "PT Rochtec Tirta Energi";
        // $data[4]['value'] = 15;
        // $data[4]['color'] = "#90d2d8";

        $response = [];
        $response['data'] = $data;
        $response['total_active'] = $fetchActive->active;
        $response['total_resign'] = $fetchResign->resigned;
        return $response;
    }

    public function isLakiLaki()
    {
        //statistik karyawan laki-laki aktif
        $sqlActive = "SELECT COUNT(id_employee) AS activeMan FROM employee JOIN emp_personal ON emp_personal.emp_id=employee.id_employee WHERE is_resigned=0 AND gender='Laki-Laki'";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();

        return $fetchActive->activeMan;
    }
    public function isPerempuan()
    {
        //statistik karyawan perempuan aktif
        $sqlActive = "SELECT COUNT(id_employee) AS activeWomen FROM employee JOIN emp_personal ON emp_personal.emp_id=employee.id_employee WHERE is_resigned=0 AND gender='Perempuan'";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();

        return $fetchActive->activeWomen;
    }

    public function statistikGender()
    {
        $data[0]['label'] = "Laki-Laki";
        $data[0]['value'] = $this->isLakiLaki();
        $data[0]['color'] = "#00a8f3";
        $data[1]['label'] = "Perempuan";
        $data[1]['value'] = $this->isPerempuan();
        $data[1]['color'] = "#00ffdc";

        return $data;
    }

    public function isKartap()
    {
        // statistik karyawan tetap, aktif
        $sqlActive = "SELECT COUNT(id_employee) AS kartap FROM employee WHERE is_resigned=0 AND status_emp=1";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();
        return $fetchActive->kartap;
    }
    public function isKontrak()
    {
        // statistik karyawan kontrak, aktif
        $sqlActive = "SELECT COUNT(id_employee) AS kontrak FROM employee WHERE is_resigned=0 AND status_emp=2";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();
        return $fetchActive->kontrak;
    }
    public function isHarian()
    {
        // statistik karyawan harian, aktif
        $sqlActive = "SELECT COUNT(id_employee) AS harian FROM employee WHERE is_resigned=0 AND status_emp=3";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();
        return $fetchActive->harian;
    }
    public function isOutSource()
    {
        // statistik karyawan outsource, aktif
        $sqlActive = "SELECT COUNT(id_employee) AS os FROM employee WHERE is_resigned=0 AND status_emp=4";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();
        return $fetchActive->os;
    }
    public function isIntern()
    {
        // statistik karyawan magang intern, aktif
        $sqlActive = "SELECT COUNT(id_employee) AS intern FROM employee WHERE is_resigned=0 AND status_emp=5";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();
        return $fetchActive->intern;
    }
    public function isProbation()
    {
        // statistik karyawan probation, aktif
        $sqlActive = "SELECT COUNT(id_employee) AS probation FROM employee WHERE is_resigned=0 AND status_emp=6";
        $mysqli = $this->db->connect();
        $resultActive = $mysqli->query($sqlActive);
        $fetchActive = $resultActive->fetch_object();
        return $fetchActive->probation;
    }

    public function statistikStatus()
    {
        $data[0]['label'] = "Karyawan Tetap";
        $data[0]['value'] = $this->isKartap();
        $data[0]['color'] = "#00a8f3";
        $data[1]['label'] = "Kontrak";
        $data[1]['value'] = $this->isKontrak();
        $data[1]['color'] = "#00ffdc";
        $data[2]['label'] = "Harian";
        $data[2]['value'] = $this->isHarian();
        $data[2]['color'] = "#f80032";
        $data[3]['label'] = "Out Source";
        $data[3]['value'] = $this->isOutSource();
        $data[3]['color'] = "#ff7f27";
        $data[4]['label'] = "Magang/Intern";
        $data[4]['value'] = $this->isIntern();
        $data[4]['color'] = "#b8bff7";
        $data[5]['label'] = "Probation";
        $data[5]['value'] = $this->isProbation();
        $data[5]['color'] = "#ffeb00";


        return $data;
    }
}

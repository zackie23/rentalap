<?php

    date_default_timezone_set('Asia/Hong_Kong');
    $seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $hari = date("w");
    $hari_ini = $seminggu[$hari];
    
    $tgl_sekarang = date("Y-m-d");
    $tgl_skrg = date("d");
    $bln_sekarang = date("m");
    $thn_sekarang = date("Y");
    $jam_sekarang = date("H:i:s");
    $date_time = date("Y-m-d H:i:s");
    
    $nama_bln = array(1 => "Januari", "Februari", "Maret", "April", "Mei",
        "Juni", "Juli", "Agustus", "September",
        "Oktober", "November", "Desember");

    function tanggal_sql($date) {
        $exp = explode('/', $date);
        if (count($exp) == 3) {
            $date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
        }
        return $date;
    }
    
    function tanggal_str($date) {
        $exp = explode('-', $date);
        if (count($exp) == 3) {
            $date = $exp[2] . '/' . $exp[1] . '/' . $exp[0];
        }
        return $date;
    }

    

    function getBulan($bulan){
        if($bulan == "01"){
            return "Januari";
        }elseif($bulan == "02"){
            return "Februari";
        }elseif($bulan == "03"){
            return "Maret";
        }elseif($bulan == "04"){
            return "April";
        }elseif($bulan == "05"){
            return "Mei";
        }elseif($bulan == "06"){
            return "Juni";
        }elseif($bulan == "07"){
            return "Juli";
        }elseif($bulan == "08"){
            return "Agustus";
        }elseif($bulan == "09"){
            return "September";
        }elseif($bulan == "10"){
            return "Oktober";
        }elseif($bulan == "11"){
            return "November";
        }elseif($bulan == "12"){
            return "Desember";
        }
    }

    function tgl_indo($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = getBulan(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

    function getBulan1($bln) {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    function getChecklist($obj,$default){
        if($obj == "Y" && $default == "sesuai"){
            return "check_box.jpg";
        }elseif($obj == "N" && $default == "tidak_sesuai"){
            return "check_box.jpg";
        }else{
            return "empty_box.jpg";
        }
    }

?>
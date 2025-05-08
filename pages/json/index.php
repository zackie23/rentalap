<?php
error_reporting(0);
session_start();
defined('_NOT_DIRECT') || define('_NOT_DIRECT', 1);

include '../../ch0npi9/koneksi.php';
include '../../ch0npi9/enkripsi.php';
include '../../ch0npi9/library.php';

$module = $_GET['module'];

$search = strtoupper($_POST['search']['value']);
$start = $_POST['start'];
$length = $_POST['length'];
$orderType = $_POST['order'][0]['dir'];
$orderByColumn = $_POST['order'][0]['column'];
$rownumawal = $start + 1;
$rownumakhir = $start + $length;

if($module == "pengguna"){
    if($search!=""){
		$filter	=	"	WHERE 	(t1.name like '%$search%'
								or email like '%$search%'
                                or phone like '%$search%'
								)
						";
	}

    $order1 = " order by t1.name ";

    $query1 = "	select t1.id,t1.name,t1.email,t1.phone,t3.name as name_role,is_leader,
					ROW_NUMBER() OVER (".$order1.") AS no_urut	
				    from tb_users t1 
                    left join tb_user_roles t2 on t1.id=t2.user_id
                    left join tb_roles t3 on t3.id=t2.role_id
                    left join tb_team_members t4 on t1.id=t4.user_id
                    
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=1;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $lambang = explode(".",$hasil1['lambang']);
            $lambang = ($lambang[0] !="") ? "../dist/pictures/partai_politik/".$lambang[0].".webp" : "https://via.placeholder.com/50";
            $row 	= array();
            // $row[]	= '<img src="'.$lambang.'" style="width:100%">';
            $row[]	= $hasil1['name'];
            $row[]	= $hasil1['email'];
            $row[]	= $hasil1['phone'];
            $row[]	= ($hasil1['google_id'] != "") ? "Yes" : "No";
            $row[]	= $hasil1['name_role'];
            $row[]	= ($hasil1['is_leader'] != "") ? "Yes" : "No";;
            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;

            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}	    
}elseif($module == "pegawai"){
    if($search!=""){
		$filter	=	"	WHERE 	(t1.name like '%$search%'
								or email like '%$search%'
                                or phone like '%$search%'
								)
						";
	}

    $order1 = " order by t1.name ";

    $query1 = "	select t1.id,t1.name,t1.email,t1.phone,t3.name as name_role, t4.name as nama_cabang,
					ROW_NUMBER() OVER (".$order1.") AS no_urut	
				    from tb_users t1 
                    left join tb_user_roles t2 on t1.id=t2.user_id
                    left join tb_roles t3 on t3.id=t2.role_id
                    left join tb_branches t4 on t2.branch_id = t4.id
                    where t2.role_id in (3,4) 
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=1;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $lambang = explode(".",$hasil1['lambang']);
            $lambang = ($lambang[0] !="") ? "../dist/pictures/partai_politik/".$lambang[0].".webp" : "https://via.placeholder.com/50";
            $row 	= array();
            // $row[]	= '<img src="'.$lambang.'" style="width:100%">';
            $row[]	= $hasil1['name'];
            $row[]	= $hasil1['email'];
            $row[]	= $hasil1['phone'];
            $row[]	= $hasil1['name_role'];
            $row[]	= $hasil1['nama_cabang'];

            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;

            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}	    
}elseif($module == "owner"){
    if($search!=""){
		$filter	=	"	WHERE 	(t1.name like '%$search%'
								or email like '%$search%'
                                or phone like '%$search%'
								)
						";
	}

    $order1 = " order by t1.name ";

    $query1 = "     select t1.id,t1.name,t1.email,t1.phone, t4.business_name, t4.status,
                    ROW_NUMBER() OVER (".$order1.") AS no_urut
				    from tb_owners t4
                    left join tb_users t1 on t1.id=t4.user_id
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=1;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $lambang = explode(".",$hasil1['lambang']);
            $lambang = ($lambang[0] !="") ? "../dist/pictures/partai_politik/".$lambang[0].".webp" : "https://via.placeholder.com/50";
            $row 	= array();
            // $row[]	= '<img src="'.$lambang.'" style="width:100%">';
            $row[]	= $hasil1['name'];
            $row[]	= $hasil1['email'];
            $row[]	= $hasil1['password'];
            $row[]	= $hasil1['phone'];
            $row[]	= $hasil1['business_name'];
            $row[]	= $hasil1['status'];

            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;

            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}	    
}elseif($module == "subcriptions"){
    if($search!=""){
		$filter	=	"	WHERE 	(t2.business_name like '%$search%'
								or t3.name like '%$search%'
								)
						";
	}

    $order1 = " order by t2.business_name ";

    $query1 = "     select t1.id, t2.business_name, t3.name , t3.duration_days, t1.end_date, t1.is_active,
                    ROW_NUMBER() OVER (".$order1.") AS no_urut
				    from tb_subscriptions t1 
                    left join tb_owners t2 on t1.id_owner = t2.id
                    left join tb_packages t3 on t1.id_package = t3.id
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=1;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $row 	= array();
            // $row[]	= '<img src="'.$lambang.'" style="width:100%">';
            $row[]	= $hasil1['business_name'];
            $row[]	= $hasil1['name'];
            $row[]	= $hasil1['duration_days'];
            $row[]	= $hasil1['end_date'];
            $row[]	= $hasil1['is_active'];

            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;

            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}	    
}elseif($module=="paket_langganan"){
    if($search!=""){
		$filter	=	"	WHERE name like '%$search%'
						";
	}

    $order1 = " order by id";

    $query1 = "	select *,
					ROW_NUMBER() OVER (".$order1.") AS no_urut	
				    from tb_packages
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=0;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $row 	= array();
            $row[]  = $rownumawal+$a;
            $row[]	= $hasil1['name'];
            $row[]	= '<div class="text-end">'.$hasil1['max_branches'].'</div>';
            $row[]	= '<div class="text-end">'.$hasil1['max_fields'].'</div>';
            $row[]	= '<div class="text-end">'.$hasil1['price'].'</div>';
            $row[]	= '<div class="text-end">'.$hasil1['duration_days'].'</div>';
            $row[]	= $hasil1['description'];
            $row[]	= ($hasil1['is_trial'] == 1) ? "Ya" : "Tidak";
            $row[]	= ($hasil1['is_recommended'] == 1) ? "Ya" : "Tidak";
            $row[]	= ($hasil1['is_visible'] == 1) ? "Ya" : "Tidak";
            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;
            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}
}elseif($module=="roles"){
    if($search!=""){
		$filter	=	"	WHERE name like '%$search%'
						";
	}

    $order1 = " order by id";

    $query1 = "	select *,
					ROW_NUMBER() OVER (".$order1.") AS no_urut	
				    from tb_roles
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=0;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $row 	= array();
            $row[]  = $rownumawal+$a;
            $row[]	= $hasil1['name'];
            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;
            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}
}elseif($module=="cabang"){
    if($search!=""){
		$filter	=	"	WHERE name like '%$search%'
						";
	}

    $order1 = " order by id";

    $query1 = "	select *,
					ROW_NUMBER() OVER (".$order1.") AS no_urut	
				    from tb_branches
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=0;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $row 	= array();
            $row[]  = $rownumawal+$a;
            $row[]	= $hasil1['name'];
            $row[]	= $hasil1['address'];
            $row[]	= $hasil1['city'];
            $row[]	= $hasil1['phone'];
            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;
            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}
}elseif($module=="lapangan"){
    if($search!=""){
		$filter	=	"	WHERE name like '%$search%'
						";
	}

    $order1 = " order by id";

    $query1 = "	select t1.id, t1.name, sport_type, hourly_price,image_url,active, t2.name as nama_cabang,
					ROW_NUMBER() OVER (".$order1.") AS no_urut	
				    from tb_fields t1 left join tb_branches t2 on t1.branch_id = t2.id
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=0;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $id = base64_encrypt($hasil1['id'],$key);
            $row 	= array();
            $row[]  = $rownumawal+$a;
            $row[]	= $hasil1['nama_cabang'];
            $row[]	= $hasil1['name'];
            $row[]	= $hasil1['sport_type'];
            $row[]	= $hasil1['hourly_price'];
            $row[]	= $hasil1['image_url'];
            $row[]	= $hasil1['active'];
            $row[]	= '<div class="btn-group btn-group-sm">
            <a href="'.$module.'?act=edit&id='.$id.'" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            <a href="'.$module.'?act=hapus&id='.$id.'" class="btn btn-danger"><i class="fas fa-times"></i></a>
            </div>';
            $output['data'][] = $row;
            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}
}elseif($module=="kabkota" || $module == "kecamatan" || $module == "desa_kelurahan" || $module == "provinsi"){
    if($search!=""){
		$filter	=	"	WHERE 	(nama_provinsi like '%$search%'
								or nama_kabkota like '%$search%'
                                or nama_kecamatan like '%$search%'
								)
						";
	}

    $order1 = " order by id_provinsi, id_kabkota, id_kecamatan ";

    $query1 = "	select *,
					ROW_NUMBER() OVER (".$order1.") AS no_urut	
				    from view_kecamatan
				";

    $query  =   "select * from (".$query1." ".$filter." )xxx";
    $stid1 = $conn->query("".$query." WHERE xxx.no_urut>='$rownumawal' and xxx.no_urut<='$rownumakhir' ");

    $query_jumlah = $conn->query("SELECT COUNT(*) as jumlah FROM  (".$query.") xxx ");
    
    $hasil2 = $query_jumlah->fetch_assoc();
    
    $iFilteredTotal = $hasil2['jumlah'];
    $iTotal = $iFilteredTotal;
    $output = array(
		"iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal	
    );    
    $a=0;
	if($iFilteredTotal>0){
        while ( $hasil1 = $stid1->fetch_assoc())
        {   
            $row 	= array();
            $row[]  = $rownumawal+$a;
            $row[]	= $hasil1['nama_provinsi'];
            $row[]	= $hasil1['nama_kabkota'];
            $row[]	= $hasil1['id_kecamatan'];
            $row[]	= $hasil1['nama_kecamatan'];
            $output['data'][] = $row;
            $a++;
        }
    }
	else{	
		$output['data'] = [];
	}
}

echo json_encode($output);
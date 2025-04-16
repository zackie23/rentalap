<?php
// function getDataKelurahan($kecamatan){
    $result = [];
    
    $query = '{
        getListWilayahKelurahan (
            token:"03AFY_a8XbV6qH73f9nQwmHkPJV2OBwQ0pBPEp54dk1Jwf1iqaHZak5Nd7WLodCmNYJsLDny-WkM3b_ca-T8tin8pvzsznc9p-a1mkvYJq5hCY-eWuzFVhPMpHJaBAHYx22vZUjjNZNYGM3hZgXjzGu4s_nov13us0G3pPxr6bk9PiGESzxmROrPXgFjpV55qFLYhunN1XzoSVHPpBjbPj1CMF0TFDj-SuFhmYEJW9f8qZFa9hSaZJHwPaRFDoDoBoJS3PELAhK1zB6Niclkq2VFgU2u5l4RMeAAX9eQjp4brPnzCHmlXHY2v5tq66U4cnKq0vPUk4ikCoLngZUOtCaNixksbsrxLoIPlSZ8sF6g0UGTl2hRaL1zDgtnvHcCzFLHJvewvUkL_VI69ty56vr3_CTM1e2d1vJdxTU-CxnmCir_RA_Y_N40tY0t50XlBAiQo__XGOBSJCMt_xzyTcp5lvab90G--__xH7nkUpPAOU5wEwlovhXvuDUFhRoOEmOZH3F73Q28zprakHfgkRpTeo_Lt7Jn7b-MJrYE-NBBLyg43nzbBHtbMUo4xC9Rsx43hTgut_kgyw1-SrLRLCmWV0KPffoh7J8Q",
            wilayah_id:65541,
            ){
          wilayah_id,
          nama,
          parent,
          singkatan
        }
      }';
    
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode(array('query' => $query)),
        ),
    );
    $context  = stream_context_create($options);
    $response = file_get_contents("https://cekdptonline.kpu.go.id/apilhp", false, $context);
    
    $data = json_decode($response, true);
    
    var_dump($data);
        
        
    
//     return $result;

// }
?>
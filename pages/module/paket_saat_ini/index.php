<?php

$data = $conn->query("SELECT t3.name, t1.end_date, t3.max_fields, t3.max_branches FROM tb_subscriptions t1 
                        left join tb_owners t2 on t1.id_owner = t2.id
                        left join tb_packages t3 on t1.id_package = t3.id  ")->fetch_assoc();
?>
<div class="col-md-6 col-lg-4">
<div class="card">
<div class="card-body text-center">
<i class="fa fa-puzzle-piece text-c-red d-block f-40"></i>
<h4 class="m-t-20"><?php echo $data['name'];?></h4>
<p class="m-b-20">Jumlah Cabang: <?php echo $data['max_fields'];?> <br>Jumlah lapangan: <?php echo $data['max_branches'];?> <br>Expired Date: <?php echo $data['end_date'];?> </p>
<button class="btn btn-danger btn-sm btn-round">Upgrade to VIP</button>
</div>
</div>
</div>

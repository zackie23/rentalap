<?php
$kirim=mail("nurulzakki@gmail.com","Test kirim pesan email","Email ini dikirim dari localhost");
if($kirim){
   echo "email berhasil dikirim";
}else{
   echo "email gagal dikirim";
}
?>
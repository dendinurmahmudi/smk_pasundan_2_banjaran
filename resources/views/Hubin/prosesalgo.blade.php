<?php 
 ?>
 fp tree <br>{{ count($peru2018) }}<br>
 <?php for ($i=0; $i < count($peru2018) ; $i++) { 
 	echo $i."<br>";
 } ?>
 1. @foreach($peru2018 as $p18)
 * {{ $p18->nama_perusahaan }} : {{ $p18->jumlah}}<br>
 @endforeach
 2. @foreach($peru2019 as $p19)
 * {{ $p19->nama_perusahaan }} : {{ $p19->jumlah}}<br>
 @endforeach
 3. @foreach($peru2020 as $p20)
 * {{ $p20->nama_perusahaan }} : {{ $p20->jumlah}}<br>
 @endforeach
<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){

		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/spv/Master/ajax_function')?>",
			cache: false,
		});

		$("#id_sarling").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_anggota_sarling_by_id_sarling'},
				success: function(respond){
					$("#id_anggota_sarling").html(respond);
				}
			})
		});

		$("#id_sarling").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_isian_indikator_by_id_sarling'},
				success: function(respond){
					$("#tampil_indikator").html(respond);
				}
			})
		});

	})

</script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span><a href='<?= site_url('/spv/laporan_sarling'); ?>'>Data Sarling (Sarana Lingkungan)</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Tambah Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-yellow m-bordered" style="background-color:#FAD405;">
		<h3>Catatan</h3>
		<p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('spv/simpan_laporan_sarling');?>" method="post" enctype='multipart/form-data'>
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama Kelompok <span class="required"> * </span></label>
								<div class="col-md-10">
									<select name='id_sarling' id='id_sarling' class="form-control select2-allow-clear" required>
										<option value=''></option>
										<?php
										foreach ($sarling as $key => $value) {
											echo '<option value="'.$value->id_sarling.'">'.$value->nama_tim.' - '.$value->nm_kabupaten.'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<hr>
							<div style='text-align: left'>
								<label class="control-label uppercase" for="form_control_1"><b>Laporan Progres Aspek Fisik</b></label>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label uppercase" for="form_control_1"></label>
								<div class="col-md-10" id='tampil_indikator'>
									<?php
									foreach ($indikator as $key => $in) {
									?>
									<table class='table table-striped table-bordered'>
										<thead>
											<tr>
												<th>Indikator Progres Fisik - <span class='uppercase'><?= $in->master_indikator; ?></span></th>
												<th>Penjelasan Progres Fisik - <span class='uppercase'><?= $in->master_indikator; ?></span></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
												</td>
												<td>
												</td>
											</tr>
										</tbody>
									</table>
									<?php } ?>
								</div>
							</div>
							<hr>
							<div style='text-align: left'>
								<label class="control-label uppercase" for="form_control_1"><b>Laporan Progres Aspek Keuangan</b></label>
								<br><br><b>Penggunaan Anggaran :</b>
							</div>
							<?php
							$no = 0;
							foreach ($indikator as $key => $i) {
								if($i->id_master_indikator=='1'){
									// ini yg baru, yg lama ada 3 master indikator
							?>
							<div class="form-group form-md-line-input has-danger">
								<!-- <label class="col-md-2 control-label" for="form_control_1"><?= $i->master_indikator; ?></label> -->
								<label class="col-md-2 control-label" for="form_control_1"><?= 'Anggaran yg telah terpakai'; ?></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="progres_keuangan_<?= $i->id_master_indikator; ?>" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<span class="help-block"><div id='progres_keuangan_<?= $i->id_master_indikator; ?>'></div></span>
										<!-- Telah dilaporkan Rp 8.000.000,00 pada laporan sebelumnya -->
										<i class="fa fa-list"></i>
									</div>
								</div>
							</div>
							<?php }else{echo'';}} ?>
							<hr>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Keterangan</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="keterangan" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-list"></i>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="form-actions margin-top-10">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="reset" class="btn default">Batal</button>
									<button type="submit" class="btn blue">Simpan</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var jum_arr = <?= count($indikator); ?>;
	for (let i = 0; i < jum_arr; i++) {
		var get_id = 'rupiah'+i;
		var rupiah = document.getElementById(get_id);
		rupiah.addEventListener("keyup", function(e) {
			rupiah.value = formatRupiah(this.value, "Rp. ");
		});

		function formatRupiah(angka, prefix) {
			var number_string = angka.replace(/[^,\d]/g, "").toString(),
				split = number_string.split(","),
				sisa = split[0].length % 3,
				rupiah = split[0].substr(0, sisa),
				ribuan = split[0].substr(sisa).match(/\d{3}/gi);

			if (ribuan) {
				separator = sisa ? "." : "";
				rupiah += separator + ribuan.join(".");
			}

			rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
			return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
		}
	}
</script>
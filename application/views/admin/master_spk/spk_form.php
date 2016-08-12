         <link href="<?php echo base_url('assets/css/select/select2.min.css') ?>" rel="stylesheet">
          <script src="<?php echo base_url('assets/js/select/select2.full.js') ?>"></script>
        <h2 style="margin-top:0px">Spk <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                <label for="varchar">No. SPK <?php echo form_error('nospk') ?></label>
                <input type="text" class="form-control" name="nospk" id="nospk" placeholder="nospk" value="<?php echo $nospk; ?>" />
            </div> 
         <div class="form-group">
                <label for="">Nilai <?php echo form_error('nilai') ?></label>
                <input type="text" class="form-control" name="nilai" id="nilai" placeholder="Nilai" value="<?php echo $nilai; ?>" />
            </div>    
	    <div class="form-group">
                <label for="int">Vendor <?php echo form_error('vendor') ?></label>
                <!-- <input type="text" class="form-control" name="vendor" id="vendor" placeholder="Vendor" value="<?php echo $vendor; ?>" /> -->
                <select class="select2_single form-control" name="vendor" id="vendor" tabindex="-1">
                      <?php 
                        foreach ($option as $key => $value) {
                            if ($vendor==$key) {
                        ?>
                                 <option value="<?php echo $key ?>" selected><?php echo $value; ?></option>
                        <?php                              
                            }else{
                          ?>
                                 <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                            <?php         
                            }
                      ?>  

                      <?php
                        }
                       ?>  
                </select>
            </div>
	    <div class="form-group">
                <label for="date">Tgl Awal <?php echo form_error('tgl_awal') ?></label>
                <input type="text" class="form-control" name="tgl_awal" id="tgl_awal" placeholder="Tgl Awal" value="<?php echo $tgl_awal; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">Masa <?php echo form_error('masa') ?></label>
                <input type="text" class="form-control" name="masa" id="masa" placeholder="masa" value="<?php echo $masa; ?>" />
            </div>
	    <div class="form-group">
                <label for="date">Tgl Akhir <?php echo form_error('tgl_akhir') ?></label>
                <input type="text" class="form-control" name="tgl_akhir" id="tgl_akhir" placeholder="Tgl Akhir" value="<?php echo $tgl_akhir; ?>" />
            </div>
	    <div class="form-group">
                <label for="uraian">Uraian <?php echo form_error('uraian') ?></label>
                <textarea class="form-control" rows="3" name="uraian" id="uraian" placeholder="Uraian"><?php echo $uraian; ?></textarea>
            </div>
	    <div class="form-group">
                <label for="varchar">Kode SKKI/SK KO <?php echo form_error('kode_skki') ?></label>
                <input type="text" class="form-control" name="kode_skki" id="kode_skki" placeholder="Kode SKKI/SK KO" value="<?php echo $kode_skki; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">KET SKKO/I <?php echo form_error('ket_skko') ?></label>
                <input type="text" class="form-control" name="ket_skko" id="ket_skko" placeholder="KET SKKO/I" value="<?php echo $ket_skko; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">No. PA <?php echo form_error('no_pa') ?></label>
                <input type="text" class="form-control" name="no_pa" id="no_pa" placeholder="No. PA" value="<?php echo $no_pa; ?>" />
            </div>
	    <div class="form-group">
                <label for="decimal">Nilai RAB <?php echo form_error('nilai_rab') ?></label>
                <input type="text" class="form-control" name="nilai_rab" id="nilai_rab" placeholder="Nilai RAB" value="<?php echo $nilai_rab; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">No. RKS <?php echo form_error('no_rks') ?></label>
                <input type="text" class="form-control" name="no_rks" id="no_rks" placeholder="NO RKS" value="<?php echo $no_rks; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">Expired <?php echo form_error('expired') ?></label>
                <input type="text" class="form-control" name="expired" id="expired" placeholder="Expired" value="<?php echo $expired; ?>" />
            </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('master_spk') ?>" class="btn btn-default">Cancel</a>
	</form>
    <script type="text/javascript">
    $(document).ready(function(){
         $(".select2_single").select2({
                    placeholder: "Select a state",
                    allowClear: true
                });



                        $(document).ready(function () {
                            $('#tgl_awal').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4",
                                 format: 'DD/MM/YYYY',
                            }, function (start, end, label) {
                                 console.log(start.toISOString(), end.toISOString(), label);
                            });

                            $('#tgl_akhir').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4",
                                format: 'DD/MM/YYYY',
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
       
    });

    </script>
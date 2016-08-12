<style type="text/css">
    th{
        text-align: center;
        vertical-align: center;
    }
</style>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/datatables/tools/css/dataTables.tableTools.css') ?>"/>
     
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Spk List</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?php 
                    if($iscreate==1)
                    echo anchor(site_url('master_spk/create'), 'Create', 'class="btn btn-primary"'); 
                ?>
	    </div>
        </div>
        <table class="table table-striped responsive-utilities jambo_table" id="mytable">
            <thead>
                <tr>
                    <th>No</th>
        		    <th>No.SPK</th>
        		    <th>Nilai</th>
                    <th>Vendor</th>
        		    <th>Tgl Awal</th>
        		    <th>Masa</th>
        		    <th>Tgl Akhir</th>
        		    <th>Uraian</th>
        		    <th>Kode SKKI/SK KO</th>
        		    <th>KET SKKO/I</th>
        		    <th>No.PA</th>
        		    <th>Nilai RAB</th>
        		    <th>No.RKS</th>
        		    <th>Expired</th>
        		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($master_spk_data as $master_spk)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $master_spk->nospk ?></td>
             <td><?php echo $master_spk->nilai ?></td>
		    <td><?php echo $option[$master_spk->vendor] ?></td>
		    <td><?php echo date_for_form($master_spk->tgl_awal) ?></td>
		    <td><?php echo $master_spk->masa ?></td>
		    <td><?php echo date_for_form($master_spk->tgl_akhir) ?></td>
		    <td><?php echo $master_spk->uraian ?></td>
		    <td><?php echo $master_spk->kode_skki ?></td>
		    <td><?php echo $master_spk->ket_skko ?></td>
		    <td><?php echo $master_spk->no_pa ?></td>
		    <td><?php echo $master_spk->nilai_rab ?></td>
		    <td><?php echo $master_spk->no_rks ?></td>
		    <td><?php echo $master_spk->expired ?></td>
		    <td style="text-align:center">
			<?php 
			echo anchor(site_url('master_spk/read/'.$master_spk->id),'<i class="fa fa-eye"></i>'); 
			echo '&nbsp;'; 
            if ($isupdate==1) {
                echo anchor(site_url('master_spk/update/'.$master_spk->id),'<i class="fa fa-pencil"></i>'); 
                echo '&nbsp;'; 
            }
			
			if($isdelete==1)
            echo anchor(site_url('master_spk/delete/'.$master_spk->id),'<i class="fa fa-eraser"></i>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
			?>
		    </td>
	        </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/datatables/js/jquery.dataTables.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
              

                 var oTable = $('#mytable').dataTable({
                    "oLanguage": {
                        "sSearch": "Search all columns:"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [0]
                        } //disables sorting for column one
            ],
                    'iDisplayLength': 12,
                    "sPaginationType": "full_numbers",
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo base_url('assets2/js/Datatables/tools/swf/copy_csv_xls_pdf.swf'); ?>"
                    }
                });
                $("tfoot input").keyup(function () {
                    /* Filter on the column based on the index of this element's parent <th> */
                    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
                });
                $("tfoot input").each(function (i) {
                    asInitVals[i] = this.value;
                });
                $("tfoot input").focus(function () {
                    if (this.className == "search_init") {
                        this.className = "";
                        this.value = "";
                    }
                });
                $("tfoot input").blur(function (i) {
                    if (this.value == "") {
                        this.className = "search_init";
                        this.value = asInitVals[$("tfoot input").index(this)];
                    }
                });


            });
        </script>
 
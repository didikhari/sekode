
<h2 style="margin-top:0px">Vendor <?php echo $button ?></h2>
<form action="<?php echo $action; ?>" method="post">
    <div class="form-group">
        <label for="varchar">Kode <?php echo form_error('venKode') ?></label>
        <input type="text" class="form-control" name="venKode" id="venKode" placeholder="Kode" value="<?php echo $venKode; ?>" />
    </div>
    <div class="form-group">
        <label for="varchar">Name <?php echo form_error('venName') ?></label>
        <input type="text" class="form-control" name="venName" id="venName" placeholder="Name" value="<?php echo $venName; ?>" />
    </div>
    <input type="hidden" name="venId" value="<?php echo $venId; ?>" />
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
    <a href="<?php echo site_url('master_vendor') ?>" class="btn btn-default">Cancel</a>
</form>

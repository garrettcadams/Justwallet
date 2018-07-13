<div class="row">
  <div class="col-md-6 mb-2">
    <h5><?php echo lang('users deposit deposit_cc'); ?></h5>
  </div>
  <div class="col-md-6 mb-2 text-right">
    <p class="text-success"><i class="icon-lock icons"></i> <?php echo lang('users deposit deposit_ssl'); ?></p>
  </div>
</div>

<?if($code_method == "skrill"){?>

<script>
window.onload = function(){
  document.forms['skrill'].submit();
}
</script>

<form action="https://pay.skrill.com" name="skrill" method="post" target="skrill">
           <input type="hidden" name="pay_to_email" value="<?php echo $merchant_account ?>">
           <input type="hidden" name="status_url" value="<?php echo base_url();?>ipn/skrill">
           <input type="hidden" name="return_url" value="<?php echo base_url();?>account/transactions">
           <input type="hidden" name="transaction_id " value="<?php echo $id_transaction ?>">
           <input type="hidden" name="merchant_fields" value="Field1">
           <input type="hidden" name="Field1" value="<?php echo $user['username'] ?>">
           <input type="hidden" name="language" value="EN">
           <input type="hidden" name="amount" value="<?php echo $total_amount; ?>">
           <input type="hidden" name="currency" value="<?php echo $symbol; ?>">
           <input type="hidden" name="detail1_description" value="<?php echo lang('users deposit deposit_for'); ?>:">
           <input type="hidden" name="detail1_text" value="<?php echo $user['username'] ?>">
</form>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 text-center">
         <iframe name="skrill" width="700" height="660" frameBorder="0" scrolling="no">
            Browser not compatible!
         </iframe>
      </div>
    </div>
  </div>
</div>
<?}else{?>

<script>
window.onload = function(){
  document.forms['paygol'].submit();
}
</script>

<form name="paygol" method="post" action="https://www.paygol.com/pay" target="paygol" >
   <input type="hidden" name="pg_serviceid" value="<?php echo $merchant_account ?>">
   <input type="hidden" name="pg_currency" value="<?php echo $symbol; ?>">
   <input type="hidden" name="pg_name" value="<?php echo lang('users deposit deposit_for'); ?> <?php echo $user['username'] ?>">
   <input type="hidden" name="pg_custom" value="<?php echo $user['username'] ?>">
   <input type="hidden" name="pg_price" value="<?php echo $total_amount; ?>">
   <input type="hidden" name="pg_return_url" value="<?php echo base_url();?>account/transactions">
   <input type="hidden" name="pg_cancel_url" value="<?php echo base_url();?>account/deposit">   
</form>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 text-center">
         <iframe name="paygol" width="700" height="660" frameBorder="0" scrolling="no">
            Browser not compatible!
         </iframe>
      </div>
    </div>
  </div>
</div>

<?}?>
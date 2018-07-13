<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users deposit confirm_start'); ?></h5>
  </div>
</div>

<?if($code_method == "coinpayments"){?>

<div class="alert alert-primary" role="alert">
  <?php echo lang('users deposit info_coinpayments'); ?>
</div>

<?}else{?>
<?}?>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans amount'); ?></strong></label>
        <p class="form-control-static"><?php echo $amount; ?> 
          <?if($currency=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans fee'); ?></strong></label>
        <p class="form-control-static"><?php echo $total_fee; ?> 
          <?if($currency=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans sum'); ?></strong></label>
        <p class="form-control-static"><?php echo $total_amount; ?> 
          <?if($currency=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users withdrawal method'); ?></strong></label>
        <p class="form-control-static"><?php echo $method; ?></p>
      </div>
      
      <div class="col-md-12 text-right">
          <?if($code_method == "paypal"){?>
          <?php // Start PayPal form ?>
          <form id="paypal" name=paypal action="https://www.paypal.com/cgi-bin/webscr" method="post">
              <input type="hidden" name="charset" value="utf-8" />
              <input type="hidden" name="cmd" value="_xclick" />
              <input type="hidden" name="item_number" value="<?php echo lang('users deposit deposit_for'); ?> <?php echo $user['username'] ?>" />
              <input type="hidden" name="item_name" value="<?php echo lang('users deposit deposit_for'); ?> <?php echo $this->settings->site_name; ?>" />
              <input type="hidden" name="quantity" value="1" />
              <input type="hidden" name="custom" value="<?php echo $user['username'] ?>" />
              <input type="hidden" name="receiver_email" value="<?php echo $merchant_account; ?>" />
              <input type="hidden" name="business" value="<?php echo $merchant_account; ?>" />
              <input type="hidden" name="notify_url" value="<?php echo base_url();?>ipn/paypal" />
              <input type="hidden" name="return" value="<?php echo base_url();?>account/transactions" />
              <input type="hidden" name="cancel_return" value="<?php echo base_url();?>account/deposit" />
              <input type="hidden" name="no_shipping" value="1" />
              <input type="hidden" name="currency_code" value="<?if($currency=='debit_base'){?><?php echo $this->currencys->display->base_code ?><?}else{?><?}?><?if($currency=='debit_extra1'){?><?php echo $this->currencys->display->extra1_code ?><?}else{?><?}?><?if($currency=='debit_extra2'){?><?php echo $this->currencys->display->extra2_code ?><?}else{?><?}?><?if($currency=='debit_extra3'){?><?php echo $this->currencys->display->extra3_code ?><?}else{?><?}?><?if($currency=='debit_extra4'){?><?php echo $this->currencys->display->extra4_code ?><?}else{?><?}?><?if($currency=='debit_extra5'){?><?php echo $this->currencys->display->extra5_code ?><?}else{?><?}?>"> 
              <input type="hidden" name="no_note" value="1" />
              <input type="hidden" name="amount" value="<?php echo $total_amount; ?>" />
          <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          </form>
          <?php // End PayPal form ?>
          <?}else{?>
          <?}?>
          <?if($code_method == "perfect_m"){?>
          <?php // Start Perfect Money form ?>
          <form action="https://perfectmoney.is/api/step1.asp" method="POST">
          <input type="hidden" name="PAYEE_ACCOUNT" value="<?php echo $merchant_account; ?>">
          <input type="hidden" name="PAYEE_NAME" value="<?php echo lang('users deposit deposit_for'); ?> <?php echo $this->settings->site_name; ?>">
          <input type="hidden" name="PAYMENT_ID" value="<?php echo $user['username'] ?>">
          <input type="hidden" name="PAYMENT_AMOUNT" value="<?php echo $total_amount; ?>">
          <input type="hidden" name="PAYMENT_UNITS" value="<?if($currency=='debit_base'){?><?php echo $this->currencys->display->base_code ?><?}else{?><?}?><?if($currency=='debit_extra1'){?><?php echo $this->currencys->display->extra1_code ?><?}else{?><?}?><?if($currency=='debit_extra2'){?><?php echo $this->currencys->display->extra2_code ?><?}else{?><?}?><?if($currency=='debit_extra3'){?><?php echo $this->currencys->display->extra3_code ?><?}else{?><?}?><?if($currency=='debit_extra4'){?><?php echo $this->currencys->display->extra4_code ?><?}else{?><?}?><?if($currency=='debit_extra5'){?><?php echo $this->currencys->display->extra5_code ?><?}else{?><?}?>">
          <input type="hidden" name="STATUS_URL" value="<?php echo base_url();?>ipn/perfect_money">
          <input type="hidden" name="PAYMENT_URL" value="<?php echo base_url();?>account/transactions">
          <input type="hidden" name="PAYMENT_URL_METHOD" value="GET">
          <input type="hidden" name="NOPAYMENT_URL" value="<?php echo base_url();?>account/deposit">
          <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
          <input type="hidden" name="SUGGESTED_MEMO" value="">
          <input type="hidden" name="BAGGAGE_FIELDS" value="">
          <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          </form>
          <?php // End Perfect Money form ?>
          <?}else{?>
          <?}?>
          <?php // Start ADV Cash form ?>
          <?if($code_method == "advcash"){?>
          <?php // Signature ADV Cash
          $order_id = rand(100000000000, 900000000000);
          
          $arHash = array(
            $merchant_account, //
            $advcash['api_value1'],
            $total_amount, //
            $symbol, //
            $advcash['api_value2'], //
            $order_id //
          );
  
          $ac_sign = hash('sha256', implode(':', $arHash));
  
          ?>
          <form method="post" action="https://wallet.advcash.com/sci/">
             <input type="hidden" name="ac_account_email" value="<?php echo $merchant_account; ?>" />
             <input type="hidden" name="ac_sci_name" value="<?php echo $advcash['api_value1']; ?>" />
             <input type="hidden" name="ac_amount" value="<?php echo $total_amount; ?>" />
             <input type="hidden" name="ac_currency" value="<?if($currency=='debit_base'){?><?php echo $this->currencys->display->base_code ?><?}else{?><?}?><?if($currency=='debit_extra1'){?><?php echo $this->currencys->display->extra1_code ?><?}else{?><?}?><?if($currency=='debit_extra2'){?><?php echo $this->currencys->display->extra2_code ?><?}else{?><?}?><?if($currency=='debit_extra3'){?><?php echo $this->currencys->display->extra3_code ?><?}else{?><?}?><?if($currency=='debit_extra4'){?><?php echo $this->currencys->display->extra4_code ?><?}else{?><?}?><?if($currency=='debit_extra5'){?><?php echo $this->currencys->display->extra5_code ?><?}else{?><?}?>" />
             <input type="hidden" name="ac_order_id" value="<?php echo $order_id; ?>" />
             <input type="hidden" name="ac_sign" value="<?php echo $ac_sign; ?>" />
             <input type="hidden" name="ac_success_url" value="<?php echo base_url();?>account/transactions" />
             <input type="hidden" name="ac_success_url_method" value="GET" />
             <input type="hidden" name="ac_fail_url" value="<?php echo base_url();?>account/deposit" />
             <input type="hidden" name="ac_fail_url_method" value="GET" />
             <input type="hidden" name="ac_status_url" value="<?php echo base_url();?>ipn/advcash" />
             <input type="hidden" name="ac_status_url_method" value="POST" />
             <input type="hidden" name="ac_comments" value="<?php echo $user['username'] ?>" />
             <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          </form>
          <?}else{?>
          <?}?>
          <?php // End ADV Cash form ?>
          <?php // Start Payeer form ?>
          <?if($code_method == "payeer"){?>
            
            <?php
              $m_shop = $merchant_account; // merchant ID
              $m_orderid = rand(100000000000, 900000000000); // invoice number in the merchant's invoicing system
              $m_amount = $total_amount; // invoice amount with two decimal places
              $m_curr = $symbol; // invoice currency
              $m_desc = base64_encode($user['username']); // invoice description encoded using a base64
              $m_key = $payeer['api_value1'];
                                         
              // Forming an array for signature generation
              $arHash = array(
                $m_shop,
                $m_orderid,
                $m_amount,
                $m_curr,
                $m_desc
              );

              // Forming an array for additional parameters
              /*$arParams = array(
                'submerchant' => $this->settings->site_name,
              );
              // Forming a key for encryption
              $key = md5('0000'.$m_orderid);
              // Encrypting additional parameters
              $m_params = urlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, json_encode($arParams), MCRYPT_MODE_ECB)));

              // Adding parameters to the signature-formation array
              $arHash[] = $m_params;
              */
              // Adding the secret key to the signature-formation array
              $arHash[] = $m_key;
              // Forming a signature
              $sign = strtoupper(hash('sha256', implode(':', $arHash)));
              ?>
        
              <form method="post" action="https://payeer.com/merchant/">
              <input type="hidden" name="m_shop" value="<?php echo $m_shop?>">
              <input type="hidden" name="m_orderid" value="<?php echo $m_orderid?>">
              <input type="hidden" name="m_amount" value="<?php echo $m_amount?>">
              <input type="hidden" name="m_curr" value="<?php echo $m_curr?>">
              <input type="hidden" name="m_desc" value="<?php echo $m_desc?>">
              <input type="hidden" name="m_sign" value="<?php echo $sign?>">
              <?php /*
              <input type="hidden" name="form[ps]" value="2609">
              <input type="hidden" name="form[curr[2609]]" value="USD">
              */ ?>
              <?php /* Enable submerchant
              <input type="text" name="m_params" value="<?php echo $m_params?>">
              */ ?>
               <?php /*
              <input type="hidden" name="m_cipher_method" value="AES-256-CBC">
              */ ?>
              <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
              </form>
        
          <?}else{?>
          <?}?>
          <?php // End Payeer form ?>
          <?php // Start Skrill form ?>
          <?if($code_method == "skrill"){?>
          <?php echo form_open(site_url("account/deposit/credit_card"), array("" => "")) ?>
           <input type="hidden" name="amount" value="<?php echo $amount; ?>">
           <input type="hidden" name="currency" value="<?php echo $currency?>">
           <input type="hidden" name="method" value="<?php echo $code_method?>">
           <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          <?php echo form_close(); ?> 
          <?}else{?>
          <?}?>
          <?if($code_method == "paygol"){?>
          <?php echo form_open(site_url("account/deposit/credit_card"), array("" => "")) ?>
           <input type="hidden" name="amount" value="<?php echo $amount; ?>">
           <input type="hidden" name="currency" value="<?php echo $currency?>">
           <input type="hidden" name="method" value="<?php echo $code_method?>">
           <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          <?php echo form_close(); ?> 
          <?}else{?>
          <?}?>
          <?if($code_method == "swift"){?>
          <?php echo form_open(site_url("account/deposit/bank"), array("" => "")) ?>
           <input type="hidden" name="amount" value="<?php echo $amount; ?>">
           <input type="hidden" name="currency" value="<?php echo $currency?>">
           <input type="hidden" name="method" value="<?php echo $code_method?>">
          <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          <?php echo form_close(); ?> 
          <?}else{?>
          <?}?>
          <?if($code_method == "local_bank"){?>
          <?php echo form_open(site_url("account/deposit/bank"), array("" => "")) ?>
           <input type="hidden" name="amount" value="<?php echo $amount; ?>">
           <input type="hidden" name="currency" value="<?php echo $currency?>">
           <input type="hidden" name="method" value="<?php echo $code_method?>">
          <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          <?php echo form_close(); ?> 
          <?}else{?>
          <?}?>
          <?if($code_method == "coinpayments"){?>
          <form method="post" action="https://www.coinpayments.net/index.php">
            <input type="hidden" name="cmd" value="_pay">
            <input type="hidden" name="reset" value="1">
            <input type="hidden" name="merchant" value="<?php echo $merchant_account; ?>">
            <input type="hidden" name="currency" value="<?php echo $symbol; ?>">
            <input type="hidden" name="amountf" value="<?php echo $total_amount; ?>">
            <input type="hidden" name="item_name" value="<?php echo lang('users deposit deposit_for'); ?> <?php echo $this->settings->site_name; ?>">
            <input type="hidden" name="first_name" value="<?php echo $user['first_name'];?>">
            <input type="hidden" name="last_name" value="<?php echo $user['last_name'];?>">
            <input type="hidden" name="email" value="<?php echo $user['email'];?>">
            <input type="hidden" name="custom" value="<?php echo $user['username'];?>">
            <input type="hidden" name="success_url" value="<?php echo base_url();?>account/transactions">
            <input type="hidden" name="cancel_url" value="<?php echo base_url();?>account/deposit">
            <input type="hidden" name="want_shipping" value="0">
            <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          </form>
          <?}else{?>
          <?}?>
          <?if($code_method == "blockchain"){?>
          <?php echo form_open(site_url("account/deposit/blockchain"), array("" => "")) ?>
           <input type="hidden" name="amount" value="<?php echo $amount; ?>">
           <input type="hidden" name="currency" value="<?php echo $currency?>">
           <input type="hidden" name="method" value="<?php echo $code_method?>">
          <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
          <?php echo form_close(); ?> 
          <?}else{?>
          <?}?>
      </div>
    </div>
  </div>
</div>
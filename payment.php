<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

if(isset($_POST['order_pay_btn'])) {
    $order_status = $_POST['order_status'];
   $order_total_price =  $_POST['order_total_price'];
}

?>




<?php 
include('layouts/header.php');

?>




    <!-- payment -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-blod">Payment</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container text-center">



            
        <?php if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid" ) {?>
                    <?php $amount = strval($_POST['order_total_price']); ?>
                    <?php $order_id = $_POST['order_id']; ?>
                    <p>Total Payment: $<?php echo $_POST['order_total_price']; ?></p>

                    <!-- <input class="btn btn-primary" type="submit" value="Pay Now"/> -->
                    <div style="margin-left: 270px;" id="paypal-button-container"></div>


            <?php } else if(isset($_SESSION['total']) && $_SESSION['total'] != 0) {?>
                    <?php $amount = strval ($_SESSION['total']); ?>
                    <?php $order_id = $_SESSION['order_id']; ?>
                <p>Total Payment: $ <?php echo $_SESSION['total'];?></p>

                <!-- <input class="btn btn-primary" type="submit" value="Pay Now"/> -->

                <div style="margin-left: 270px;" id="paypal-button-container"></div>
         
            
               
        
        
             
         
                 

  
                <?php } else { ?>             
                    <p>You don't have an order</p>
                 <?php } ?>


        </div>
     </section>
  

     
    
    
    <script src="https://www.paypal.com/sdk/js?client-id=AZyXFj___Ujm3mXPReDW8CKtd3ZIQG2lXGsOmUsXA_lkTluENZrWsIqayDw_IJygAkeX_KpkIqtPfgx_&currency=USD&components=buttons&enable-funding=venmo,paylater,card"></script>
   
      <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                    purchase_units:[{
                        amount:{
                            value: '<?php echo $amount; ?>'
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData){
                    console.log('Capture result',orderData, JSON.stringify(orderData,null,2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    window.location.href = "server/complete_payment.php?transaction_id="+transaction.id+"&order_id="+<?php echo $order_id; ?>;
                });
            }





        }).render('#paypal-button-container');


      </script>






     

       
        



<?php 
include('layouts/footer.php');
?>


<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "restaurant";

$conn = mysqli_connect($server, $username, $password, $database);
session_start();

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['username'];

if (isset($_POST['ordernow'])) {

   $cardquery = "SELECT card.*,items.price FROM card 
                JOIN items ON card.itemid = items.itemid WHERE card.username='$user_id'";
   $result = mysqli_query($conn, $cardquery);

   if (isset($_SESSION["payed"])) {

      $insert_order_query = "INSERT INTO orderr(username,payed,datee) values('$user_id'," . $_SESSION["payed"] . ",'" . date('Y-m-d') . "')";

      if (isset($_SESSION['table']) && $_SESSION['table'] != 0) {
         $testQuery = "SELECT * FROM orderr WHERE payed=0 AND orderr.table=" . $_SESSION['table'];
         $resultTest = mysqli_query($conn, $testQuery);
         $testt = mysqli_fetch_all($resultTest);
         if (!$testt)
            $insert_order_query = "INSERT INTO orderr(username,orderr.table,datee) values('$user_id'," . $_SESSION['table'] . ",'" . date('Y-m-d') . "')";
         else {
            $orderid = $testt[0][0];
         }
         $_SESSION['table'] = 0;
      }

      $_SESSION["payed"] = 0;
   } else {

      $insert_order_query = "INSERT INTO orderr(username,datee) values('$user_id','" . date('Y-m-d') . "')";

      if (isset($_SESSION['table']) && $_SESSION['table'] != 0) {
         $testQuery = "SELECT * FROM orderr WHERE payed=0 AND orderr.table=" . $_SESSION['table'];
         $resultTest = mysqli_query($conn, $testQuery);
         $testt = mysqli_fetch_all($resultTest);
         if (!$testt)
            $insert_order_query = "INSERT INTO orderr(username,orderr.table,datee) values('$user_id'," . $_SESSION['table'] . ",'" . date('Y-m-d') . "')";
         else {
            $orderid = $testt[0][0];
         }
         $_SESSION['table'] = 0;
      }
   }
   if (!isset($orderid)) {

      mysqli_query($conn, $insert_order_query);
      $orderidquery = "select max(orderid) from orderr where username='$user_id'";
      $result1 = mysqli_query($conn, $orderidquery);
      $orderid = mysqli_fetch_array($result1)[0];
   }

   if (mysqli_num_rows($result) > 0) {
      $grand_total = 0;

      $sqlOrder = "SELECT *FROM orderitem WHERE orderid=$orderid";
      $result2 = mysqli_query($conn, $sqlOrder);

      $existedid = [];
      $existedquant = [];
      $existedprice = [];
      while ($carditems = mysqli_fetch_assoc($result2)) {
         $existedid[count($existedid)] = $carditems['itemid'];
         $existedquant[count($existedquant)] = $carditems['quantity'];
         $existedprice[count($existedprice)] = $carditems['price'];
      }
      // echo "<pre>";
      // print_r($existedid);
      // echo "<pre>";
      $offersql = "SELECT * FROM offer WHERE enddate >= '" . date('Y-m-d') . "' ";
      $resultoffer = mysqli_query($conn, $offersql);
      $offers = mysqli_fetch_all($resultoffer);


      while ($carditems = mysqli_fetch_assoc($result)) {

         $flagg = false;
         $sub_total = $carditems['price'] * $carditems['quantity'];


         for ($i = 0; $i < count($offers); $i++) {
            if ($carditems['itemid'] == $offers[$i][1]) {
               $offprice = $carditems['price'] - $carditems['price'] * $offers[$i][2] / 100;
               $sub_total = $offprice * $carditems['quantity'];
               break;
            }
         }

         for ($i = 0; $i < count($existedid); $i++) {

            if ($carditems['itemid'] == $existedid[$i]) {
               $flagg = true;
               $sub_total += $existedprice[$i];
               $quant = $carditems['quantity'] + $existedquant[$i];
               echo $sub_total;
               $insert_orderitem_query = "UPDATE orderitem SET quantity=$quant , price=$sub_total WHERE itemid= " . $existedid[$i];
            }
         }

         if (!$flagg) {
            $insert_orderitem_query = "INSERT INTO orderitem(orderid, itemid ,quantity, price) 
                                 values('$orderid'," . $carditems['itemid'] . "," . $carditems['quantity'] . ",$sub_total)";
         }
         mysqli_query($conn, $insert_orderitem_query);
      }

      $sqlOrder = "SELECT *FROM orderitem WHERE orderid=$orderid";
      $result2 = mysqli_query($conn, $sqlOrder);

      while ($carditems = mysqli_fetch_assoc($result2)) {
         $grand_total += $carditems['price'];
      }



      $update_orderprice_query = "UPDATE orderr set price=$grand_total where orderid=$orderid ";
      mysqli_query($conn, $update_orderprice_query);
   }
   $delete_all = "DELETE FROM card WHERE username='" . $user_id . "'";
   mysqli_query($conn, $delete_all);
   $_SESSION["card"] = null;

   $sql = "SELECT position from person WHERE username='$user_id'";
   $position = mysqli_fetch_row(mysqli_query($conn, $sql));
   if ($position[0] == 2)
      header("location: cashier.php");


   else
      header("location: user.php");
}

if (isset($_POST['update_qty'])) {
   $card_id = $_POST['card_id'];
   $item_id = $_POST['item_id'];
   $qty = $_POST['qty'];

   $update_qty = "UPDATE card SET quantity='$qty' WHERE itemid='$item_id' and username='$card_id'";
   mysqli_query($conn, $update_qty);

   $_SESSION["card"] = [];

   $sql = "SELECT *FROM card WHERE username='$user_id'";
   $result = mysqli_query($conn, $sql);
   $cardd_items = mysqli_fetch_all($result);

   if (count($cardd_items) > 0) {

      $_SESSION["card"][0] = $cardd_items[0][1];
      for ($i = 1; $i < $cardd_items[0][2]; $i++)
         $_SESSION["card"][$i] = $cardd_items[0][1];

      for ($j = 1; $j < count($cardd_items); $j++) {
         for ($i = 0; $i < $cardd_items[$j][2]; $i++)
            $_SESSION['card'][count($_SESSION['card'])] = $cardd_items[$j][1];
      }
   }
}


if (isset($_POST['delete'])) {
   $item_id = $_POST['item_id'];
   $delete_item = "DELETE FROM card WHERE itemid='$item_id'";
   mysqli_query($conn, $delete_item);
   $_SESSION["card"] = [];

   $sql = "SELECT *FROM card WHERE username='$user_id'";
   $result = mysqli_query($conn, $sql);
   $cardd_items = mysqli_fetch_all($result);

   if (count($cardd_items) > 0) {

      $_SESSION["card"][0] = $cardd_items[0][1];
      for ($i = 1; $i < $cardd_items[0][2]; $i++)
         $_SESSION["card"][$i] = $cardd_items[0][1];

      for ($j = 1; $j < count($cardd_items); $j++) {
         for ($i = 0; $i < $cardd_items[$j][2]; $i++)
            $_SESSION['card'][count($_SESSION['card'])] = $cardd_items[$j][1];
      }
   }
}


if (isset($_POST['delete_all'])) {
   $delete_all = "DELETE FROM card WHERE username='" . $user_id . "'";
   mysqli_query($conn, $delete_all);
   $_SESSION["card"] = null;
}


$grand_total = 0;
$select_card = "SELECT card.*, items.name, items.price, items.photo FROM card 
                JOIN items ON card.itemid = items.itemid WHERE card.username='$user_id'";
$card_items = mysqli_query($conn, $select_card);

$offersql = "SELECT * FROM offer WHERE enddate >= '" . date('Y-m-d') . "' ";
$resultoffer = mysqli_query($conn, $offersql);
$offers = mysqli_fetch_all($resultoffer);





?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/card1.css">
   <title>cart</title>
</head>

<body>
   <div class="heading">
      <h3>Shopping Cart</h3>
   </div>

   <section class="products">
      <!-- <h1 class="title">Your cart</h1> -->
      <div class="box-container">
         <?php if (mysqli_num_rows($card_items) > 0) {
            while ($fetch_card = mysqli_fetch_assoc($card_items)) {
               $sub_total = $fetch_card['price'] * $fetch_card['quantity'];

               $i = 0;
               for ($i = 0; $i < count($offers); $i++) {
                  if ($fetch_card['itemid'] == $offers[$i][1]) {
                     $offprice = $fetch_card['price'] - $fetch_card['price'] * $offers[$i][2] / 100;
                     $sub_total = $offprice * $fetch_card['quantity'];
                     break;
                  }
               }

               $grand_total += $sub_total;



         ?>
               <form action="" method="post" class="box">
                  <input type="hidden" name="card_id" value="<?= $fetch_card['username']; ?>">
                  <input type="hidden" name="item_id" value="<?= $fetch_card['itemid']; ?>">
                  <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('Delete this item?');"></button>


                  <div class="image">
                     <?php
                     if ($i < count($offers)) {
                        echo '<span class="discount-ribbon">' . $offers[$i][2] . ' %</span>';
                     }
                     ?>
                     <img src="<?= $fetch_card['photo']; ?>" alt="">
                  </div>
                  <div class="name"><?= $fetch_card['name']; ?></div>
                  <?php
                  if ($i < count($offers)) {
                  ?>
                     <div class="pric"><?= $fetch_card['price']; ?> L.L</div>
                     <div class="flex">
                        <div class="price"><?= $fetch_card['price'] - $fetch_card['price'] * $offers[$i][2] / 100; ?> L.L</div>
                     <?php
                  } else {
                     ?>
                        <div class="flex">
                           <div class="price"><?= $fetch_card['price']; ?> L.L</div>
                        <?php
                     }
                        ?>

                        <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_card['quantity']; ?>" maxlength="2">
                        <button type="submit" class="fas fa-edit" name="update_qty"></button>
                        </div>
                        <div class="sub-total"> Sub total: <span><?= $sub_total; ?> L.L</span></div>
               </form>
         <?php }
         } else {
            echo '<p class="empty">Your cart is empty</p>';
         } ?>
      </div>

      <div class="card-total">
         <p>cart Total: <span><?= $grand_total; ?> L.L</span></p>
         <form action="" method="post">

            <input type="submit" name="ordernow" class="btn <?= ($grand_total > 0) ? '' : 'disabled'; ?> 
                     " value="order now">
         </form>

      </div>

      <div class="more-btn">
         <form action="" method="post">
            <button type="submit" class="delete-btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('Delete all from card?');">Delete All</button>
         </form>
         <a href="user.php" class="btn">Continue Shopping</a>
      </div>
   </section>

</body>

</html>
<?php

require_once (ABSPATH ."wp-content/plugins/footsphere/bespoke/implement/return.php");

?>

</head>
<body data-spy="scroll" data-target="#navigation" class="page-template-default page page-id-47 logged-in admin-bar mmm mega_main_menu-2-1-4 animated-content mad__queryloader scheme_style_2 woocommerce-account woocommerce-page woocommerce-demo-store woocommerce-js woocommerce-wishlist woocommerce wpb-js-composer js-comp-ver-5.5.2 vc_responsive customize-support">



  <div class="stilim"><div data-spy="scroll" data-target="#navigation" class="page-template-default page page-id-47 logged-in admin-bar mmm mega_main_menu-2-1-4 animated-content mad__queryloader scheme_style_2 woocommerce-account woocommerce-page woocommerce-demo-store woocommerce-js woocommerce-wishlist woocommerce wpb-js-composer js-comp-ver-5.5.2 vc_responsive customize-support" class="col-sm-12" >

    <section class="section-main">
      <div class="woocommerce">

        <nav class="woocommerce-MyAccount-navigation">
          <ul>
          <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard  ">
              <a href="<?php echo $_SERVER['SERVER_NAME'];?>/footsphere_profil">Profil</a>
            </li>
            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders ">
              <a href="<?php echo $_SERVER['SERVER_NAME'];?>/footsphere_bespoke">Bespoke</a>
            </li>
            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--downloads ">
              <a href="<?php echo $_SERVER['SERVER_NAME'];?>/footsphere_contact">İletişim</a>
            </li>
            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address is-active">
             <a href="<?php echo $_SERVER['SERVER_NAME'];?>/footsphere_return">İade</a>
            </li>

          </ul>
        </nav>
        <div class="woocommerce-MyAccount-content">


          <div class="theme_box">
            <div class="col-sm-12">
              <div class="container">

              </div>
              <br><br>
            </div>

            <div class="products">
              <div class="product_item first post-101 product type-product status-publish has-post-thumbnail product_cat-dibaetic product_cat-men instock shipping-taxable purchasable product-type-variable has-default-attributes">

                <div class="product_item last post-104 product type-product status-publish has-post-thumbnail product_cat-dibaetic product_cat-wide product_cat-men first instock shipping-taxable purchasable product-type-variable has-default-attributes">


                  <?php echo $result; ?>
                  </div>
                </div>

                <br>
                <br>
              </div>
            </div>
          </div>
        </div>
      </section>


      <!-- - - - - - - - - - - - -/ Page - - - - - - - - - - - - - - -->


    </div>
  </div>

</body>
</html>


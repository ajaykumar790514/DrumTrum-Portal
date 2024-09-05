 <!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
</header>
 <main class="main">
     
      <input type="hidden" name="page_url" value="<?= $page_url ?>">
        <section class="pt-50 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-menu">
                                <div class="user-profile-header mt-3 text-center">
                                
                                <img src="<?= IMGS_URL.@$user_details->photo; ?>" alt="<?= @$user_details->fname; ?>" onerror="this.src='<?= base_url('assets/img/user/1.jpg'); ?>'" class="img-fluid" />
                                <h4 class="fw-500 mb-0" > <?= @$user_details->fname.' '.@$user_details->lname; ?> </h4>
                                <p class="fw-400 text-brand mb-10">( <?= @$user_details->mobile; ?> )</p>
                                <p class="fw-400 text-brand mb-10">( <?= @$user_details->email; ?> )</p>
<!-- <p class="fw-400 text-brand mb-10">Coin Balance : <strong class="text-secondary"><?= @$coins->balance ? @$coins->balance : 0; ?> </strong></p>-->
                            </div>
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-url="<?= base_url('user/users/profile/') ?>"  href="javascript:void(0)" ><i class="fi-rs-user me-2"></i>Profile</a>
                                        </li>
                                        <li class="nav-item">
                                             <a class="nav-link" data-url="<?= base_url('user/users/address/') ?>"  href="javascript:void(0)" ><i class="fi-rs-marker me-2"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                             <a class="nav-link" data-url="<?= base_url('user/users/order/') ?>"  href="javascript:void(0)" ><i class="fi-rs-shopping-bag me-2"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                             <a class="nav-link" data-url="<?= base_url('user/users/change_password/') ?>"  href="javascript:void(0)" ><i class="fi-rs-key me-2"></i>Change Password</a>
                                        </li>
<!--
                                        <li class="nav-item">
                                             <a class="nav-link" data-url="<?= base_url('user/users/rewards/') ?>"  href="javascript:void(0)" ><i class="fi-rs-settings-sliders me-2"></i>Coin Transactions</a>
                                        </li>
-->
                                    
                                        <li class="nav-item">
                                             <a  href="<?= base_url('logout') ?>" class="nav-link" ><i class="fi-rs-sign-out me-2"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="tab-content dashboard-content">
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<script type="text/javascript">
    $(document).ready(function(){
        let page_url = $('input[name=page_url]').val();
        $('.dashboard-content').load(page_url);

        $('body').on('click', '.nav-link', function(){
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            let page_url = $(this).data('url');
            alert
            $('.dashboard-content').load(page_url);
        });
    });
</script>
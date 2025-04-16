<div class="page-header breadcumb-sticky">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10"><?=$mod_view?></h5>

                </div>
                <ul class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
                    <li class="breadcrumb-item"><a href="dashboard"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?=$module?>"><?=ucwords(str_replace("_"," ",$module))?></a></li>
                    <?php
                        if(isset($_GET['act'])){
                            ?>
                            <li class="breadcrumb-item"><a href="#"><?=ucfirst($_GET['act'])?></a></li>
                            <?php
                        }
                    ?>
                    
                </ul>
                
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div>
            <!-- Nav tabs -->
            <?php if (isset($tabs) && !empty($tabs)) { ?>
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <?php foreach ($tabs as $tab => $value) { ?>
                        <li role="presentation" class="<?php echo (isset($value['class']))?$value['class']:'';?>">
                            <a href="<?php echo $value['link'];?>" aria-controls="<?php echo $tab; ?>" role="tab">
                                <?php echo $value['name']; ?>
                                <?php // echo (isset($value['numero']) && $value['numero']!=0 )? '0':'hidden';?>
                                <span id='<?php echo strtolower($value['name']) ?>' class="badge <?php echo (isset($value['numero']) && $value['numero']!='0')?:'hidden';?>">
                                    <?php if (isset($value['numero']) && !empty($value['numero'])) { ?>  <?php echo $value['numero']; } ?>
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <!-- Tab panes -->
            <div class="tab-content">
                <br>
                <?php
                $this->load->view((isset($tab_panel))?$tab_panel:'')
                ?>
            </div>
        </div>
    </div>
</div>
                <?php
                    $link = FRONT_SITE_URL."/item/".$data->object_id."/".$data->object_slug;
                ?>
                <div class="item">                	
                    <a class="itemLink" href="<?php echo $link;?>">
                    			<button class="ux-button btnQuickLook" onClick="return showPreviewIframe('<?php echo $data->obj_link;?>');" type="button" role="button"><img alt="Quick view" title="Quick view" src="<?php echo $this->layout_asset.'/images/dummy.gif'; ?>" /></button>
                                <div class="detail">
                                    <div align="center" class="imgwrapper">                                        
                                            <img src="<?php echo $data->obj_resize==1 
                                                    ? (IMAGES_URL."/".OsgConstantDefine::IMAGE_RESIZE_FOLDER."/".$data->obj_local_image) 
                                                    : $data->obj_image; ?>" 
                                            alt="<?php echo $data->object_title;?>" 
                                            <?php echo $data->obj_resize!=1 ? "style='width:".OsgConstantDefine::IMAGE_RESIZE_WIDTH."px;height:".OsgConstantDefine::IMAGE_RESIZE_HEIGHT."px'" : "";?>>
                    
                                    </div>
                                    <h2><?php echo $data->obj_brand_name;?></h2>
                                    <p><?php echo $data->object_title;?></p>
                                </div>
                                <div class="prices">
                                    <div class="valueOld">$<?php echo $data->obj_regular_price;?></div>
                                    <div class="value"><?php echo $data->obj_sale_percent;?>%</div>
                                    <div class="btnSell">$<?php echo $data->obj_sale_price;?></div>
                                    <div class="clear"></div>
                                </div>
                    </a>
                </div> 
                            
                
<?php
require $this->base_dir . "inc/data/plugins-data.php";
require_once $this->base_dir . "inc/data/guides-data.php";
?>

<div class="spbhlpr__superb__helper__wrapper">
	<div class="spbhlpr__superb__helper__inner">
		<div class="name-container"><img src="<?php echo esc_url($this->base_url . 'assets/img/superbhelper-icon.png'); ?>" width="45"> <span><?php echo esc_html__('Superb Helper', 'superb-helper') ?></span></div>
		<div class="spbhlpr-plugin-events"><?php $this->spbhlpr_eventHandler(); ?></div>


		<ul class="tabs" role="tablist">
			<li><input type="radio" name="tabs" id="tab1" checked /><label for="tab1" role="tab" aria-selected="true" aria-controls="panel1" tabindex="0"><?php echo esc_html__('Plugins', 'superb-helper') ?></label>
				<div id="tab-content1" class="tab-content" role="tabpanel" aria-labelledby="description" aria-hidden="false">


					<ul>
						<?php
						foreach ($recommended_plugins as &$plugin) {
							$name = $plugin['name'];
							$desc = $plugin['desc'];
							$path = $plugin['path'];
							$slug = $plugin['slug'];
							$url = isset($plugin['url']) ? $plugin['url'] : false;
							$img = $plugin['img'];
						?>

							<li class="spbhlpr__superb__helper__tab__plugin__recomendation__item">
								<div class="spbhlpr__superb__helper__tab__plugin__recomendation__item__left">
									<img src="<?php echo esc_url($this->base_url . 'assets/img/' . $img); ?>" width="45">
								</div>
								<div class="spbhlpr__superb__helper__tab__plugin__recomendation__item__middle">
									<h3><?php echo esc_html($name); ?></h3>
									<p><?php echo esc_html($desc); ?></p>
								</div>
								<div class="spbhlpr__superb__helper__tab__plugin__recomendation__item__right">
									<?php
									if (is_plugin_active($path)) {
										echo "<p class='spbhlpr__superb__helper__tab__plugin__recomendation__item__right_button_activated'><i class='fas fa-toggle-on'></i> Activated</p>";
										if ($url) {
											$plugin_data = get_plugin_data($this->plugin_dir . $path);
											$plugin_version = $plugin_data['Version'];
											echo $plugin_version < 100 ? "<span><a href='" . esc_url($url) . "' target='_blank'>Check out the Premium Version</a></span>" : "<span>Premium Features Installed</span>";
										}
									} else {
										echo '<form method="post"><input type="hidden" name="path" value="' . esc_attr($path) . '" />';
										echo $this->is_plugin_installed($path) ?
											'<input type="hidden" name="spbhlprq" value="activate" /><input type="hidden" id="_wpnonce_spbhlpr" name="_wpnonce_spbhlpr" value="' . esc_attr(wp_create_nonce('spbhlpr_activate_plugin')) . '" /><button type="submit" onclick="spbhlpr_LoadSpinner(\'Activating..\',\'' . esc_attr($name) . '..\')" class="spbhlpr__superb__helper__tab__plugin__recomendation__item__right_button"><i class="fas fa-toggle-off"></i> Activate</button>' :
											'<input type="hidden" name="spbhlprq" value="install" /><input type="hidden" name="slug" value="' . esc_attr($slug) . '" /><input type="hidden" id="_wpnonce_spbhlpr" name="_wpnonce_spbhlpr" value="' . esc_attr(wp_create_nonce('spbhlpr_install_plugin')) . '" /><button type="submit" onclick="spbhlpr_LoadSpinner(\'Installing..\',\'' . esc_attr($name) . '..\')" class="spbhlpr__superb__helper__tab__plugin__recomendation__item__right_button"><i class="fas fa-download"></i> Install</button>';
										echo '</form>';
									}

									?>

								</div>
							</li>
						<?php } ?>

					</ul>



				</div>
			</li>

			<li class="spbhlpr__superb__helper__tab__article__recomendation">
				<input type="radio" name="tabs" id="tab2" />
				<label for="tab2" role="tab" aria-selected="false" aria-controls="panel2" tabindex="0"><span><?php echo esc_html__('Guides', 'superb-helper') ?></label>
				<div id="tab-content2" class="tab-content" role="tabpanel" aria-labelledby="specification" aria-hidden="true">

					<ul>

						<?php
						foreach ($recommended_guides as &$guide) {
							$name = $guide['name'];
							$path = $guide['path'];
							$desc = $guide['desc'];
							$btn = $guide['btn'];
						?>
							<li class="spbhlpr__superb__helper__tab__plugin__recomendation__item">
								<div class="spbhlpr__superb__helper__tab__plugin__recomendation__item__middle">
									<h3><?php echo esc_html($name); ?></h3>
									<p><?php echo esc_html($desc); ?></p>
								</div>
								<div class="spbhlpr__superb__helper__tab__plugin__recomendation__item__right">
									<a href="<?php echo esc_url($path); ?>" target="_blank" rel="nofollow" class="spbhlpr__superb__helper__tab__plugin__recomendation__item__right_button"><i class="fas fa-external-link-alt"></i> <?php echo esc_html($btn); ?></a>
								</div>
							</li>
						<?php } ?>
					</ul>

				</div>
			</li>
		</ul>


	</div>
</div>
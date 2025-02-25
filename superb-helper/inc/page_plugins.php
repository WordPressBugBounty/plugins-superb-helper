<?php
require $this->base_dir . "inc/data/free-plugins.php";
?>
<div class="wrap">
	<h2>Free plugins by SuperbThemes</h2>
	<div class="wp-list-table widefat plugin-install">
		<div class="spbhlpr-plugin-events"><?php $this->spbhlpr_eventHandler(); ?></div>
		<div id="the-list">
			<?php foreach ($free_plugins as &$plugin) {
				$name = $plugin['name'];
				$path = $plugin['path'];
				$slug = $plugin['slug'];
				$url = isset($plugin['url']) ? $plugin['url'] : false;
			?>
				<!-- List item start -->
				<div class="plugin-card plugin-card">
					<div class="plugin-card-top">
						<div class="name column-name superb-helper-page-name">
							<h3>
								<?php echo esc_html($plugin['name']); ?> <img src="<?php echo esc_url($this->base_url . 'assets/img/' . $plugin['img']); ?>" class="plugin-icon superb-helper-page-plugin-icon">
							</h3>
						</div>
						<div class="desc column-description superb-helper-page-desc">
							<p><?php echo esc_html($plugin['desc']); ?></p>
						</div>
					</div>
					<div class="plugin-card-bottom spbhlp-card-bottom">
						<div class="column-compatibility superbhelperpro-recommend-column-compatibility">
							<?php
							if (is_plugin_active($path)) {
								echo "<span class='spbhlpr-activated'>Activated</span>";
								if ($url) {
									$plugin_data = get_plugin_data($this->plugin_dir . $path);
									$plugin_version = $plugin_data['Version'];
									echo $plugin_version < 100 ? "<span class='superbgelperpro-pl-p-pro'><a href='" . esc_url($url) . "' target='_blank'>VIEW PRO</a></span>" : "<span>Premium Features Installed</span>";
								}
							} else {
								echo '<form method="post"><input type="hidden" name="path" value="' . esc_attr($path) . '" />';
								echo $this->is_plugin_installed($path) ?
									'<input type="hidden" name="spbhlprq" value="activate" /><input type="hidden" id="_wpnonce_spbhlpr" name="_wpnonce_spbhlpr" value="' . esc_attr(wp_create_nonce('spbhlpr_activate_plugin')) . '" /><button type="submit" onclick="spbhlpr_LoadSpinner(\'Activating..\',\'' . esc_attr($name) . '..\')" class="install-now button">Activate</button>' :
									'<input type="hidden" name="spbhlprq" value="install" /><input type="hidden" name="slug" value="' . esc_attr($slug) . '" /><input type="hidden" id="_wpnonce_spbhlpr" name="_wpnonce_spbhlpr" value="' . esc_attr(wp_create_nonce('spbhlpr_install_plugin')) . '" /><button type="submit" onclick="spbhlpr_LoadSpinner(\'Installing..\',\'' . esc_attr($name) . '..\')" class="install-now button">Install Plugin</button>';
								echo '</form>';
							}
							?>
						</div>
					</div>
				</div>
				<!-- List item end-->
			<?php
			} ?>
		</div>
	</div>
</div>
<?php
require $this->base_dir . "inc/data/free-themes.php";
?>
<div class="superb-helper-page">
	<div class="wrap">
		<h2>Popular free themes by SuperbThemes</h2>
		<div class="spbhlpr-plugin-events"><?php $this->spbhlpr_eventHandlerTheme(); ?></div>
		<div class="theme-browser rendered">
			<?php foreach ($free_themes as &$theme) {
				$name = $theme['name'];
				$slug = $theme['slug'];
				$url = isset($theme['url']) ? $theme['url'] : false;
			?>
				<!-- Theme start -->
				<div class="theme">
					<div class="theme-screenshot">
						<img src="<?php echo esc_url($this->base_url . 'assets/img/' . $theme['img']); ?>">
					</div>
					<div class="theme-id-container theme-info">
						<h2 class="theme-name"><?php echo esc_html($name); ?></h2>
						<?php
						$theme_data = wp_get_theme();
						if (($theme_data->get_stylesheet() == $slug)) {
							echo "<span class='spbhlpr-activated'>Activated</span>";
							if ($url) {
								$theme_version = $theme_data->parent() ? $theme_data->parent()->Version : $theme_data->Version;
								echo $theme_version < 100 ? "<span class='spbhlpr-chckut-p'><a href='" . esc_url($url) . "' target='_blank'>VIEW PREMIUM VERSION</a></span>" : "<span>Premium Features Installed</span>";
							}
						} else {
							echo '<form method="post"><input type="hidden" name="slug" value="' . esc_attr($slug) . '" />';
							echo $this->is_theme_installed($slug) ?
								'<input type="hidden" name="spbhlprq" value="activate" /><input type="hidden" id="_wpnonce_spbhlpr" name="_wpnonce_spbhlpr" value="' . esc_attr(wp_create_nonce('spbhlpr_activate_theme')) . '" /><button type="submit" onclick="spbhlpr_LoadSpinner(\'Activating..\',\'' . esc_attr($name) . '..\')" class="install-now button">Activate</button>' :
								'<input type="hidden" name="spbhlprq" value="install" /><input type="hidden" id="_wpnonce_spbhlpr" name="_wpnonce_spbhlpr" value="' . esc_attr(wp_create_nonce('spbhlpr_install_theme')) . '" /><button type="submit" onclick="spbhlpr_LoadSpinner(\'Installing..\',\'' . esc_attr($name) . '..\')" class="install-now button">Install Theme</button>';
							echo '</form>';
						} ?>
					</div>
				</div>
				<!-- Theme end -->
			<?php
			} ?>

		</div>
	</div>

</div>